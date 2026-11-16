<?php

namespace App\Notifications;

use App\Models\TechShare;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** Prévient l'auteur d'un partage technicien que l'information va expirer. */
class TechShareExpiring extends Notification
{
    use Queueable;

    public function __construct(public TechShare $share)
    {
    }

    public function via(object $notifiable): array
    {
        return config('tech.notify_mail') ? ['database', 'mail'] : ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'kind' => 'tech_share_expiring',
            'share_id' => $this->share->id,
            'title' => $this->share->title,
            'expires_at' => $this->share->expires_at?->toIso8601String(),
            'task_id' => $this->share->task_id,
            'technicians' => $this->share->technicians
                ->map(fn ($u) => trim($u->firstname.' '.$u->lastname))
                ->values()
                ->all(),
            'message' => sprintf(
                'L\'information « %s » expire le %s.',
                $this->share->title,
                $this->share->expires_at?->timezone(config('app.timezone'))->format('d/m/Y à H:i')
            ),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new MailMessage)
            ->subject('Dash3Tech : une information va expirer')
            ->line($data['message'])
            ->line('Destinataires : '.(implode(', ', $data['technicians']) ?: '—'))
            ->line('Vous pouvez prolonger le partage depuis Dash3 avant cette date.');
    }
}
