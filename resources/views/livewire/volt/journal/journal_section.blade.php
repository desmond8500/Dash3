<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\JournalSection;

new class extends Component {
    use WithPagination;

    public $journal_id;
    public $name;
    public $description;
    public $order;
    public $selected;

    function mount($journal_id){
        $this->journal_id = $journal_id;
        $this->order = JournalSection::where('journal_id', $this->journal_id)->count()+1;
    }


    public function with(): array
    {
        return [
            'sections' => JournalSection::where('journal_id', $this->journal_id)->paginate(10),
        ];
    }

    function store(){
        // $this->validate();
        JournalSection::create([
            'journal_id' => $this->journal_id,
            'name' => $this->name,
            'description' => $this->description,
            'order' => $this->order,
        ]);
        $this->dispatch("close-addJournalSection");
    }

    function edit($id){
        $this->selected = JournalSection::find($id);
        $this->journal_id = $this->selected->journal_id;
        $this->name = $this->selected->name;
        $this->description = $this->selected->description;
        $this->order = $this->selected->order;
        $this->dispatch("open-editJournalSection");
    }

    function update(){
        $this->selected->name = $this->name;
        $this->selected->description = $this->description;
        $this->selected->order = $this->order;
        $this->selected->save();
        $this->dispatch("close-editJournalSection");
    }

    function delete($id){
        $section = JournalSection::find($id);
        $section->delete();
    }

    function down($id){
        $section = JournalSection::find($id);
        $section->order++;
        $section->save();
    }
    function up($id){
        $section = JournalSection::find($id);
        if($section->order > 0 ){
            $section->order--;
        }
        $section->save();
    }

    function generer_section($title, $content){
        $section =  JournalSection::create([
            'journal_id' => $this->journal_id,
            'name' => $title,
            'description' => $content,
            'order' => JournalSection::count()+1
        ]);
    }


}; ?>

<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Section </div>
            <div class="card-actions">
                <div class="btn-list">
                    <button class="btn btn-primary" wire:click="$dispatch('open-addJournalSection')">
                        <i class="ti ti-plus"></i> Section
                    </button>
                    <div class="dropdown open">
                        <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <i class="ti ti-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <a class="dropdown-item" wire:click="generer_section('Travaux en cours','')"> <i class="ti ti-edit"></i> Travaux en cours</a>
                            <a class="dropdown-item" wire:click="generer_section('Travaux effectués','')"> <i class="ti ti-edit"></i> Travaux effectués</a>
                            <a class="dropdown-item" wire:click="generer_section('Recommandations','')"> <i class="ti ti-edit"></i> Recommandations</a>
                            <a class="dropdown-item" wire:click="generer_section('Recommandations','')"> <i class="ti ti-edit"></i> Notes</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="p-2">
            @foreach ($sections->sortBy('order') as $section)
                <div class="card border border-primary mb-1 p-2">
                    <div class="row">
                        <div class="col">
                            <div class="fw-bold">{{ $section->name }}</div>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm rounded btn-purple btn-icon" wire:click="up('{{ $section->id }}')">
                                <i class="ti ti-arrow-big-up"></i>
                            </button>
                            <button class="btn btn-sm rounded btn-outline-purple">
                                {{ $section->order }}
                            </button>
                            <button class="btn btn-sm rounded btn-purple btn-icon" wire:click="down('{{ $section->id }}')">
                                <i class="ti ti-arrow-big-down"></i>
                            </button>
                            <button class="btn btn-sm rounded btn-primary btn-icon" wire:click="edit('{{ $section->id }}')">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-sm rounded btn-danger btn-icon" wire:click="delete('{{ $section->id }}')">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                        <div class="col-md-12">
                            <div>@parsedown($section->description) </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @component('components.modal', ["id"=>'addJournalSection', 'title' => 'Ajouter une section'])
        <form class="row" wire:submit="store">
            @include('_form.journalSection_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addJournalSection', event => { window.$('#addJournalSection').modal('show'); }) </script>
        <script> window.addEventListener('close-addJournalSection', event => { window.$('#addJournalSection').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'editJournalSection', 'title' => 'Editer une section'])
        <form class="row" wire:submit="update">
            @include('_form.journalSection_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>
        <script> window.addEventListener('open-editJournalSection', event => { window.$('#editJournalSection').modal('show'); }) </script>
        <script> window.addEventListener('close-editJournalSection', event => { window.$('#editJournalSection').modal('hide'); }) </script>
    @endcomponent


</div>
