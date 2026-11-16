<?php

namespace App\Http\Controllers\API\Tech;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Task;
use App\Models\TechAccessRequest;
use App\Models\TechReport;
use App\Models\TechReportPhoto;
use App\Models\TechShare;
use App\Models\User;
use App\Notifications\TechActivity;
use App\Support\TechAdmins;
use App\Support\TechPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * API de l'application Dash3Tech (rôle « technicien », permission « tech »).
 * Un technicien ne voit que ses tâches, les informations qui lui sont
 * partagées et encore valides, ses rapports et ses demandes.
 */
class TechController extends Controller
{
    private const TASK_RELATIONS = ['statut', 'priority', 'client', 'projet', 'building', 'stage', 'room', 'subtasks'];

    private const SHARE_RELATIONS = ['projet', 'building', 'article.brand', 'creator', 'technicians'];

    /** Profil + heure serveur (l'application s'en sert pour les comptes à rebours). */
    public function me(Request $request)
    {
        return ResponseController::response(true, 'Profil technicien', [
            'user' => TechPresenter::user($request->user()),
            'server_time' => now()->toIso8601String(),
            'statuses' => $this->statuses(),
        ]);
    }

    /**
     * Instantané complet pour le mode hors ligne : l'application remplace
     * son cache local par ces données. Une information expirée ou une tâche
     * retirée disparaît donc du téléphone à la synchronisation suivante.
     */
    public function sync(Request $request)
    {
        $user = $request->user();

        return ResponseController::response(true, 'Synchronisation', [
            'server_time' => now()->toIso8601String(),
            'user' => TechPresenter::user($user),
            'statuses' => $this->statuses(),
            'tasks' => $this->tasksQuery($user)->get()->map(fn (Task $t) => TechPresenter::task($t))->values(),
            'shares' => $this->sharesQuery($user)->get()->map(fn (TechShare $s) => TechPresenter::share($s, $user))->values(),
            'reports' => $user->techReports()->with(['task', 'photos', 'user'])->latest()->limit(50)->get()
                ->map(fn (TechReport $r) => TechPresenter::report($r))->values(),
            'access_requests' => $user->techAccessRequests()->with('user')->latest()->limit(50)->get()
                ->map(fn (TechAccessRequest $r) => TechPresenter::accessRequest($r))->values(),
        ]);
    }

    // ------------------------------------------------------------------ Tâches

    public function tasks(Request $request)
    {
        $tasks = $this->tasksQuery($request->user())->get();

        return ResponseController::response(true, 'Tâches', $tasks->map(fn (Task $t) => TechPresenter::task($t))->values());
    }

    public function task(Request $request, int $id)
    {
        $user = $request->user();
        $task = $this->findTask($user, $id);

        $shares = $this->sharesQuery($user)->where('task_id', $task->id)->get();

        return ResponseController::response(true, 'Tâche', TechPresenter::task($task) + [
            'shares' => $shares->map(fn (TechShare $s) => TechPresenter::share($s, $user))->values(),
        ]);
    }

    public function updateTaskStatus(Request $request, int $id)
    {
        $task = $this->findTask($request->user(), $id);

        $data = $request->validate([
            'statut_id' => ['required', 'integer', Rule::in(config('tech.technician_statuses', [1, 2, 3, 4]))],
        ]);

        $task->update(['statut_id' => $data['statut_id']]);

        return ResponseController::response(true, 'Statut mis à jour', TechPresenter::task($task->fresh(self::TASK_RELATIONS)));
    }

    // ------------------------------------------------------------ Informations

    public function shares(Request $request)
    {
        $user = $request->user();

        return ResponseController::response(true, 'Informations', $this->sharesQuery($user)->get()
            ->map(fn (TechShare $s) => TechPresenter::share($s, $user))->values());
    }

    public function share(Request $request, int $id)
    {
        $user = $request->user();
        $share = $this->findShare($user, $id);

        $share->technicians()->updateExistingPivot($user->id, ['read_at' => now()]);
        $share->load('technicians');

        return ResponseController::response(true, 'Information', TechPresenter::share($share, $user));
    }

    /** Pièce jointe : servie uniquement tant que le partage est valide. */
    public function shareFile(Request $request, int $id)
    {
        $share = $this->findShare($request->user(), $id);

        abort_unless($share->file_path && Storage::disk('local')->exists($share->file_path), 404, 'Aucun fichier');

        return Storage::disk('local')->download($share->file_path, $share->file_name);
    }

    // --------------------------------------------------------------- Rapports

    public function reports(Request $request)
    {
        $reports = $request->user()->techReports()->with(['task', 'photos', 'user'])->latest()->paginate(30);

        return ResponseController::response(true, 'Rapports',
            collect($reports->items())->map(fn (TechReport $r) => TechPresenter::report($r))->values(),
            ['current_page' => $reports->currentPage(), 'last_page' => $reports->lastPage()]
        );
    }

    /** Création idempotente : renvoyer le même client_uuid ne crée pas de doublon. */
    public function storeReport(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'client_uuid' => ['required', 'uuid'],
            'task_id' => ['nullable', 'integer'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:20000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'reported_at' => ['nullable', 'date'],
        ]);

