<?php

namespace App\Support;

use App\Models\Article;
use App\Models\Task;
use App\Models\TechAccessRequest;
use App\Models\TechReport;
use App\Models\TechShare;
use App\Models\User;

/**
 * Données renvoyées à l'application technicien.
 * Volontairement réduites : pas de prix, de devis, ni de coordonnées client
 * au-delà du nécessaire sur site.
 */
class TechPresenter
{
    public static function user(User $user): array
    {
        return [
            'id' => $user->id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'function' => $user->function,
            'avatar' => $user->avatar ? url($user->avatar) : null,
        ];
    }

    public static function task(Task $task): array
    {
        return [
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'statut_id' => $task->statut_id,
            'statut' => $task->statut?->name,
            'priority_id' => $task->priority_id,
            'priority' => $task->priority?->name,
            'start_date' => $task->start_date,
            'end_date' => $task->end_date,
            'expiration_date' => $task->expiration_date,
            'client' => $task->client ? ['id' => $task->client->id, 'name' => $task->client->name] : null,
            'projet' => $task->projet ? ['id' => $task->projet->id, 'name' => $task->projet->name] : null,
            'building' => $task->building ? ['id' => $task->building->id, 'name' => $task->building->name] : null,
            'stage' => $task->stage ? ['id' => $task->stage->id, 'name' => $task->stage->name] : null,
            'room' => $task->room ? ['id' => $task->room->id, 'name' => $task->room->name] : null,
            'subtasks' => $task->relationLoaded('subtasks')
                ? $task->subtasks->map(fn ($s) => $s->only(['id', 'name', 'status_id']))->values()
                : [],
            'updated_at' => $task->updated_at?->toIso8601String(),
        ];
    }

    /** Fiche matériel : caractéristiques techniques uniquement (pas de prix ni de stock). */
    public static function article(?Article $article): ?array
    {
        if (! $article) {
            return null;
        }

        return [
            'id' => $article->id,
            'designation' => $article->designation,
            'reference' => $article->reference,
            'description' => $article->description,
            'spec' => $article->spec,
            'brand' => $article->brand?->name,
            'image' => $article->image ? url($article->image) : null,
        ];
    }

    public static function share(TechShare $share, ?User $viewer = null): array
    {
        $pivot = $viewer
            ? $share->technicians->firstWhere('id', $viewer->id)?->pivot
            : null;

        return [
            'id' => $share->id,
            'category' => $share->category,
            'title' => $share->title,
            'content' => $share->content,
            'task_id' => $share->task_id,
            'projet' => $share->projet ? ['id' => $share->projet->id, 'name' => $share->projet->name] : null,
            'building' => $share->building ? ['id' => $share->building->id, 'name' => $share->building->name] : null,
            'article' => self::article($share->article),
            'has_file' => (bool) $share->file_path,
            'file_name' => $share->file_name,
            'expires_at' => $share->expires_at?->toIso8601String(),
            'expires_with_task' => $share->expires_with_task,
            'read_at' => $pivot?->read_at,
            'author' => $share->creator ? trim($share->creator->firstname.' '.$share->creator->lastname) : null,
            'created_at' => $share->created_at?->toIso8601String(),
        ];
    }

    /** Vue administrateur d'un partage (destinataires, état d'expiration). */
    public static function shareAdmin(TechShare $share): array
    {
        return self::share($share) + [
            'active' => $share->isActive(),
            'expired_at' => $share->expired_at?->toIso8601String(),
            'expiry_notified_at' => $share->expiry_notified_at?->toIso8601String(),
            'technicians' => $share->technicians->map(fn (User $u) => [
                'id' => $u->id,
                'name' => trim($u->firstname.' '.$u->lastname),
                'read_at' => $u->pivot->read_at,
            ])->values(),
        ];
    }

    public static function report(TechReport $report): array
    {
        return [
            'id' => $report->id,
            'client_uuid' => $report->client_uuid,
            'task_id' => $report->task_id,
            'task' => $report->task?->name,
            'projet_id' => $report->projet_id,
            'title' => $report->title,
            'content' => $report->content,
            'status' => $report->status,
            'latitude' => $report->latitude,
            'longitude' => $report->longitude,
            'reported_at' => $report->reported_at?->toIso8601String(),
            'review_note' => $report->review_note,
            'reviewed_at' => $report->reviewed_at?->toIso8601String(),
            'photos' => $report->photos->map(fn ($p) => [
                'id' => $p->id,
                'client_uuid' => $p->client_uuid,
                'caption' => $p->caption,
            ])->values(),
            'author' => $report->user ? trim($report->user->firstname.' '.$report->user->lastname) : null,
            'created_at' => $report->created_at?->toIso8601String(),
        ];
    }

    public static function accessRequest(TechAccessRequest $request): array
    {
        return [
            'id' => $request->id,
            'client_uuid' => $request->client_uuid,
            'subject' => $request->subject,
            'reason' => $request->reason,
            'task_id' => $request->task_id,
            'projet_id' => $request->projet_id,
            'article_id' => $request->article_id,
            'status' => $request->status,
            'response' => $request->response,
            'decided_at' => $request->decided_at?->toIso8601String(),
            'tech_share_id' => $request->tech_share_id,
            'requester' => $request->user ? trim($request->user->firstname.' '.$request->user->lastname) : null,
            'created_at' => $request->created_at?->toIso8601String(),
        ];
    }
}
