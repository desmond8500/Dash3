<?php

namespace App\Livewire;

use App\Livewire\Forms\MyprojectForm;
use App\Models\Myproject;
use App\Models\MyprojectFile;
use App\Models\MyprojectLink;
use App\Models\MyprojectNote;
use App\Models\MyprojectPhoto;
use App\Models\MyprojectTransaction;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Page d'un projet personnel : photo et description, images, liens de recherche,
 * documents, notes, tâches et budget (achats prévisionnels et dépenses).
 */
class MyprojectPage extends Component
{
    use WithFileUploads;

    public $project_id;
    public $breadcrumbs = [];
    public $tab = 'medias';

    function mount($project_id)
    {
        $this->project_id = $project_id;
        $projet = Myproject::findOrFail($project_id);
        $this->breadcrumbs = [
            ['name' => 'Mes Projets', 'route' => route('myprojects')],
            ['name' => $projet->name, 'route' => ''],
        ];
    }

    public function render()
    {
        $project = Myproject::with(['photos', 'files', 'links', 'notes', 'transactions', 'tasks.statut'])
            ->findOrFail($this->project_id);

        return view('livewire.myproject-page', [
            'project' => $project,
            'previsions' => $project->transactions->where('type', MyprojectTransaction::PREVISION),
            'depenses' => $project->transactions->where('type', MyprojectTransaction::DEPENSE),
        ]);
    }

    // ------------------------------------------------------------------
    // Projet
    // ------------------------------------------------------------------
    public MyprojectForm $project_form;

    function edit_project()
    {
        $this->project_form->set($this->project_id);
        $this->dispatch('open-editProject');
    }

    function update()
    {
        $this->project_form->update();
        $this->dispatch('close-editProject');
        $this->dispatch('get_my_projects');
    }

    // ------------------------------------------------------------------
    // Images et documents
    // ------------------------------------------------------------------
    public $files = [];
    public $file_type = 'photos';

    function add_files($type)
    {
        $this->file_type = $type;
        $this->reset('files');
        $this->dispatch('open-addProjectFile');
    }

    function store_files()
    {
        $rules = $this->file_type === 'photos'
            ? ['files' => ['required', 'array'], 'files.*' => ['image', 'max:8192']]
            : ['files' => ['required', 'array'], 'files.*' => ['file', 'max:20480']];
        $this->validate($rules);

        $dir = "myprojects/{$this->project_id}/" . ($this->file_type === 'photos' ? 'photos' : 'files');
        foreach ($this->files as $file) {
            $ext = strtolower($file->getClientOriginalExtension());
            if ($this->file_type !== 'photos' && in_array($ext, ['php', 'phtml', 'phar', 'sh', 'exe', 'bat', 'cmd'], true)) {
                continue; // fichiers exécutables refusés
            }
            $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . Str::random(5) . ($ext ? ".$ext" : '');
            $file->storeAs("public/$dir", $name);

            if ($this->file_type === 'photos') {
                MyprojectPhoto::create([
                    'myproject_id' => $this->project_id,
                    'photo_path' => "storage/$dir/$name",
                    'caption' => '',
                ]);
            } else {
                MyprojectFile::create([
                    'myproject_id' => $this->project_id,
                    'file_path' => "storage/$dir/$name",
                    'description' => $file->getClientOriginalName(),
                ]);
            }
        }
        $this->reset('files');
        $this->dispatch('close-addProjectFile');
    }

    function delete_photo($id)
    {
        $photo = MyprojectPhoto::find($id);
        if (! $photo) return;
        Storage::disk('public')->delete(Str::after($photo->photo_path, 'storage/'));
        $photo->delete();
    }

    function delete_file($id)
    {
        $file = MyprojectFile::find($id);
        if (! $file) return;
        Storage::disk('public')->delete(Str::after($file->file_path, 'storage/'));
        $file->delete();
    }

    // ------------------------------------------------------------------
    // Liens de recherche
    // ------------------------------------------------------------------
    public $link_id;
    public $link_name;
    public $link_url;
    public $link_description;

    function add_link()
    {
        $this->reset(['link_id', 'link_name', 'link_url', 'link_description']);
        $this->resetValidation();
        $this->dispatch('open-editProjectLink');
    }

    function edit_link($id)
    {
        $link = MyprojectLink::find($id);
        if (! $link) return;
        $this->link_id = $link->id;
        $this->link_name = $link->name;
        $this->link_url = $link->link;
        $this->link_description = $link->description;
        $this->resetValidation();
        $this->dispatch('open-editProjectLink');
    }

    function save_link()
    {
        $data = $this->validate([
            'link_name' => ['required', 'string', 'max:255'],
            'link_url' => ['required', 'url', 'max:2048'],
            'link_description' => ['nullable', 'string'],
        ]);
        $payload = [
            'myproject_id' => $this->project_id,
            'name' => $data['link_name'],
            'link' => $data['link_url'],
            'description' => $data['link_description'],
        ];
        if ($this->link_id) {
            MyprojectLink::find($this->link_id)?->update($payload);
        } else {
            MyprojectLink::create($payload);
        }
        $this->dispatch('close-editProjectLink');
    }

