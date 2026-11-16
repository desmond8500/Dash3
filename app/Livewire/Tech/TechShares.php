<?php

namespace App\Livewire\Tech;

use App\Livewire\Tech\Concerns\TechUi;
use App\Models\Article;
use App\Models\Task;
use App\Models\TechShare;
use App\Support\TechService;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

/** Informations temporaires partagées avec les techniciens. */
class TechShares extends Component
{
    use TechUi;
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $status = 'active'; // active | expired
    public string $search = '';

    // Formulaire
    public ?int $editingId = null;
    public string $category = 'info';
    public string $title = '';
    public string $content = '';
    public $task_id = null;
    public string $taskSearch = '';
    public $article_id = null;
    public string $articleSearch = '';
    public array $technician_ids = [];
    public string $expires_at = '';
    public bool $expires_with_task = false;
    public $file = null;

    public function updating($name): void
    {
        if (in_array($name, ['status', 'search'], true)) {
            $this->resetPage();
        }
    }

    // ------------------------------------------------------------ Formulaire

    public function create(?int $taskId = null): void
    {
        $this->resetForm();
        $this->setDuration(7);
        if ($taskId) {
            $this->selectTask($taskId);
        }
        $this->openModal('techShare');
    }

    public function edit(int $id): void
    {
        $share = TechShare::with('technicians')->findOrFail($id);
        $this->resetForm();
        $this->editingId = $share->id;
        $this->category = $share->category;
        $this->title = $share->title;
        $this->content = (string) $share->content;
        $this->task_id = $share->task_id;
        $this->article_id = $share->article_id;
        $this->technician_ids = $share->technicians->pluck('id')->map(fn ($i) => (string) $i)->all();
        $this->expires_at = $share->expires_at?->format('Y-m-d\TH:i') ?? '';
        $this->expires_with_task = $share->expires_with_task;
        $this->openModal('techShare');
    }

    public function setDuration(int $days): void
    {
        $this->expires_at = now()->addDays($days)->setTime(18, 0)->format('Y-m-d\TH:i');
    }

    public function selectTask(int $id): void
    {
        $task = Task::with('technicians')->find($id);
        if (! $task) {
            return;
        }
        $this->task_id = $task->id;
        $this->taskSearch = '';
        // Par défaut : les techniciens affectés à la tâche
        if (! $this->technician_ids) {
            $this->technician_ids = $task->technicians->pluck('id')->map(fn ($i) => (string) $i)->all();
        }
    }

    public function clearTask(): void
    {
        $this->task_id = null;
        $this->expires_with_task = false;
    }

    public function selectArticle(int $id): void
    {
        $this->article_id = Article::whereKey($id)->value('id');
        $this->articleSearch = '';
        if ($this->article_id && $this->category === 'info') {
            $this->category = 'materiel';
        }
    }

    public function clearArticle(): void
    {
        $this->article_id = null;
    }

    public function save(): void
    {
        $this->validate([
            'category' => ['required', Rule::in(TechShare::CATEGORIES)],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:20000'],
            'task_id' => ['nullable', 'integer', 'exists:tasks,id'],
            'article_id' => ['nullable', 'integer', 'exists:articles,id'],
            'technician_ids' => ['array'],
            'expires_at' => ['nullable', 'date'],
            'expires_with_task' => ['boolean'],
            'file' => ['nullable', 'file', 'max:20480'],
        ], [], [
            'title' => 'titre',
            'content' => 'contenu',
            'expires_at' => 'date d\'expiration',
            'file' => 'fichier',
        ]);

        $data = [
            'category' => $this->category,
            'title' => trim($this->title),
            'content' => trim($this->content) ?: null,
            'task_id' => $this->task_id ?: null,
            'article_id' => $this->article_id ?: null,
            'technician_ids' => $this->technician_ids,
            'expires_at' => $this->expires_at ?: null,
            'expires_with_task' => $this->expires_with_task,
        ];

        if ($this->editingId) {
            TechService::updateShare(TechShare::findOrFail($this->editingId), $data, $this->file);
            $this->toast('Information mise à jour.');
        } else {
            TechService::createShare($data, $this->file, auth()->user());
            $this->toast('Information partagée.');
        }

        $this->closeModal('techShare');
        $this->resetForm();
        $this->refreshCounters();
    }

    // --------------------------------------------------------------- Actions

    public function extend(int $id, int $days): void
    {
        $share = TechShare::findOrFail($id);
        if (! $share->isActive()) {
            $this->toast('Cette information a déjà expiré.', 'warning');

            return;
        }
        TechService::extendShare($share, $days);
        $this->toast("Prolongée jusqu'au ".$share->expires_at->format('d/m/Y H:i'));
    }

    public function withdraw(int $id): void
    {
        TechShare::findOrFail($id)->expireNow();
        $this->toast('Information retirée des téléphones à la prochaine synchronisation.', 'warning');
        $this->refreshCounters();
    }

    private function resetForm(): void
    {
        $this->resetValidation();
        $this->reset([
            'editingId', 'category', 'title', 'content', 'task_id', 'taskSearch', 'article_id',
            'articleSearch', 'technician_ids', 'expires_at', 'expires_with_task', 'file',
        ]);
    }

    public function render()
    {
        $shares = TechShare::with(['technicians', 'task', 'article', 'creator'])
            ->when($this->status === 'active', fn ($q) => $q->active()->orderBy('expires_at'))
            ->when($this->status === 'expired', fn ($q) => $q->whereNotNull('expired_at')->latest('expired_at'))
            ->when($this->search, fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->paginate(20);

        return view('livewire.tech.tech-shares', [
            'shares' => $shares,
            'technicians' => TechService::technicians(),
            'selectedTask' => $this->task_id ? Task::find($this->task_id) : null,
            'selectedArticle' => $this->article_id ? Article::with('brand')->find($this->article_id) : null,
            'taskResults' => strlen($this->taskSearch) >= 2
                ? Task::with('projet')->where('name', 'like', "%{$this->taskSearch}%")
                    ->where(fn ($w) => $w->whereNull('statut_id')->orWhere('statut_id', '<', 5))
                    ->latest('id')->limit(8)->get()
                : collect(),
            'articleResults' => strlen($this->articleSearch) >= 2
                ? Article::where(fn ($w) => $w->where('designation', 'like', "%{$this->articleSearch}%")
                    ->orWhere('reference', 'like', "%{$this->articleSearch}%"))
                    ->limit(8)->get()
                : collect(),
            'warnHours' => config('tech.notify_before_hours', 24),
        ]);
    }
}
