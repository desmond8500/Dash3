<?php

namespace App\Support;

use App\Models\Task;
use App\Models\TechAccessRequest;
use App\Models\TechReport;
use App\Models\TechShare;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

/**
 * Règles métier de l'espace technicien, communes à l'API
 * (/api/v1/tech-admin) et aux écrans Livewire de Dash3.
 */
class TechService
{
    // ------------------------------------------------------------ Techniciens

    public static function createTechnician(array $data): User
    {
        $user = User::create($data); // mot de passe haché par le cast « hashed »
        $user->assignRole(config('tech.role'));

        return $user;
    }

    public static function updateTechnician(User $user, array $data): User
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        if (isset($data['password'])) {
            $user->tokens()->delete(); // nouveau mot de passe : reconnexion obligatoire
        }

        return $user;
    }

    /** Retire l'accès : rôle, sessions mobiles et partages en cours. */
    public static function revokeTechnician(User $user): void
    {
        $user->removeRole(config('tech.role'));
        $user->tokens()->delete();
        DB::table('tech_share_user')->where('user_id', $user->id)->delete();
    }

    /** Ne garde que les identifiants de comptes ayant le rôle technicien. */
    public static function technicianIds(array $ids): array
    {
        $ids = array_filter(array_map('intval', $ids));
        if (! $ids) {
            return [];
        }

        return User::role(config('tech.role'))->whereIn('id', $ids)->pluck('id')->all();
    }

    public static function technicians()
    {
        return User::role(config('tech.role'))->orderBy('firstname')->get();
    }

    // -------------------------------------------------------------- Affectation

    /**
     * Affecte les techniciens à une tâche. Les informations actives de la
     * tâche suivent : nouveaux techniciens ajoutés, techniciens retirés enlevés.
     */
    public static function assignTask(Task $task, array $userIds, User $by): array
    {
        $ids = self::technicianIds($userIds);
        $sync = collect($ids)->mapWithKeys(fn ($id) => [$id => ['assigned_by' => $by->id]])->all();
        $changes = $task->technicians()->sync($sync);

        foreach (TechShare::active()->where('task_id', $task->id)->get() as $share) {
            if ($changes['attached']) {
                $share->technicians()->syncWithoutDetaching($changes['attached']);
            }
            if ($changes['detached']) {
                $share->technicians()->detach($changes['detached']);
            }
        }

        return $changes;
    }

    // ------------------------------------------------------------ Informations

    public static function maxExpiry(): Carbon
    {
        return now()->addDays(config('tech.max_share_days', 90));
    }

    /**
     * Crée un partage. $data : category, title, content, task_id, projet_id,
     * article_id, building_id, technician_ids (null = techniciens de la tâche),
     * expires_at, expires_with_task.
     */
    public static function createShare(array $data, ?UploadedFile $file, User $by): TechShare
    {
        $task = ! empty($data['task_id']) ? Task::find($data['task_id']) : null;
        $withTask = ! empty($data['expires_with_task']);

        if ($withTask && ! $task) {
            throw ValidationException::withMessages(['task_id' => 'Une tâche est nécessaire pour « expire avec la tâche ».']);
        }
        if (! $withTask && empty($data['expires_at'])) {
            throw ValidationException::withMessages(['expires_at' => 'Indiquez une date d\'expiration : les informations sont temporaires.']);
        }

        // Toujours une date butoir, même liée à une tâche
        $expiresAt = ! empty($data['expires_at']) ? Carbon::parse($data['expires_at']) : self::maxExpiry();
        self::checkExpiry($expiresAt);

        $technicianIds = $data['technician_ids'] ?? null;
        if (($technicianIds === null || $technicianIds === []) && $task) {
            $technicianIds = $task->technicians()->pluck('users.id')->all();
        }
        $technicianIds = self::technicianIds($technicianIds ?? []);
        if (! $technicianIds) {
            throw ValidationException::withMessages([
                'technician_ids' => 'Choisissez au moins un technicien (ou une tâche qui en a).',
            ]);
        }

        $share = new TechShare([
            'category' => $data['category'] ?? 'info',
            'title' => $data['title'],
            'content' => $data['content'] ?? null,
            'task_id' => $task?->id,
            'projet_id' => $data['projet_id'] ?? $task?->projet_id,
            'article_id' => $data['article_id'] ?? null,
            'building_id' => $data['building_id'] ?? $task?->building_id,
            'expires_at' => $expiresAt,
            'expires_with_task' => $withTask,
        ]);
        $share->created_by = $by->id;
        self::attachFile($share, $file);
        $share->save();
        $share->technicians()->sync($technicianIds);

        return $share;
    }

    /** Modifier ou prolonger un partage encore actif. */
    public static function updateShare(TechShare $share, array $data, ?UploadedFile $file = null): TechShare
    {
        if (! $share->isActive()) {
            throw ValidationException::withMessages(['expires_at' => 'Ce partage a expiré : créez-en un nouveau.']);
        }

        if (array_key_exists('technician_ids', $data)) {
            $ids = self::technicianIds($data['technician_ids'] ?? []);
            if (! $ids) {
                throw ValidationException::withMessages(['technician_ids' => 'Gardez au moins un technicien.']);
            }
            $share->technicians()->sync($ids);
        }

        if (array_key_exists('expires_at', $data)) {
            if (empty($data['expires_at'])) {
                throw ValidationException::withMessages(['expires_at' => 'Une information doit garder une date d\'expiration.']);
            }
            $data['expires_at'] = Carbon::parse($data['expires_at']);
            self::checkExpiry($data['expires_at']);
        }

        if (array_key_exists('expires_with_task', $data) && $data['expires_with_task'] && ! $share->task_id && empty($data['task_id'])) {
            throw ValidationException::withMessages(['task_id' => 'Une tâche est nécessaire pour « expire avec la tâche ».']);
        }

        $share->fill(collect($data)->only([
            'category', 'title', 'content', 'task_id', 'projet_id', 'article_id', 'building_id', 'expires_at', 'expires_with_task',
        ])->all());

        if ($share->isDirty('expires_at')) {
            $share->expiry_notified_at = null; // nouvelle date : nouvelle alerte
        }

        if ($file) {
            if ($share->file_path) {
                Storage::disk('local')->delete($share->file_path);
            }
            self::attachFile($share, $file);
        }

        $share->save();

        return $share;
    }

    /** Prolonge de N jours à partir de l'échéance actuelle (sans dépasser le maximum). */
    public static function extendShare(TechShare $share, int $days): TechShare
    {
        $from = $share->expires_at && $share->expires_at->isFuture() ? $share->expires_at->copy() : now();
        $target = $from->addDays($days);
        if ($target->greaterThan(self::maxExpiry())) {
            $target = self::maxExpiry();
        }

        return self::updateShare($share, ['expires_at' => $target]);
    }

    private static function checkExpiry(Carbon $expiresAt): void
    {
        if ($expiresAt->isPast()) {
            throw ValidationException::withMessages(['expires_at' => 'La date d\'expiration doit être dans le futur.']);
        }
        if ($expiresAt->greaterThan(self::maxExpiry()->addMinute())) {
            throw ValidationException::withMessages([
                'expires_at' => 'Durée maximale : '.config('tech.max_share_days', 90).' jours.',
            ]);
        }
    }

    private static function attachFile(TechShare $share, ?UploadedFile $file): void
    {
        if ($file) {
            $share->file_path = $file->store('tech/shares', 'local');
            $share->file_name = $file->getClientOriginalName();
        }
    }

    // ------------------------------------------------------- Demandes d'accès

    /** Accepter : crée une information temporaire réservée au demandeur. */
    public static function approveRequest(TechAccessRequest $accessRequest, array $data, ?UploadedFile $file, User $by): TechShare
    {
        if ($accessRequest->status !== 'pending') {
            throw ValidationException::withMessages(['status' => 'Demande déjà traitée.']);
        }
        if (empty($data['expires_at'])) {
            throw ValidationException::withMessages(['expires_at' => 'Indiquez jusqu\'à quand l\'accès est accordé.']);
        }

        $expiresAt = Carbon::parse($data['expires_at']);
        self::checkExpiry($expiresAt);

        return DB::transaction(function () use ($accessRequest, $data, $file, $by, $expiresAt) {
            $share = new TechShare([
                'category' => 'acces',
                'title' => ($data['title'] ?? null) ?: $accessRequest->subject,
                'content' => $data['content'] ?? null,
                'task_id' => $accessRequest->task_id,
                'projet_id' => $accessRequest->projet_id,
                'article_id' => $accessRequest->article_id,
                'expires_at' => $expiresAt,
            ]);
            $share->created_by = $by->id;
            self::attachFile($share, $file);
            $share->save();
            $share->technicians()->sync([$accessRequest->user_id]);

            $accessRequest->update([
                'status' => 'approved',
                'decided_by' => $by->id,
                'decided_at' => now(),
                'response' => $data['response'] ?? null,
                'tech_share_id' => $share->id,
            ]);

            return $share;
        });
    }

    public static function rejectRequest(TechAccessRequest $accessRequest, ?string $response, User $by): TechAccessRequest
    {
        if ($accessRequest->status !== 'pending') {
            throw ValidationException::withMessages(['status' => 'Demande déjà traitée.']);
        }

        $accessRequest->update([
            'status' => 'rejected',
            'decided_by' => $by->id,
            'decided_at' => now(),
            'response' => $response,
        ]);

        return $accessRequest;
    }

    // --------------------------------------------------------------- Rapports

    public static function reviewReport(TechReport $report, string $status, ?string $note, User $by): TechReport
    {
        if (! in_array($status, ['validated', 'rejected'], true)) {
            throw ValidationException::withMessages(['status' => 'Statut invalide.']);
        }

        $report->update([
            'status' => $status,
            'review_note' => $note,
            'reviewed_by' => $by->id,
            'reviewed_at' => now(),
        ]);

        return $report;
    }
}
