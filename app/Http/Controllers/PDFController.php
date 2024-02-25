<?php

namespace App\Http\Controllers;

use App\Models\Achat;
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
}