        $existing = TechReport::where('client_uuid', $data['client_uuid'])->first();
        if ($existing) {
            abort_unless($existing->user_id === $user->id, 409, 'Identifiant déjà utilisé');

            return ResponseController::response(true, 'Rapport déjà reçu', TechPresenter::report($existing->load(['task', 'photos', 'user'])));
        }

        $task = isset($data['task_id']) ? $this->findTask($user, (int) $data['task_id']) : null;

        $report = TechReport::create(array_merge($data, [
            'user_id' => $user->id,
            'projet_id' => $task?->projet_id,
            'status' => 'submitted',
            'reported_at' => $data['reported_at'] ?? now(),
        ]));

        TechAdmins::notify(new TechActivity(
            'tech_report',
            $report->id,
            sprintf('Nouveau rapport de %s : %s', trim($user->firstname.' '.$user->lastname), $report->title),
            ['task_id' => $report->task_id]
        ));

        return ResponseController::response(true, 'Rapport envoyé', TechPresenter::report($report->load(['task', 'photos', 'user'])));
    }

    public function storeReportPhoto(Request $request, int $id)
    {
        $report = $request->user()->techReports()->findOrFail($id);

        $data = $request->validate([
            'photo' => ['required', 'image', 'max:10240'],
            'client_uuid' => ['nullable', 'uuid'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        if (! empty($data['client_uuid'])) {
            $existing = TechReportPhoto::where('client_uuid', $data['client_uuid'])->first();
            if ($existing) {
                abort_unless($existing->tech_report_id === $report->id, 409, 'Identifiant déjà utilisé');

                return ResponseController::response(true, 'Photo déjà reçue', ['id' => $existing->id, 'client_uuid' => $existing->client_uuid]);
            }
        }

        $path = $request->file('photo')->store("tech/reports/{$report->id}", 'local');

        $photo = $report->photos()->create([
            'client_uuid' => $data['client_uuid'] ?? null,
            'path' => $path,
            'caption' => $data['caption'] ?? null,
        ]);

        return ResponseController::response(true, 'Photo ajoutée', ['id' => $photo->id, 'client_uuid' => $photo->client_uuid]);
    }

    // ------------------------------------------------------- Demandes d'accès

    public function accessRequests(Request $request)
    {
        $items = $request->user()->techAccessRequests()->with('user')->latest()->limit(100)->get();

        return ResponseController::response(true, 'Demandes', $items->map(fn ($r) => TechPresenter::accessRequest($r))->values());
    }

    public function storeAccessRequest(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'client_uuid' => ['required', 'uuid'],
            'subject' => ['required', 'string', 'max:255'],
            'reason' => ['nullable', 'string', 'max:5000'],
            'task_id' => ['nullable', 'integer'],
            'article_id' => ['nullable', 'integer', 'exists:articles,id'],
        ]);

        $existing = TechAccessRequest::where('client_uuid', $data['client_uuid'])->first();
        if ($existing) {
            abort_unless($existing->user_id === $user->id, 409, 'Identifiant déjà utilisé');

            return ResponseController::response(true, 'Demande déjà reçue', TechPresenter::accessRequest($existing->load('user')));
        }

        $task = isset($data['task_id']) ? $this->findTask($user, (int) $data['task_id']) : null;

        $accessRequest = TechAccessRequest::create($data + [
            'user_id' => $user->id,
            'projet_id' => $task?->projet_id,
            'status' => 'pending',
        ]);

        TechAdmins::notify(new TechActivity(
            'tech_access_request',
            $accessRequest->id,
            sprintf('Demande d\'accès de %s : %s', trim($user->firstname.' '.$user->lastname), $accessRequest->subject),
            ['task_id' => $accessRequest->task_id]
        ));

        return ResponseController::response(true, 'Demande envoyée', TechPresenter::accessRequest($accessRequest->load('user')));
    }

    // ---------------------------------------------------------------- Interne

    private function tasksQuery(User $user)
    {
        // Les tâches « Clôturé » (statut 5) ne sont plus utiles sur le terrain
        return $user->techTasks()
            ->with(self::TASK_RELATIONS)
            ->where(fn ($q) => $q->whereNull('statut_id')->orWhere('statut_id', '<', 5))
            ->orderBy('priority_id')
            ->orderBy('start_date');
    }

    private function findTask(User $user, int $id): Task
    {
        return $user->techTasks()->with(self::TASK_RELATIONS)->findOrFail($id);
    }

    private function sharesQuery(User $user)
    {
        return TechShare::active()
            ->visibleTo($user)
            ->with(self::SHARE_RELATIONS)
            ->orderBy('expires_at');
    }

    private function findShare(User $user, int $id): TechShare
    {
        return $this->sharesQuery($user)->findOrFail($id);
    }

    private function statuses(): array
    {
        return \App\Models\TaskStatus::whereIn('id', config('tech.technician_statuses', [1, 2, 3, 4]))
            ->orderBy('level')
            ->get(['id', 'name'])
            ->toArray();
    }
}
