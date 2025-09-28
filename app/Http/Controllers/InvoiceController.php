<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Imports\InvoiceImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    function export($invoice_id){
        return Excel::download(new InvoiceExport($invoice_id), 'invoices.xlsx');
    }
    function import($request){
        Excel::import(new InvoiceImport, $request->file('file'));
    }
    static function statut(){
        return (object) array(
            "Proforma",
            "Nouveau",
            "En Cours",
            "En Pause",
            "Annulé",
            "Bl a faire",
            "A Facturer",
            "Paiement en attente",
            "Terminé",
        );
    }
    static function quotation_status(){
        return (object) array(
            "Brouillon",
            "Envoyé /sent",
            "Accepté",
            "Refusé",
            "Annulé",
        );
    }
    static function invoice_status(){
        return (object) array(
            "Bl a faire",
            "Facturer",
            "Facturé",
            "Payé",
            "Impayéayé",
        );
    }
}
