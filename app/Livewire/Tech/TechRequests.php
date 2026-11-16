<?php

namespace App\Livewire\Tech;

use App\Livewire\Tech\Concerns\TechUi;
use App\Models\TechAccessRequest;
use App\Support\TechService;
use Livewire\Component;
use Livewire\WithFileUploads;

/** Demandes d'accès des techniciens : accepter (partage temporaire) ou refuser. */
class TechRequests extends Component
{
    use TechUi;
    use WithFileUploads;

    public string $status = 'pending'; // pending | approved | rejected | all

    public ?int $requestId = null;
    public string $title = '';
    public string $content = '';
    public string $expires_at = '';
    public string $response = '';
    public $file = null;

    public function approve(int $id): void
    {
        $request = TechAccessRequest::findOrFail($id);
        $this->resetForm();
        $this->requestId = $request->id;
        $this->title = $request->subject;
        $this->setDuration(1);
        $this->openModal('techApprove');
    }

    public function reject(int $id): void
    {
        $this->resetForm();
        $this->requestId = TechAccessRequest::findOrFail($id)->id;
        $this->openModal('techReject');
    }

    public function setDuration(int $days): void
    {
        // 0 = jusqu'à ce soir minuit ; sinon J+n à 18 h
        $date = $days === 0 ? now()->setTime(23, 59) : now()->addDays($days)->setTime(18, 0);
        $this->expires_at = $date->format('Y-m-d\TH:i');
    }

    public function confirmApprove(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:20000'],
            'expires_at' => ['required', 'date'],
            'response' => ['nullable', 'string', 'max:5000'],
            'file' => ['nullable', 'file', 'max:20480'],
        ], [], [
            'title' => 'titre',
            'content' => 'information',
            'expires_at' => 'date de fin d\'accès',
            'file' => 'fichier',
        ]);

        if (! trim($this->content) && ! $this->file) {
            $this->addError('content', 'Ajoutez l\'information ou un fichier à transmettre.');

            return;
        }

        TechService::approveRequest(TechAccessRequest::findOrFail($this->requestId), [
            'title' => trim($this->title),
            'content' => trim($this->content) ?: null,
            'expires_at' => $this->expires_at,
            'response' => trim($this->response) ?: null,
        ], $this->file, auth()->user());

        $this->toast('Accès accordé jusqu\'au '.\Illuminate\Support\Carbon::parse($this->expires_at)->format('d/m/Y H:i').'.');
        $this->closeModal('techApprove');
        $this->resetForm();
        $this->refreshCounters();
    }

    public function confirmReject(): void
    {
        $this->validate(['response' => ['nullable', 'string', 'max:5000']]);

        TechService::rejectRequest(TechAccessRequest::findOrFail($this->requestId), trim($this->response) ?: null, auth()->user());

        $this->toast('Demande refusée.', 'warning');
        $this->closeModal('techReject');
        $this->resetForm();
        $this->refreshCounters();
    }

    private function resetForm(): void
    {
        $this->resetValidation();
        $this->reset(['requestId', 'title', 'content', 'expires_at', 'response', 'file']);
    }

    public function render()
    {
        $requests = TechAccessRequest::with(['user', 'task', 'article', 'decider', 'share'])
            ->when($this->status !== 'all', fn ($q) => $q->where('status', $this->status))
            ->latest()
            ->limit(100)
            ->get();

        return view('livewire.tech.tech-requests', [
            'requests' => $requests,
            'current' => $this->requestId ? TechAccessRequest::with(['user', 'task', 'article'])->find($this->requestId) : null,
            'maxDays' => config('tech.max_share_days', 90),
        ]);
    }
}
