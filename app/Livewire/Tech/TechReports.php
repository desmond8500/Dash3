<?php

namespace App\Livewire\Tech;

use App\Livewire\Tech\Concerns\TechUi;
use App\Models\TechReport;
use App\Support\TechService;
use Livewire\Component;
use Livewire\WithPagination;

/** Rapports d'intervention envoyés par les techniciens. */
class TechReports extends Component
{
    use TechUi;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $status = 'submitted'; // submitted | validated | rejected | all
    public $technicianFilter = '';
    public string $search = '';

    public ?int $reportId = null;
    public string $review_note = '';

    public function updating($name): void
    {
        if (in_array($name, ['status', 'technicianFilter', 'search'], true)) {
            $this->resetPage();
        }
    }

    public function show(int $id): void
    {
        $report = TechReport::findOrFail($id);
        $this->resetValidation();
        $this->reportId = $report->id;
        $this->review_note = (string) $report->review_note;
        $this->openModal('techReport');
    }

    public function validateReport(): void
    {
        $this->review('validated', 'Rapport validé.');
    }

    public function requestChanges(): void
    {
        $this->validate(['review_note' => ['required', 'string', 'max:5000']], [
            'review_note.required' => 'Expliquez au technicien ce qu\'il faut revoir.',
        ]);
        $this->review('rejected', 'Rapport renvoyé au technicien.');
    }

    private function review(string $status, string $message): void
    {
        $this->validate(['review_note' => ['nullable', 'string', 'max:5000']]);
        TechService::reviewReport(TechReport::findOrFail($this->reportId), $status, trim($this->review_note) ?: null, auth()->user());
        $this->toast($message);
        $this->closeModal('techReport');
        $this->reset(['reportId', 'review_note']);
        $this->refreshCounters();
    }

    public function render()
    {
        $reports = TechReport::with(['user', 'task', 'photos'])
            ->when($this->status !== 'all', fn ($q) => $q->where('status', $this->status))
            ->when($this->technicianFilter, fn ($q, $id) => $q->where('user_id', $id))
            ->when($this->search, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('title', 'like', "%{$s}%")
                ->orWhere('content', 'like', "%{$s}%")))
            ->latest('reported_at')
            ->paginate(20);

        return view('livewire.tech.tech-reports', [
            'reports' => $reports,
            'technicians' => TechService::technicians(),
            'current' => $this->reportId ? TechReport::with(['user', 'task.projet', 'photos', 'reviewer'])->find($this->reportId) : null,
        ]);
    }
}
