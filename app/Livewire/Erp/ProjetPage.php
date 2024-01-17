<?php

namespace App\Livewire\Erp;

use App\Models\Projet;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProjetPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $search ='';
    public $breadcrumbs;
    public $projet, $projet_id;

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
            'buildings' => json_decode(file_get_contents('json/buildings.json')),
        ]);
    }
}
