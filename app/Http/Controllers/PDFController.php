<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Commande;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PDFController extends Controller
{
    public static function achat_pdf($achat_id){
        $carbon = new Carbon();

        $achat = Achat::find($achat_id);
        $data = [
            'achat' => $achat,
            'carbon' => $carbon,
        ];
        $pdf = Pdf::loadView('_pdf.achat', $data);
        return $pdf->stream();
    }
    public static function commande_pdf(){
        $carbon = new Carbon();

        $commandes = Commande::all();
        $data = [
            'title' => 'Commande',
            'commandes' => $commandes,
            'carbon' => $carbon,
        ];
        $pdf = Pdf::loadView('_pdf.commande', $data);
        return $pdf->stream();
    }
}
