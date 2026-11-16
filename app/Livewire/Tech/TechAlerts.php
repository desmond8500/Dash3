<?php

namespace App\Livewire\Tech;

use App\Livewire\Tech\Concerns\TechUi;
use App\Models\TechShare;
use App\Notifications\TechActivity;
use App\Notifications\TechShareExpiring;
use App\Support\TechService;
use Livewire\Component;

/** Alertes : informations qui vont expirer, nouveaux rapports, nouvelles demandes. */
class TechAlerts extends Component
{
    use TechUi;

    public bool $showRead = false;

    public function markRead(string $id): void
    {
        auth()->user()->notifications()->whereKey($id)->first()?->markAsRead();
        $this->refreshCounters();
    }

    public function markAllRead(): void
    {
        auth()->user()->unreadNotifications()
            ->whereIn('type', [TechShareExpiring::class, TechActivity::class])
            ->update(['read_at' => now()]);
        $this->refreshCounters();
    }

    /** Ouvre l'onglet concerné par une notification. */
    public function open(string $id, string $tab): void
    {
        $this->markRead($id);
        $this->dispatch('tech-tab', tab: $tab);
    }

    public function extend(int $shareId, int $days): void
    {
        $share = TechShare::find($shareId);
        if (! $share || ! $share->isActive()) {
            $this->toast('Cette information a déjà expiré.', 'warning');

            return;
        }

        TechService::extendShare($share, $days);
        $this->toast("Prolongée jusqu'au ".$share->expires_at->format('d/m/Y H:i'));
    }

    public function render()
    {
        $notifications = auth()->user()->notifications()
            ->whereIn('type', [TechShareExpiring::class, TechActivity::class])
            ->when(! $this->showRead, fn ($q) => $q->whereNull('read_at'))
            ->latest()
            ->limit(50)
            ->get();

        $expiringSoon = TechShare::active()
            ->with(['technicians', 'task'])
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now()->addHours(config('tech.notify_before_hours', 24)))
            ->orderBy('expires_at')
            ->get();

        return view('livewire.tech.tech-alerts', [
            'notifications' => $notifications,
            'expiringSoon' => $expiringSoon,
        ]);
    }
}
