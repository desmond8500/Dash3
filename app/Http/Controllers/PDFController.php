<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Building;
use App\Models\Commande;
use App\Models\Invoice;
use App\Models\InvoiceSection;
use App\Models\Journal;
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

    public static function avancement_pdf($building_id){
        $carbon = new Carbon();
        $building = Building::find($building_id);

        $data = [
            'title' => 'Avancements',
            // 'avancements' => $building->avancements,
            'carbon' => $carbon,
        ];
        $pdf = Pdf::loadView('_pdf.avancements', $data);
        return $pdf->stream();
    }

    public static function tasks_pdf($id, $type, $search, $status){
        $carbon = new Carbon();

        $tasks = TaskController::getTasklist($id, $type, $search, $status);

        $data = [
            'title' => 'Liste des taches',
            'tasks' => $tasks,
            'carbon' => $carbon,
        ];

        $pdf = Pdf::loadView('_pdf.tasks', $data);
        return $pdf->stream();
    }

    public static function journal_pdf($journal_id){
        $journal = Journal::find($journal_id);
        $carbon = new Carbon($journal->date);

        $data = [
            'logo' => env('LOGO', ''),
            'title' => $journal->type ?? "Rapport d'intervention",
            'title_css' => env('TITLE_CSS', 'border: 1px solid white; font-size: 20px;'),
            'journal' => $journal,
            'carbon' => $carbon,
            'color1' => env('COLOR1', '219C90'),
            'color2' => env('COLOR2', '219C90'),
            'color3' => env('COLOR3', '219C90'),
        ];

        $pdf = Pdf::loadView('_pdf.journal_pdf', $data);
        return $pdf->stream($journal->date.' - '.$journal->projet->name.' - ' . $data['title']);
        // return $pdf->download('sdfsd');
    }
    public static function facture_pdf($invoice_id,$type, $acompte = 0){
        $devis = Invoice::find($invoice_id);
        $carbon = new Carbon($devis->date);

        $data = [
            'logo' => env('LOGO', ''),
            'title' => $type ?? "Facture",
            'title_css' => env('TITLE_CSS', 'border: 1px solid white; font-size: 20px;'),
            'devis' => $devis,
            'carbon' => $carbon,
            'acompte' => $acompte,
            'sections' => InvoiceSection::where('invoice_id', $devis->id)->get(),
            'color1' => env('COLOR1', '219C90'),
            'color2' => env('COLOR2', '219C90'),
            'color3' => env('COLOR3', '219C90'),
        ];

        $pdf = Pdf::loadView('_pdf.facture.facture_pdf', $data);
        return $pdf->stream($devis->date.' - '.$devis->projet->name);
        // return $pdf->download('sdfsd');
    }
}
