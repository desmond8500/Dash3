<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class PDF2Controller extends Controller
{
    static function installations_pdf($projet_id)
    {
        // Récupérer les données nécessaires pour le PDF
        $installations = Installation::where('projet_id', $projet_id)->get();


        // Générer le PDF à partir d'une vue
        $pdf = Pdf::view('_pdf2.installation_pdf', ['installations' => $installations]);

        // Retourner le PDF en téléchargement
        return $pdf->name('installations.pdf');
    }
}
