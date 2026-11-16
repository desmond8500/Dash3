<?php

namespace App\Livewire\Tech;

use App\Livewire\Tech\Concerns\TechUi;
use App\Models\Task;
use App\Support\TechService;
use Livewire\Component;
use Livewire\WithPagination;

/** Affectation des tâches Dash3 aux techniciens. */
class TechAssignments extends Component
{
    use TechUi;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';
    public string $scope = 'open';   // open | assigned | unassigned | all
    public $technicianFilter = '';

    public ?int $taskId = null;
    public array $selected = [];

    public function updating($name): void
    {
        if (in_array($name, ['search', 'scope', 'technicianFilter'], true)) {
            $this->resetPage();
        }
    }

    public function assign(int $taskId): void
    {
        $task = Task::with('technicians')->findOrFail($taskId);
        $this->taskId = $task->id;
        $this->selected = $task->technicians->pluck('id')->map(fn ($id) => (string) $id)->all();
        $this->openModal('techAssign');
    }

    public function save(): void
    {
        $task = Task::findOrFail($this->taskId);
        $changes = TechService::assignTask($task, $this->selected, auth()->user());

        $added = count($changes['attached']);
        $removed = count($changes['detached']);
        $this->toast(match (true) {
            $added && $removed => "Affectation mise à jour (+{$added} / −{$removed}).",
            (bool) $added => "{$added} technicien(s) affecté(s).",
            (bool) $removed => "{$removed} technicien(s) retiré(s).",
            default => 'Aucun changement.',
        });

        $this->closeModal('techAssign');
        $this->reset(['taskId', 'selected']);
    }

    public function render()
    {
        $tasks = Task::query()
            ->with(['technicians', 'statut', 'projet', 'client', 'building', 'room'])
            ->when($this->search, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$s}%")
                ->orWhereHas('projet', fn ($p) => $p->where('name', 'like', "%{$s}%"))
                ->orWhereHas('client', fn ($c) => $c->where('name', 'like', "%{$s}%"))))
            ->when($this->scope !== 'all', fn ($q) => $q->where(fn ($w) => $w->whereNull('statut_id')->orWhere('statut_id', '<', 4)))
            ->when($this->scope === 'assigned', fn ($q) => $q->has('technicians'))
            ->when($this->scope === 'unassigned', fn ($q) => $q->doesntHave('technicians'))
            ->when($this->technicianFilter, fn ($q, $id) => $q->whereHas('technicians', fn ($t) => $t->where('users.id', $id)))
            ->orderBy('priority_id')
            ->latest('id')
            ->paginate(15);

        return view('livewire.tech.tech-assignments', [
            'tasks' => $tasks,
            'technicians' => TechService::technicians(),
            'current' => $this->taskId ? Task::find($this->taskId) : null,
        ]);
    }
}
