<?php

namespace App\Livewire\Erp;

use App\Livewire\Forms\FicheForm;
use App\Livewire\Forms\FicheZoneForm;
use App\Models\Fiche;
use App\Models\FicheZone;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class FicheZonePage extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $fiche;
    public $breadcrumbs;

    function mount($fiche_id){
        $this->fiche = Fiche::find($fiche_id);

        $this->breadcrumbs = array(
            array('name' => 'Clients', 'route' => route('clients')),
            array('name' => $this->fiche->building->projet->client->name, 'route' => route('projets', ['client_id' => $this->fiche->building->projet->client->id])),
            array('name' => $this->fiche->building->projet->name, 'route' => route('projet', ['projet_id' => $this->fiche->building->projet->id])),
            array('name' => $this->fiche->building->name, 'route' => route('building', ['building_id' => $this->fiche->building->id])),
            array('name' => $this->fiche->titre, 'route' => route('fiche_zone', ['fiche_id' => $this->fiche->id])),
        );
    }

    #[On('get-fiche-zones')]
    public function render()
    {
        return view('livewire.erp.fiche-zone-page',[
            'zones' => FicheZone::where('fiche_id',$this->fiche->id)->get(),
        ]);
    }

    public FicheZoneForm $zone_form;
    function edit($zone_id){
        $this->zone_form->set($zone_id);
        $this->dispatch('open-editFicheZone');
    }
    function update(){
        $this->zone_form->update();
        $this->dispatch('close-editFicheZone');
    }
    function delete(){
        $this->zone_form->delete();
        $this->dispatch('close-editFicheZone');
    }
}
