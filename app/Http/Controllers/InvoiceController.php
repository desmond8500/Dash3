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
            array(name=>"Etude", slug=> ""),
            array(name=>"Devis", slug=> ""),
            array(name=>"Devis validé", slug=> ""),
            array(name=>"Debut", slug=> ""),
            array(name=>"En cours", slug=> ""),
            array(name=>"En pause", slug=> ""),
            array(name=>"Annulé", slug=> ""),
            array(name=>"BL a rediger", slug=> ""),
            array(name=>"BL a signer", slug=> ""),            
            array(name=>"Facturer", slug=> ""),
            array(name=>"Facturé", slug=> ""),
            array(name=>"Payé", slug=> ""),
            array(name=>"Impayé", slug=> ""),
        );
    }
    // Mettre à jour les status des devis
    static function regularize(){
    }
}
