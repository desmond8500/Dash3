<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Activité d'un technicien à traiter dans Dash3 : nouveau rapport,
 * nouvelle demande d'accès…
 */
class TechActivity extends Notification
{
    use Queueable;

    /**
     * @param  string  $kind  tech_report | tech_access_request
     */
    public function __construct(
        public string $kind,
        public int $subjectId,
        public string $message,
        public array $extra = [],
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'kind' => $this->kind,
            'id' => $this->subjectId,
            'message' => $this->message,
        ] + $this->extra;
    }
}
