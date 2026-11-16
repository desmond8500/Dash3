<?php

namespace App\Livewire\Tech\Concerns;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

/** Petits utilitaires d'interface communs aux écrans techniciens. */
trait TechUi
{
    protected function toast(string $message, string $type = 'success'): void
    {
        $alert = LivewireAlert::text($message)->position('top-end')->toast()->timer(3000);

        match ($type) {
            'error' => $alert->error(),
            'warning' => $alert->warning(),
            'info' => $alert->info(),
            default => $alert->success(),
        };

        $alert->show();
    }

    protected function openModal(string $id): void
    {
        $this->dispatch("open-{$id}");
    }

    protected function closeModal(string $id): void
    {
        $this->dispatch("close-{$id}");
    }

    /** Rafraîchit les compteurs des onglets. */
    protected function refreshCounters(): void
    {
        $this->dispatch('tech-counters');
    }
}
