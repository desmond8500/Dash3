<?php

namespace App\Livewire\Erp;

use App\Models\Building;
use App\Models\Device;
use App\Models\Quantitatif;
use App\Models\QuantitatifRow;
use Livewire\Attributes\On;
use Livewire\Component;

class BuildingQuantitatif extends Component
{
    public $building;
    public $q_selected;

    function mount($building_id){
        $this->building = Building::find($building_id);
    }

    public function render()
    {
        return view('livewire.erp.building-quantitatif',[
            'quantitatifs' => $this->get_quantitatif(),
        ]);
    }

    #[On('get-quantitatif')]
    function get_quantitatif(){
        return Quantitatif::where('building_id', $this->building->id)->get();
    }

    function select_quantitatif($quantitatif_id)
    {
        $this->q_selected = Quantitatif::find($quantitatif_id);
    }

    function row_inc($row_id){
        $row = QuantitatifRow::find($row_id);
        $row->quantite++;
        $row->save();
    }
    function row_dec($row_id){
        $row = QuantitatifRow::find($row_id);
        $row->quantite--;
        $row->save();
    }
    function sync_devices($row_id){
        $row = QuantitatifRow::find($row_id);

        if ($row->devices->count() < $row->quantite) {
            for ($i = $row->devices->count(); $i < $row->quantite; $i++) {
                Device::create([
                    'quantitatif_row_id' => $row->id,
                    'article_id' => $row->article_id ?? null,
                    'designation' => $row->article->designation ?? null,
                    'reference' => $row->article->reference ?? null,
                    // 'type' => $row->article->type,
                    'icon' => $row->article->icon ?? "circle",
                    'description' => $row->description ?? null,
                ]);
            }
        } elseif ($row->devices->count() > $row->quantite) {
            for ($i = $row->devices>count(); $i > $row->quantite; $i--) {
                $device = $row->devices->last();
                $device->delete();
            }
        }
    }

    public $selected_device;

    function show_device($device_id){
        $this->selected_device = Device::find($device_id);
        $this->dispatch('open-showDevice');
    }
}
