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
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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

        $user = User::create($data); // mot de passe haché par le cast « hashed »
        $user->assignRole(config('tech.role'));

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

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        if (isset($data['password'])) {
            $user->tokens()->delete(); // nouveau mot de passe : reconnexion obligatoire
        }

        return ResponseController::response(true, 'Technicien mis à jour', TechPresenter::user($user));
    }

    /** Désactive l'accès : rôle retiré, sessions de l'application révoquées. */
    public function destroyTechnician(int $id)
    {
        $user = $this->findTechnician($id);

        $user->removeRole(config('tech.role'));
        $user->tokens()->delete();
        DB::table('tech_share_user')->where('user_id', $user->id)->delete();

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

        $ids = $this->technicianIds($data['user_ids']);
        $sync = collect($ids)->mapWithKeys(fn ($id) => [$id => ['assigned_by' => $request->user()->id]])->all();
        $changes = $task->technicians()->sync($sync);

        foreach (TechShare::active()->where('task_id', $task->id)->get() as $share) {
            if ($changes['attached']) {
                $share->technicians()->syncWithoutDetaching($changes['attached']);
            }
            if ($changes['detached']) {
                $share->technicians()->detach($changes['detached']);
            }
        }

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

        $technicianIds = $data['technician_ids'] ?? null;
        $task = isset($data['task_id']) ? Task::find($data['task_id']) : null;
        if ($technicianIds === null && $task) {
            $technicianIds = $task->technicians()->pluck('users.id')->all();
        }
        $technicianIds = $this->technicianIds($technicianIds ?? []);
        if (! $technicianIds) {
            throw ValidationException::withMessages([
                'technician_ids' => 'Choisissez au moins un technicien (ou une tâche qui en a).',
            ]);
        }

        $share = new TechShare(collect($data)->except(['technician_ids', 'file'])->all());
        $share->created_by = $request->user()->id;
        $share->projet_id ??= $task?->projet_id;
        $share->building_id ??= $task?->building_id;

        if ($request->hasFile('file')) {
            $share->file_path = $request->file('file')->store('tech/shares', 'local');
            $share->file_name = $request->file('file')->getClientOriginalName();
        }

        $share->save();
        $share->technicians()->sync($technicianIds);

        return ResponseController::response(true, 'Information partagée',
            TechPresenter::shareAdmin($share->load(['projet', 'building', 'article.brand', 'creator', 'technicians'])));
    }

    /** Modifier ou prolonger un partage encore actif. */
    public function updateShare(Request $request, TechShare $share)
    {
        abort_unless($share->isActive(), 409, 'Ce partage a expiré : créez-en un nouveau.');

        $data = $this->validateShare($request, false);

        if (array_key_exists('technician_ids', $data)) {
            $share->technicians()->sync($this->technicianIds($data['technician_ids'] ?? []));
        }

        $share->fill(collect($data)->except(['technician_ids', 'file'])->all());

        if ($share->isDirty('expires_at')) {
            $share->expiry_notified_at = null; // nouvelle date : nouvelle alerte
        }

        if ($request->hasFile('file')) {
            if ($share->file_path) {
                Storage::disk('local')->delete($share->file_path);
            }
            $share->file_path = $request->file('file')->store('tech/shares', 'local');
            $share->file_name = $request->file('file')->getClientOriginalName();
        }

        $share->save();

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

        $report->update($data + ['reviewed_by' => $request->user()->id, 'reviewed_at' => now()]);

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
            'expires_at' => ['required', 'date', 'after:now', 'before_or_equal:'.now()->addDays(config('tech.max_share_days', 90))->toDateTimeString()],
            'response' => ['nullable', 'string', 'max:5000'],
            'file' => ['nullable', 'file', 'max:20480'],
        ]);

        $share = DB::transaction(function () use ($request, $accessRequest, $data) {
            $share = new TechShare([
                'category' => 'acces',
                'title' => $data['title'] ?? $accessRequest->subject,
                'content' => $data['content'] ?? null,
                'task_id' => $accessRequest->task_id,
                'projet_id' => $accessRequest->projet_id,
                'article_id' => $accessRequest->article_id,
                'expires_at' => Carbon::parse($data['expires_at']),
            ]);
            $share->created_by = $request->user()->id;

            if ($request->hasFile('file')) {
                $share->file_path = $request->file('file')->store('tech/shares', 'local');
                $share->file_name = $request->file('file')->getClientOriginalName();
            }

            $share->save();
            $share->technicians()->sync([$accessRequest->user_id]);

            $accessRequest->update([
                'status' => 'approved',
                'decided_by' => $request->user()->id,
                'decided_at' => now(),
                'response' => $data['response'] ?? null,
                'tech_share_id' => $share->id,
            ]);

            return $share;
        });

        return ResponseController::response(true, 'Accès accordé', [
            'request' => TechPresenter::accessRequest($accessRequest->fresh('user')),
            'share' => TechPresenter::shareAdmin($share->load(['projet', 'building', 'article.brand', 'creator', 'technicians'])),
        ]);
    }

    public function rejectAccessRequest(Request $request, TechAccessRequest $accessRequest)
    {
        abort_unless($accessRequest->status === 'pending', 409, 'Demande déjà traitée');

        $data = $request->validate(['response' => ['nullable', 'string', 'max:5000']]);

        $accessRequest->update([
            'status' => 'rejected',
            'decided_by' => $request->user()->id,
            'decided_at' => now(),
            'response' => $data['response'] ?? null,
        ]);

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

    private function validateShare(Request $request, bool $creating): array
    {
        $max = now()->addDays(config('tech.max_share_days', 90));
        $req = $creating ? 'required' : 'sometimes';

        $data = $request->validate([
            'category' => [$req, Rule::in(TechShare::CATEGORIES)],
            'title' => [$req, 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:20000'],
            'task_id' => ['nullable', 'integer', 'exists:tasks,id'],
            'projet_id' => ['nullable', 'integer', 'exists:projets,id'],
            'article_id' => ['nullable', 'integer', 'exists:articles,id'],
            'building_id' => ['nullable', 'integer', 'exists:buildings,id'],
            'technician_ids' => ['nullable', 'array'],
            'technician_ids.*' => ['integer'],
            'expires_at' => ['nullable', 'date', 'after:now', 'before_or_equal:'.$max->toDateTimeString()],
            'expires_with_task' => ['sometimes', 'boolean'],
            'file' => ['nullable', 'file', 'max:20480'],
        ]);

        if ($creating) {
            $withTask = ! empty($data['expires_with_task']);

            if ($withTask && empty($data['task_id'])) {
                throw ValidationException::withMessages(['task_id' => 'Une tâche est nécessaire pour « expire avec la tâche ».']);
            }
            if (! $withTask && empty($data['expires_at'])) {
                throw ValidationException::withMessages(['expires_at' => 'Indiquez une date d\'expiration : les informations sont temporaires.']);
            }

            // Toujours une date butoir, même liée à une tâche
            $data['expires_at'] = isset($data['expires_at']) ? Carbon::parse($data['expires_at']) : $max;
        } elseif (array_key_exists('expires_at', $data)) {
            if ($data['expires_at'] === null) {
                throw ValidationException::withMessages(['expires_at' => 'Une information doit garder une date d\'expiration.']);
            }
            $data['expires_at'] = Carbon::parse($data['expires_at']);
        }

        return $data;
    }

    /** Ne garde que les identifiants de comptes ayant le rôle technicien. */
    private function technicianIds(array $ids): array
    {
        if (! $ids) {
            return [];
        }

        return User::role(config('tech.role'))->whereIn('id', $ids)->pluck('id')->all();
    }

    private function findTechnician(int $id): User
    {
        return User::role(config('tech.role'))->findOrFail($id);
    }
}
