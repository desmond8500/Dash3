<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\JournalImage;
use App\Models\JournalSection;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Sections d'un journal : titre, description en markdown, photos et liste de tâches.
 */
new class extends Component {
    use WithPagination;
    use WithFileUploads;

    public $journal_id;
    public $name;
    public $description;
    public $order;
    public $selected;

    function mount($journal_id)
    {
        $this->journal_id = $journal_id;
        $this->order = JournalSection::where('journal_id', $this->journal_id)->count() + 1;
    }

    public function with(): array
    {
        return [
            'sections' => JournalSection::where('journal_id', $this->journal_id)
                ->with(['images', 'tasks.statut'])
                ->orderBy('order')
                ->orderBy('id')
                ->paginate(10),
        ];
    }

    // ---------- Sections ----------
    function store()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
        ]);
        JournalSection::create([
            'journal_id' => $this->journal_id,
            'name' => $this->name,
            'description' => $this->description,
            'order' => $this->order ?: JournalSection::where('journal_id', $this->journal_id)->count() + 1,
        ]);
        $this->reset(['name', 'description']);
        $this->order = JournalSection::where('journal_id', $this->journal_id)->count() + 1;
        $this->dispatch('markdown-editor-set', id: 'journal-section-description', value: '');
        $this->dispatch('close-addJournalSection');
    }

    function edit($id)
    {
        $this->selected = JournalSection::find($id);
        $this->name = $this->selected->name;
        $this->description = $this->selected->description;
        $this->order = $this->selected->order;
        // Remplit l'éditeur markdown, que Livewire ne met pas à jour (wire:ignore)
        $this->dispatch('markdown-editor-set', id: 'journal-section-description', value: $this->selected->description ?? '');
        $this->dispatch('open-editJournalSection');
    }

    function update()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
        ]);
        $this->selected->update([
            'name' => $this->name,
            'description' => $this->description,
            'order' => $this->order,
        ]);
        $this->dispatch('close-editJournalSection');
    }

    function delete($id)
    {
        $section = JournalSection::find($id);
        if (! $section) return;
        foreach ($section->images as $image) {
            Storage::disk('public')->delete(Str::after($image->folder, 'storage/'));
            $image->delete();
        }
        Task::where('journal_section_id', $section->id)->update(['journal_section_id' => null]);
        $section->delete();
    }

    function down($id)
    {
        $section = JournalSection::find($id);
        $section->order++;
        $section->save();
    }

    function up($id)
    {
        $section = JournalSection::find($id);
        if ($section->order > 0) {
            $section->order--;
        }
        $section->save();
    }

    function generer_section($title, $content)
    {
        JournalSection::create([
            'journal_id' => $this->journal_id,
            'name' => $title,
            'description' => $content,
            'order' => JournalSection::where('journal_id', $this->journal_id)->count() + 1,
        ]);
    }

    // ---------- Photos ----------
    public $photos = [];
    public $photo_section_id;

    function add_photos($section_id)
    {
        $this->photo_section_id = $section_id;
        $this->reset('photos');
        $this->dispatch('open-addSectionPhotos');
    }

    function store_photos()
    {
        $this->validate(['photos' => ['required', 'array'], 'photos.*' => ['image', 'max:8192']]);
        $section = JournalSection::find($this->photo_section_id);
        if (! $section) return;

        $dir = "erp/journaux/{$section->journal_id}/sections/{$section->id}";
        foreach ($this->photos as $photo) {
            $name = Str::random(12) . '.' . strtolower($photo->getClientOriginalExtension());
            $photo->storeAs("public/$dir", $name);
            JournalImage::create([
                'journal_id' => $section->journal_id,
                'journal_section_id' => $section->id,
                'folder' => "storage/$dir/$name",
            ]);
        }
        $this->reset('photos');
        $this->dispatch('close-addSectionPhotos');
    }

    function delete_photo($image_id)
    {
        $image = JournalImage::find($image_id);
        if (! $image) return;
        Storage::disk('public')->delete(Str::after($image->folder, 'storage/'));
        $image->delete();
    }

    // ---------- Tâches de la section ----------
    public $task_section_id;
    public $task_name;

    function add_task($section_id)
    {
        $this->task_section_id = $section_id;
        $this->reset('task_name');
        $this->dispatch('open-addSectionTask');
    }

    function store_task()
    {
        $this->validate(['task_name' => ['required', 'string', 'max:255']]);
        $section = JournalSection::find($this->task_section_id);
        if (! $section) return;

        Task::create([
            'name' => $this->task_name,
            'journal_id' => $section->journal_id,
            'journal_section_id' => $section->id,
            'projet_id' => $section->journal->projet_id ?? null,
            'statut_id' => 1,
            'priority_id' => 1,
        ]);
        $this->reset('task_name');
        $this->dispatch('close-addSectionTask');
    }

    /** Terminée (4) ↔ nouvelle (1) */
    function toggle_task($task_id)
    {
        $task = Task::find($task_id);
        if (! $task) return;
        $task->update(['statut_id' => $task->statut_id >= 4 ? 1 : 4]);
    }

    function delete_task($task_id)
    {
        Task::find($task_id)?->delete();
    }
}; ?>

