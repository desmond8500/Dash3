<?php

namespace App\Livewire\Erp;

use Livewire\Component;
use Spatie\LaravelPdf\Facades\Pdf;

class BuildingFiche extends Component
{
    public function render()
    {
        return view('livewire.erp.building-fiche');
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
