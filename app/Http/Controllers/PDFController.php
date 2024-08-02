<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Badge;
use App\Models\Building;
use App\Models\Commande;
use App\Models\Invoice;
use App\Models\InvoiceAcompte;
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
    public static function facture_pdf($invoice_id,$type){
        $devis = Invoice::find($invoice_id);
        $carbon = new Carbon($devis->date);

        $data = [
            'logo' => env('LOGO', ''),
            'title' => $type ?? "Facture",
            'title_css' => env('TITLE_CSS', 'border: 1px solid white; font-size: 20px;'),
            'devis' => $devis,
            'carbon' => $carbon,
            'acompte' => 0,
            // 'acompte' => InvoiceAcompte::find($acompte_id),
            'sections' => InvoiceSection::where('invoice_id', $devis->id)->get(),
            'color1' => env('COLOR1', '219C90'),
            'color2' => env('COLOR2', '219C90'),
            'color3' => env('COLOR3', '219C90'),
        ];

        $pdf = Pdf::loadView('_pdf.facture.facture_pdf', $data);
        return $pdf->stream($devis->reference.' - '.$devis->projet->name);
        // return $pdf->download('sdfsd');
    }
    public static function facture_acompte_pdf($invoice_id,$type, $acompte_id){
        $devis = Invoice::find($invoice_id);
        $carbon = new Carbon($devis->date);

        $data = [
            'logo' => env('LOGO', ''),
            'title' => $type ?? "Facture",
            'title_css' => env('TITLE_CSS', 'border: 1px solid white; font-size: 20px;'),
            'devis' => $devis,
            'carbon' => $carbon,
            'acompte' => InvoiceAcompte::find($acompte_id),
            'sections' => InvoiceSection::where('invoice_id', $devis->id)->get(),
            'color1' => env('COLOR1', '219C90'),
            'color2' => env('COLOR2', '219C90'),
            'color3' => env('COLOR3', '219C90'),
        ];

        $pdf = Pdf::loadView('_pdf.facture.facture_pdf', $data);
        return $pdf->stream($devis->date.' - '.$devis->projet->name);
        // return $pdf->download('sdfsd');
    }
    public static function pdf_test(){
        $carbon = new Carbon();

        $data = [
            'logo' => "img/arp/logo.png",
            'flag' => "img/arp/flag.png",
            'photo' => "img/arp/Pr Djibril Fall.jpg",
            'prenom' => "Khady",
            'nom' => "Tine",
            'fonction' => "Analyste SOC Niveau 2  sdfsdfsdfsdfsd sdfsdf",
            'direction' => "Direction de l'administration et des finances ",
        ];

        $pdf = Pdf::loadView('_pdf.pdf', $data)->setPaper(array(0,0,246,492), 'landscape');
        return $pdf->stream('pdf');
        // return $pdf->download('sdfsd');
    }
    public static function arp_card_pdf($card_id){
        $card = Badge::find($card_id);

        $data = [
            'logo' => "img/arp/logo.png",
            'flag' => "img/arp/flag.png",
            'photo' => $card->photo ?? "img/arp/Pr Djibril Fall.jpg",
            'prenom' => $card->prenom,
            'nom' => $card->nom,
            'fonction' => $card->fonction,
            'direction' => $card->direction,
            'service' => $card->service,
        ];

        $pdf = Pdf::loadView('_pdf.pdf', $data)->setPaper(array(0,0,246,492), 'landscape');
        return $pdf->stream('pdf');
        // return $pdf->download('sdfsd');
    }
    public static function arp_card_pdfs($projet_id){
        $cards = Badge::where("projet_id", $projet_id)->get();

        $data = [
            'logo' => "img/arp/logo.png",
            'flag' => "img/arp/flag.png",
            'cards' => $cards
        ];

        $pdf = Pdf::loadView('_pdf.pdf2', $data)->setPaper(array(0,0,246,492), 'landscape');
        return $pdf->stream('pdf');
        // return $pdf->download('sdfsd');
    }
    public static function test_pdf(){

        $data = [

        ];

        $pdf = Pdf::loadView('_pdf.test', $data);
        return $pdf->stream('pdf');
    }
    public static function proces_verbal_pdf(){

        $data = [

        ];

        $pdf = Pdf::loadView('_pdf.proces_verbal_pdf', $data);
        return $pdf->stream('proces_verbal_pdf');
    }

}
