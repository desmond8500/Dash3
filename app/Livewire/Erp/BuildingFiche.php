<?php

namespace App\Livewire\Erp;

use App\Models\Fiche;
use Livewire\Component;
use Spatie\LaravelPdf\Facades\Pdf;

class BuildingFiche extends Component
{
    public $building_id;

    function mount($building_id){
        $this->building_id = $building_id;
    }
    public function render()
    {
        return view('livewire.erp.building-fiche',[
            'fiches' => Fiche::where('building_id', $this->building_id)->get()
        ]);
    }

    function pdf(){
        // Pdf::view('_pdf.fiches.extinction.esser')
        // ->format('a4')
        // ->name('invoice-2023-04-10.pdf')
        // ->assertViewIs('sdfsd');
        // ->download();
        // ->save('invoice.pdf');

        Pdf::view('_pdf.fiches.extinction.esser')
        ->name('invoice-2023-04-10.pdf');
    }
}
