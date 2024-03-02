<?php

namespace App\Livewire\Erp;

use App\Models\Building;
use App\Models\Journal;
use App\Models\Projet;
use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProjetPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $journal_search ='';
    public $breadcrumbs;
    public $projet, $projet_id;
    public $tab = 0;

    public function mount($projet_id){
        $this->projet = Projet::find($projet_id);
        $this->projet_id = $projet_id;

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $this->projet->client->name, 'route' => route('projets',['client_id'=>$this->projet->client->id])),
            array('name' => $this->projet->name, 'route' => route('projet',['projet_id'=>$this->projet->id])),
        );
    }

    function ProjetSearch() {
        return Projet::where('client_id', $this->client_id)->where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    public function render()
    {
        return view('livewire.erp.projet-page',[
            'buildings' => $this->get_buildings(),
            'projet_id' => $this->projet_id,
            'tasks' => $this->get_tasks(),
            'journaux' => $this->get_news(),
        ]);
    }

    #[On('get-buildings')]
    function get_buildings() {
        return Building::where('projet_id', $this->projet_id)->where('name', 'like', '%' . $this->search . '%')->paginate(10);
    }

    function get_tasks() {
        return Task::where('projet_id', $this->projet_id)->get();
    }

    #[On('get-news')]
    function get_news() {
        return Journal::where('projet_id', $this->projet_id)->get();
    }


}