    function delete_link($id)
    {
        MyprojectLink::find($id)?->delete();
    }

    // ------------------------------------------------------------------
    // Notes
    // ------------------------------------------------------------------
    public $note_id;
    public $note_title;
    public $note_content;

    function add_note()
    {
        $this->reset(['note_id', 'note_title', 'note_content']);
        $this->resetValidation();
        $this->dispatch('markdown-editor-set', id: 'myproject-note-content', value: '');
        $this->dispatch('open-editProjectNote');
    }

    function edit_note($id)
    {
        $note = MyprojectNote::find($id);
        if (! $note) return;
        $this->note_id = $note->id;
        $this->note_title = $note->title;
        $this->note_content = $note->content;
        $this->resetValidation();
        $this->dispatch('markdown-editor-set', id: 'myproject-note-content', value: $note->content ?? '');
        $this->dispatch('open-editProjectNote');
    }

    function save_note()
    {
        $data = $this->validate([
            'note_title' => ['required', 'string', 'max:255'],
            'note_content' => ['nullable', 'string'],
        ]);
        $payload = [
            'myproject_id' => $this->project_id,
            'title' => $data['note_title'],
            'content' => $data['note_content'],
        ];
        if ($this->note_id) {
            MyprojectNote::find($this->note_id)?->update($payload);
        } else {
            MyprojectNote::create($payload);
        }
        $this->dispatch('close-editProjectNote');
    }

    function delete_note($id)
    {
        MyprojectNote::find($id)?->delete();
    }

    // ------------------------------------------------------------------
    // Tâches
    // ------------------------------------------------------------------
    public $task_name;

    function store_task()
    {
        $this->validate(['task_name' => ['required', 'string', 'max:255']]);
        Task::create([
            'name' => $this->task_name,
            'myproject_id' => $this->project_id,
            'statut_id' => 1,
            'priority_id' => 1,
        ]);
        $this->reset('task_name');
    }

    function toggle_task($id)
    {
        $task = Task::find($id);
        if (! $task) return;
        $task->update(['statut_id' => $task->statut_id >= 4 ? 1 : 4]);
    }

    function delete_task($id)
    {
        Task::find($id)?->delete();
    }

    // ------------------------------------------------------------------
    // Budget : achats prévisionnels et dépenses
    // ------------------------------------------------------------------
    public $transaction_id;
    public $transaction_type = MyprojectTransaction::PREVISION;
    public $transaction_name;
    public $transaction_amount;
    public $transaction_quantity = 1;
    public $transaction_date;
    public $transaction_description;

    function add_transaction($type = MyprojectTransaction::PREVISION)
    {
        $this->reset(['transaction_id', 'transaction_name', 'transaction_amount', 'transaction_description']);
        $this->transaction_type = $type;
        $this->transaction_quantity = 1;
        $this->transaction_date = now()->format('Y-m-d');
        $this->resetValidation();
        $this->dispatch('open-editProjectTransaction');
    }

    function edit_transaction($id)
    {
        $t = MyprojectTransaction::find($id);
        if (! $t) return;
        $this->transaction_id = $t->id;
        $this->transaction_type = $t->type;
        $this->transaction_name = $t->name;
        $this->transaction_amount = $t->amount;
        $this->transaction_quantity = $t->quantity;
        $this->transaction_date = $t->transaction_date?->format('Y-m-d');
        $this->transaction_description = $t->description;
        $this->resetValidation();
        $this->dispatch('open-editProjectTransaction');
    }

    function save_transaction()
    {
        $data = $this->validate([
            'transaction_type' => ['required', 'in:prevision,depense'],
            'transaction_name' => ['required', 'string', 'max:255'],
            'transaction_amount' => ['required', 'numeric', 'min:0'],
            'transaction_quantity' => ['required', 'integer', 'min:1'],
            'transaction_date' => ['nullable', 'date'],
            'transaction_description' => ['nullable', 'string'],
        ]);
        $payload = [
            'myproject_id' => $this->project_id,
            'type' => $data['transaction_type'],
            'name' => $data['transaction_name'],
            'amount' => $data['transaction_amount'],
            'quantity' => $data['transaction_quantity'],
            'transaction_date' => $data['transaction_date'],
            'description' => $data['transaction_description'],
        ];
        if ($this->transaction_id) {
            MyprojectTransaction::find($this->transaction_id)?->update($payload);
        } else {
            MyprojectTransaction::create($payload);
        }
        $this->dispatch('close-editProjectTransaction');
    }

    /** Un achat prévu devient une dépense effectuée */
    function mark_spent($id)
    {
        $t = MyprojectTransaction::find($id);
        if (! $t) return;
        $t->update([
            'type' => MyprojectTransaction::DEPENSE,
            'transaction_date' => $t->transaction_date ?? now(),
        ]);
    }

    function delete_transaction($id)
    {
        MyprojectTransaction::find($id)?->delete();
    }
}
