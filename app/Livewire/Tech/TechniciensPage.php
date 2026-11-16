<?php

namespace App\Livewire\Tech;

use App\Models\TechAccessRequest;
use App\Models\TechReport;
use App\Models\TechShare;
use App\Notifications\TechActivity;
use App\Notifications\TechShareExpiring;
use App\Support\TechService;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

/**
 * Espace technicien (Dash3Tech) : alertes, comptes, affectations,
 * informations temporaires, rapports et demandes d'accès.
 */
class TechniciensPage extends Component
{
    public const TABS = ['alertes', 'comptes', 'affectations', 'informations', 'rapports', 'demandes'];

    #[Url]
    public string $tab = 'alertes';

    public $breadcrumbs;

    public function mount(): void
    {
        if (! in_array($this->tab, self::TABS, true)) {
            $this->tab = 'alertes';
        }

        $this->breadcrumbs = [
            ['name' => 'Techniciens', 'route' => route('techniciens')],
        ];
    }

    #[On('tech-tab')]
    public function setTab(string $tab): void
    {
        if (in_array($tab, self::TABS, true)) {
            $this->tab = $tab;
        }
    }

    #[On('tech-counters')]
    public function refreshCounters(): void
    {
        // re-rendu : les compteurs sont recalculés dans render()
    }

    public function render()
    {
        $user = auth()->user();

        return view('livewire.tech.techniciens-page', [
            'counters' => [
                'alertes' => $user->unreadNotifications()
                    ->whereIn('type', [TechShareExpiring::class, TechActivity::class])
                    ->count(),
                'comptes' => TechService::technicians()->count(),
                'informations' => TechShare::active()->count(),
                'rapports' => TechReport::where('status', 'submitted')->count(),
                'demandes' => TechAccessRequest::where('status', 'pending')->count(),
            ],
        ]);
    }
}
