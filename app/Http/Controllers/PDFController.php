<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public static function achat_pdf($achat_id){
        $achat = Achat::find($achat_id);
        $data = ['achat' => $achat];
        $pdf = Pdf::loadView('_pdf.achat', $data);
        return $pdf->stream();
    }
}