<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Sections</div>
            <div class="card-actions">
                <div class="btn-list">
                    <button class="btn btn-primary" wire:click="$dispatch('open-addJournalSection')">
                        <i class="ti ti-plus"></i> Section
                    </button>
                    <div class="dropdown open">
                        <button class="btn btn-action" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" wire:click="generer_section('Travaux en cours','')"> <i class="ti ti-edit"></i> Travaux en cours</a>
                            <a class="dropdown-item" wire:click="generer_section('Travaux effectués','')"> <i class="ti ti-edit"></i> Travaux effectués</a>
                            <a class="dropdown-item" wire:click="generer_section('Recommandations','')"> <i class="ti ti-edit"></i> Recommandations</a>
                            <a class="dropdown-item" wire:click="generer_section('Notes','')"> <i class="ti ti-edit"></i> Notes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2">
            @forelse ($sections as $section)
                <div class="card border border-primary mb-2 p-2" wire:key="section-{{ $section->id }}">
                    <div class="row g-1">
                        <div class="col">
                            <div class="fw-bold">{{ $section->name }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="btn-list">
                                <button class="btn btn-sm rounded btn-purple btn-icon" title="Monter" wire:click="up('{{ $section->id }}')">
                                    <i class="ti ti-arrow-big-up"></i>
                                </button>
                                <button class="btn btn-sm rounded btn-outline-purple">{{ $section->order }}</button>
                                <button class="btn btn-sm rounded btn-purple btn-icon" title="Descendre" wire:click="down('{{ $section->id }}')">
                                    <i class="ti ti-arrow-big-down"></i>
                                </button>
                                <button class="btn btn-sm rounded btn-outline-primary btn-icon" title="Ajouter des photos" wire:click="add_photos('{{ $section->id }}')">
                                    <i class="ti ti-camera"></i>
                                </button>
                                <button class="btn btn-sm rounded btn-outline-primary btn-icon" title="Ajouter une tâche" wire:click="add_task('{{ $section->id }}')">
                                    <i class="ti ti-checkbox"></i>
                                </button>
                                <button class="btn btn-sm rounded btn-primary btn-icon" title="Modifier" wire:click="edit('{{ $section->id }}')">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <button class="btn btn-sm rounded btn-danger btn-icon" title="Supprimer" wire:click="delete('{{ $section->id }}')"
                                    wire:confirm="Supprimer la section « {{ $section->name }} » et ses photos ?">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <x-markdown>{{ $section->description }}</x-markdown>
                        </div>

                        {{-- Photos de la section --}}
                        @if ($section->images->count())
                            <div class="col-md-12">
                                <div class="row g-1">
                                    @foreach ($section->images as $image)
                                        <div class="col-auto" wire:key="image-{{ $image->id }}">
                                            <div class="position-relative">
                                                <a href="{{ asset($image->folder) }}" data-lightbox="section-{{ $section->id }}">
                                                    <img src="{{ asset($image->folder) }}" alt="" class="rounded" style="height: 90px; width: 110px; object-fit: cover;">
                                                </a>
                                                <button class="btn btn-sm btn-icon position-absolute" style="top: 2px; right: 2px;"
                                                    title="Supprimer la photo" wire:click="delete_photo('{{ $image->id }}')"
                                                    wire:confirm="Supprimer cette photo ?">
                                                    <i class="ti ti-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Tâches de la section --}}
                        @if ($section->tasks->count())
                            <div class="col-md-12 mt-1">
                                <div class="list-group list-group-flush">
                                    @foreach ($section->tasks as $task)
                                        <div class="list-group-item py-1 px-0 d-flex align-items-center" wire:key="task-{{ $task->id }}">
                                            <button class="btn btn-sm btn-icon btn-ghost-secondary" title="Changer le statut" wire:click="toggle_task('{{ $task->id }}')">
                                                <i class="ti {{ $task->statut_id >= 4 ? 'ti-checkbox text-success' : 'ti-square' }}"></i>
                                            </button>
                                            <span @class(['ms-1', 'text-decoration-line-through text-muted' => $task->statut_id >= 4])>{{ $task->name }}</span>
                                            <span class="badge bg-blue-lt ms-2">{{ $task->statut->name ?? '' }}</span>
                                            <button class="btn btn-sm btn-icon btn-ghost-danger ms-auto" title="Supprimer la tâche"
                                                wire:click="delete_task('{{ $task->id }}')" wire:confirm="Supprimer la tâche « {{ $task->name }} » ?">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-muted">Aucune section. Ajoutez une section pour décrire l'intervention, joindre des photos et lister les tâches.</div>
            @endforelse

            @if ($sections->hasPages())
                <div class="mt-2">{{ $sections->links() }}</div>
            @endif
        </div>
    </div>

    @component('components.modal', ["id"=>'addJournalSection', 'title' => 'Ajouter une section', 'method'=>"store"])
        <form class="row" wire:submit="store">
            @include('_form.journalSection_form')
        </form>
        <script> window.addEventListener('open-addJournalSection', event => { window.$('#addJournalSection').modal('show'); }) </script>
        <script> window.addEventListener('close-addJournalSection', event => { window.$('#addJournalSection').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editJournalSection', 'title' => 'Editer une section', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.journalSection_form')
        </form>
        <script> window.addEventListener('open-editJournalSection', event => { window.$('#editJournalSection').modal('show'); }) </script>
        <script> window.addEventListener('close-editJournalSection', event => { window.$('#editJournalSection').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addSectionPhotos', 'title' => 'Ajouter des photos', 'method'=>'store_photos'])
        <form wire:submit="store_photos">
            <div wire:loading wire:target="photos" class="mb-2">
                Chargement <div class="spinner-border spinner-border-sm" role="status"></div>
            </div>
            <input type="file" class="form-control" accept="image/*" multiple wire:model="photos">
            @error('photos') <span class='text-danger'>{{ $message }}</span> @enderror
            @error('photos.*') <span class='text-danger'>{{ $message }}</span> @enderror
        </form>
        <script> window.addEventListener('open-addSectionPhotos', event => { window.$('#addSectionPhotos').modal('show'); }) </script>
        <script> window.addEventListener('close-addSectionPhotos', event => { window.$('#addSectionPhotos').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'addSectionTask', 'title' => 'Ajouter une tâche', 'method'=>'store_task'])
        <form wire:submit="store_task">
            <label class="form-label">Tâche</label>
            <input type="text" class="form-control" wire:model="task_name" placeholder="Nom de la tâche">
            @error('task_name') <span class='text-danger'>{{ $message }}</span> @enderror
        </form>
        <script> window.addEventListener('open-addSectionTask', event => { window.$('#addSectionTask').modal('show'); }) </script>
        <script> window.addEventListener('close-addSectionTask', event => { window.$('#addSectionTask').modal('hide'); }) </script>
    @endcomponent
</div>
