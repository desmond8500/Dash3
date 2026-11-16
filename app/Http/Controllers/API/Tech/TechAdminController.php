<?php

namespace App\Http\Controllers\API\Tech;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseController;
use App\Models\Task;
use App\Models\TechAccessRequest;
use App\Models\TechReport;
use App\Models\TechShare;
use App\Models\User;
use App\Support\TechPresenter;
use App\Support\TechService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * Gestion de l'espace technicien depuis Dash3 (permission « erp ») :
 * comptes, affectations, informations temporaires, rapports et demandes.
 */
class TechAdminController extends Controller
{
    // ------------------------------------------------------------ Techniciens

    public function technicians()
    {
        $users = User::role(config('tech.role'))
            ->withCount(['techTasks', 'techReports'])
            ->orderBy('firstname')
            ->get();

        return ResponseController::response(true, 'Techniciens', $users->map(fn (User $u) => TechPresenter::user($u) + [
            'tasks_count' => $u->tech_tasks_count,
            'reports_count' => $u->tech_reports_count,
        ])->values());
    }

    public function storeTechnician(Request $request)
    {
        $data = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'function' => ['nullable', 'string', 'max:255'],
        ]);

        $user = TechService::createTechnician($data);

        return ResponseController::response(true, 'Technicien créé', TechPresenter::user($user));
    }

    public function updateTechnician(Request $request, int $id)
    {
        $user = $this->findTechnician($id);

        $data = $request->validate([
            'firstname' => ['sometimes', 'required', 'string', 'max:255'],
            'lastname' => ['nullable', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'function' => ['nullable', 'string', 'max:255'],
        ]);

        TechService::updateTechnician($user, $data);

        return ResponseController::response(true, 'Technicien mis à jour', TechPresenter::user($user));
    }

    /** Désactive l'accès : rôle retiré, sessions de l'application révoquées. */
    public function destroyTechnician(int $id)
    {
        $user = $this->findTechnician($id);

        TechService::revokeTechnician($user);

        return ResponseController::response(true, 'Accès technicien retiré', []);
    }

    // -------------------------------------------------------------- Affectation

    public function taskTechnicians(Task $task)
    {
        return ResponseController::response(true, 'Techniciens affectés',
            $task->technicians->map(fn (User $u) => TechPresenter::user($u))->values());
    }

    /**
     * Affecte les techniciens à une tâche. Les informations actives liées à
     * la tâche suivent : nouveaux techniciens ajoutés, techniciens retirés enlevés.
     */
    public function assignTask(Request $request, Task $task)
    {
        $data = $request->validate([
            'user_ids' => ['present', 'array'],
            'user_ids.*' => ['integer'],
        ]);

        TechService::assignTask($task, $data['user_ids'], $request->user());

        return ResponseController::response(true, 'Affectation enregistrée',
            $task->technicians()->get()->map(fn (User $u) => TechPresenter::user($u))->values());
    }

    // ------------------------------------------------------------ Informations

    public function shares(Request $request)
    {
        $status = $request->query('status', 'active');

        $query = TechShare::with(['projet', 'building', 'article.brand', 'creator', 'technicians'])
            ->when($request->query('task_id'), fn ($q, $id) => $q->where('task_id', $id))
            ->when($status === 'active', fn ($q) => $q->active()->orderBy('expires_at'))
            ->when($status === 'expired', fn ($q) => $q->whereNotNull('expired_at')->latest('expired_at'))
            ->when($status === 'all', fn ($q) => $q->latest());

        $page = $query->paginate(30);

        return ResponseController::response(true, 'Informations',
            collect($page->items())->map(fn (TechShare $s) => TechPresenter::shareAdmin($s))->values(),
            ['current_page' => $page->currentPage(), 'last_page' => $page->lastPage()]
        );
    }

    public function storeShare(Request $request)
    {
        $data = $this->validateShare($request, true);
        $share = TechService::createShare($data, $request->file('file'), $request->user());

        return ResponseController::response(true, 'Information partagée',
            TechPresenter::shareAdmin($share->load(['projet', 'building', 'article.brand', 'creator', 'technicians'])));
    }

    /** Modifier ou prolonger un partage encore actif. */
    public function updateShare(Request $request, TechShare $share)
    {
        abort_unless($share->isActive(), 409, 'Ce partage a expiré : créez-en un nouveau.');

        $data = $this->validateShare($request, false);
        TechService::updateShare($share, $data, $request->file('file'));

        return ResponseController::response(true, 'Information mise à jour',
            TechPresenter::shareAdmin($share->load(['projet', 'building', 'article.brand', 'creator', 'technicians'])));
    }

    /** Retirer immédiatement une information (expiration anticipée). */
    public function destroyShare(TechShare $share)
    {
        $share->expireNow();

        return ResponseController::response(true, 'Information retirée', []);
    }

    // --------------------------------------------------------------- Rapports

    public function reports(Request $request)
    {
        $page = TechReport::with(['task', 'photos', 'user'])
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->when($request->query('user_id'), fn ($q, $id) => $q->where('user_id', $id))
            ->when($request->query('task_id'), fn ($q, $id) => $q->where('task_id', $id))
            ->latest()
            ->paginate(30);

        return ResponseController::response(true, 'Rapports',
            collect($page->items())->map(fn (TechReport $r) => TechPresenter::report($r))->values(),
            ['current_page' => $page->currentPage(), 'last_page' => $page->lastPage()]
        );
    }

    public function showReport(TechReport $report)
    {
        return ResponseController::response(true, 'Rapport', TechPresenter::report($report->load(['task', 'photos', 'user'])));
    }

    public function reviewReport(Request $request, TechReport $report)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['validated', 'rejected'])],
            'review_note' => ['nullable', 'string', 'max:5000'],
        ]);

        TechService::reviewReport($report, $data['status'], $data['review_note'] ?? null, $request->user());

        return ResponseController::response(true, 'Rapport mis à jour', TechPresenter::report($report->load(['task', 'photos', 'user'])));
    }

    public function reportPhoto(TechReport $report, int $photo)
    {
        $photo = $report->photos()->findOrFail($photo);
        abort_unless(Storage::disk('local')->exists($photo->path), 404);

        return Storage::disk('local')->response($photo->path);
    }

    // ------------------------------------------------------- Demandes d'accès

    public function accessRequests(Request $request)
    {
        $items = TechAccessRequest::with('user')
            ->when($request->query('status', 'pending'), fn ($q, $s) => $s === 'all' ? $q : $q->where('status', $s))
            ->latest()
            ->limit(200)
            ->get();

        return ResponseController::response(true, 'Demandes', $items->map(fn ($r) => TechPresenter::accessRequest($r))->values());
    }

    /** Accepter : crée une information temporaire réservée au demandeur. */
    public function approveAccessRequest(Request $request, TechAccessRequest $accessRequest)
    {
        abort_unless($accessRequest->status === 'pending', 409, 'Demande déjà traitée');

        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:20000'],
            'expires_at' => ['required', 'date'],
            'response' => ['nullable', 'string', 'max:5000'],
            'file' => ['nullable', 'file', 'max:20480'],
        ]);

        $share = TechService::approveRequest($accessRequest, $data, $request->file('file'), $request->user());

        return ResponseController::response(true, 'Accès accordé', [
            'request' => TechPresenter::accessRequest($accessRequest->fresh('user')),
            'share' => TechPresenter::shareAdmin($share->load(['projet', 'building', 'article.brand', 'creator', 'technicians'])),
        ]);
    }

    public function rejectAccessRequest(Request $request, TechAccessRequest $accessRequest)
    {
        abort_unless($accessRequest->status === 'pending', 409, 'Demande déjà traitée');

        $data = $request->validate(['response' => ['nullable', 'string', 'max:5000']]);

        TechService::rejectRequest($accessRequest, $data['response'] ?? null, $request->user());

        return ResponseController::response(true, 'Demande refusée', TechPresenter::accessRequest($accessRequest->fresh('user')));
    }

    // ---------------------------------------------------------- Notifications

    /** Alertes d'expiration, nouveaux rapports, nouvelles demandes. */
    public function notifications(Request $request)
    {
        $items = $request->user()->notifications()
            ->whereIn('type', [\App\Notifications\TechShareExpiring::class, \App\Notifications\TechActivity::class])
            ->latest()
            ->limit(50)
            ->get()
            ->map(fn ($n) => ['id' => $n->id, 'read_at' => $n->read_at, 'created_at' => $n->created_at] + $n->data);

        return ResponseController::response(true, 'Notifications', $items->values());
    }

    public function readNotification(Request $request, string $id)
    {
        $request->user()->notifications()->whereKey($id)->firstOrFail()->markAsRead();

        return ResponseController::response(true, 'Notification lue', []);
    }

    // ---------------------------------------------------------------- Interne

    /** Validation de forme ; les règles d'expiration sont dans TechService. */
    private function validateShare(Request $request, bool $creating): array
    {
        $req = $creating ? 'required' : 'sometimes';

        return $request->validate([
            'category' => [$req, Rule::in(TechShare::CATEGORIES)],
            'title' => [$req, 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:20000'],
            'task_id' => ['nullable', 'integer', 'exists:tasks,id'],
            'projet_id' => ['nullable', 'integer', 'exists:projets,id'],
            'article_id' => ['nullable', 'integer', 'exists:articles,id'],
            'building_id' => ['nullable', 'integer', 'exists:buildings,id'],
            'technician_ids' => ['nullable', 'array'],
            'technician_ids.*' => ['integer'],
            'expires_at' => ['nullable', 'date'],
            'expires_with_task' => ['sometimes', 'boolean'],
            'file' => ['nullable', 'file', 'max:20480'],
        ]);
    }

    private function findTechnician(int $id): User
    {
        return User::role(config('tech.role'))->findOrFail($id);
    }
}
