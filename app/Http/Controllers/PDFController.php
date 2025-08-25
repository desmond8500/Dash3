<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Badge;
use App\Models\Building;
use App\Models\Commande;
use App\Models\CV;
use App\Models\Fiche;
use App\Models\Invoice;
use App\Models\InvoiceAcompte;
use App\Models\InvoiceBl;
use App\Models\InvoiceProposal;
use App\Models\InvoiceSection;
use App\Models\Journal;
use App\Models\Team;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PDFController extends Controller
{
    public static function pdf(){
        $carbon = new Carbon();

        $data = [
            'carbon' => $carbon,
            'logo' => env('LOGO', ''),
            'title' => $type ?? "Facture",
            'title_css' => env('TITLE_CSS', 'border: 1px solid white; font-size: 20px;'),
            'color1' => env('COLOR1', '6b8a7a'),
            'color2' => env('COLOR2', '6b8a7a'),
            'color3' => env('COLOR3', '6b8a7a'),
            'date' => $carbon->now()->format('d-m-Y')
        ];
        $pdf = Pdf::loadView('_pdf.pdf', $data);
        return $pdf->stream();
    }
    public static function achat_pdf($achat_id){
        $carbon = new Carbon();

        $achat = Achat::find($achat_id);
        $data = [
            'achat' => $achat,
            'carbon' => $carbon,
        ];
        $pdf = Pdf::loadView('_pdf.achat', $data);
        return $pdf->stream('Achat - '.$achat->name );
    }
    public static function fiches_inventaire_pdf($name){
        $data = [
            'name' => $name,
            'title' => env('MAIN_NAME'),
        ];
        $pdf = Pdf::loadView('_pdf.modele_fiche', $data);
        return $pdf->stream('Fiche Inventaire');
    }

    public static function fiches_pdf($type, $name){
        $data = [
            'name' => $name,
            'title' => env('MAIN_NAME'),
            'logo' => env('LOGO', ''),
            'page_title' => $name,
        ];
        if ($type == 'presence') {
            $pdf = Pdf::loadView('_pdf.fiches.fiche_presence_pdf', $data);
            return $pdf->stream('Fiche de présence');
        } else {
            $pdf = Pdf::loadView('_pdf.modele_fiche', $data);
            return $pdf->stream('Fiche Inventaire');
        }

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
            'info' => [$id, $type, $search, $status ]
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
            'color1' => env('COLOR1', '6b8a7a'),
            'color2' => env('COLOR2', '6b8a7a'),
            'color3' => env('COLOR3', '6b8a7a'),
        ];

        $pdf = Pdf::loadView('_pdf.journal_pdf', $data);
        return $pdf->stream($journal->date.' - '.$journal->projet->name. ' - ' . $journal->title . ' - ' . $data['title']);
        // return $pdf->download('sdfsd');
    }

    static function facture($invoice_id, $type){
        $devis = Invoice::find($invoice_id);
        $carbon = new Carbon($devis->date);

        return [
            'logo' => env('LOGO', ''),
            'title' => $type ?? "Facture",
            'title_css' => env('TITLE_CSS', 'border: 1px solid white; font-size: 20px;'),
            'devis' => $devis,
            'carbon' => $carbon,
            'acompte' => 0,
            // 'acompte' => InvoiceAcompte::find($acompte_id),
            'sections' => InvoiceSection::where('invoice_id', $devis->id)->get(),
            'color1' => env('COLOR1', '6b8a7a'),
            'color2' => env('COLOR2', '6b8a7a'),
            'color3' => env('COLOR3', '6b8a7a'),
        ];
    }



    /**
     *@OA\Get(
     *      path="/api/v1/facture_pdf/invoice_id/type",
     *      tags={"Factures",},
     *      summary="Récupérer une facture",
     *      @OA\Parameter(
     *          description="Parameter with example",
     *          in="path",
     *          name="invoice_id",
     *          required=true,
     *          @OA\Schema(type="integer"),
     *          @OA\Examples(example="int", value="1", summary="an int value"),
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Facture récupéré avec succès",
     *       ),
     *     )
     */
    public static function facture_pdf($invoice_id,$type='facture'){
        $data = PDFController::facture($invoice_id, $type);
        $pdf = Pdf::loadView('_pdf.facture.facture_pdf', $data);
        return $pdf->stream( Str::upper($type).' '. Str::upper($data['devis']->reference). ' - '. $data['devis']->projet->client->name . ' - ' . $data['devis']->projet->name . ' - ' . $data['devis']->description);
    }


    // Télécharger PDF
    public static function facture_pdf_save($invoice_id,$type){
        $data = PDFController::facture($invoice_id, $type);
        $pdf = Pdf::loadView('_pdf.facture.facture_pdf', $data);
        return $pdf->download( Str::upper($type).' '. Str::upper($data['devis']->reference). ' - '. $data['devis']->projet->client->name . ' - ' . $data['devis']->projet->name . ' - ' . $data['devis']->description);
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
            'acomptes' => InvoiceAcompte::where('invoice_id', $devis->id)->get(),
            'sections' => InvoiceSection::where('invoice_id', $devis->id)->get(),
            'color1' => env('COLOR1', '6b8a7a'),
            'color2' => env('COLOR2', '6b8a7a'),
            'color3' => env('COLOR3', '6b8a7a'),
        ];

        $pdf = Pdf::loadView('_pdf.facture.facture_pdf', $data);
        return $pdf->stream($devis->date.' - '.$devis->projet->name . ' - ' . $devis->projet->name . ' - ' . $devis->description);
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
    public static function card_pdfs($projet_id, $type){
        $cards = Badge::where("projet_id", $projet_id)->get();

        $data = [
            'logo' => "img/arp/logo.png",
            'flag' => "img/arp/flag.png",
            'cards' => $cards
        ];
        if ($type == 2) {
            $pdf = Pdf::loadView('_pdf.pdf3', $data)->setPaper(array(0,0,246,492), 'landscape');
            return $pdf->stream('Badges SCD');
        } else {
            $pdf = Pdf::loadView('_pdf.pdf2', $data)->setPaper(array(0,0,246,492), 'landscape');
            return $pdf->stream('pdf');
        }

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
            "societes" => array('Société 1', 'Société 2'),
            "systemes" => array('Détection incendie', 'Signalisation'),
            "date" => "20/12/2024",
            "client" => "CBAO Kermel",
            "travaux" => "",
            "articles" => array(
                (object) array('designation' => 'Article 1', 'quantite'=> 1, 'reference'=> 'ref'),
                (object) array('designation' => 'Article 2', 'quantite'=> 1, 'reference'=> 'ref'),
                (object) array('designation' => 'Article 3', 'quantite'=> 1, 'reference'=> 'ref'),
                (object) array('designation' => 'Article 4', 'quantite'=> 1, 'reference'=> 'ref'),
                (object) array('designation' => 'Article 5', 'quantite'=> 1, 'reference'=> 'ref'),
            ),
            "personnes" => array(
                (object) array('prenom' => 'Adrien', 'nom'=> 'Monk', 'societe'=> 'police'),
                (object) array('prenom' => 'Adrien', 'nom'=> 'Monk', 'societe'=> 'police'),
                (object) array('prenom' => 'Adrien', 'nom'=> 'Monk', 'societe'=> 'police'),
            ),
        ];

        $pdf = Pdf::loadView('_pdf.doe_pdf', $data);
        return $pdf->stream('doe_pdf');
    }

    public static function fiche_pdf($fiche_id){
        $fiche = Fiche::find($fiche_id);

        $data = [
            'logo' => env('LOGO', ''),
            'title' => env('MAIN_NAME'),
            'fiche' => $fiche,
            'zones' => $fiche->zones ?? [],
        ];

        $pdf = Pdf::loadView("_pdf.fiches.$fiche->type", $data);
        return $pdf->stream('fiche_pdf');
    }
    public static function bl_pdf($invoice_bl_id){
        $bl = InvoiceBl::find($invoice_bl_id);
        $invoice = Invoice::find($bl->invoice_id);
        $carbon = new Carbon($bl->date);

        $data = [
            'logo' => env('LOGO', ''),
            'title' => env('MAIN_NAME'),
            'invoice' => $invoice,
            'bl' => $bl,
            'carbon' => $carbon,
            'color1' => env('COLOR1'),
            'color2' => env('COLOR2'),
            'color3' => env('COLOR3'),
        ];

        if ($bl->type) {
            $pdf = Pdf::loadView("_pdf.bl.bl_travaux", $data);
            return $pdf->stream("Bordereau de $bl->type _ ".$invoice->projet->name);
        } elseif('travaux') {
            $pdf = Pdf::loadView("_pdf.bl.bl_travaux", $data);
            return $pdf->stream("Bordereau de $bl->type _ ".$invoice->projet->name);
        }
    }

    public static function pv_pdf($invoice_id){
        $invoice = Invoice::find($invoice_id);
        // $carbon = new Carbon($date);

        $data = [
            'logo' => env('LOGO', ''),
            'title' => env('MAIN_NAME'),
            'invoice' => $invoice,
        ];

        $pdf = Pdf::loadView("_pdf.pv.pv1_pdf", $data);
        return $pdf->stream("Procès verbal");
    }


    public static function cv_pdf($cv_id){
        $cv = CV::find($cv_id);
        // $carbon = new Carbon($date);

        $data = [
            // 'logo' => env('LOGO', ''),
        ];

        $pdf = Pdf::loadView("_pdf.cv.cv1_pdf", $data);
        return $pdf->stream("Procès verbal");
    }

    public static function proposal_pdf($proposal_id, $type = 'devis')
    {
        $data = PDFController::proposal($proposal_id, $type);
        $pdf = Pdf::loadView('_pdf.facture.proposal_pdf', $data);
        return $pdf->stream(Str::upper($type) . ' ' . Str::upper($data['devis']->reference) . ' - ' . $data['devis']->projet->client->name . ' - ' . $data['devis']->projet->name . ' - ' . $data['devis']->description);
    }

    static function proposal($proposal_id, $type)
    {
        $proposal = InvoiceProposal::find($proposal_id);
        $devis = Invoice::find($proposal->invoice->id);
        $carbon = new Carbon($devis->date);

        return [
            'logo' => env('LOGO', ''),
            'title' => $type ?? "Facture",
            'title_css' => env('TITLE_CSS', 'border: 1px solid white; font-size: 20px;'),
            'devis' => $devis,
            'carbon' => $carbon,
            'proposal' => $proposal,
            'acompte' => 0,
            'color1' => env('COLOR1', '6b8a7a'),
            'color2' => env('COLOR2', '6b8a7a'),
            'color3' => env('COLOR3', '6b8a7a'),
        ];
    }
    static function attestation_pdf($team_id)
    {
        $team = Team::find($team_id);
        $carbon = new Carbon();

        $data = [
            'logo' => env('LOGO', ''),
            'title' => $type ?? "Attestation de Stage",
            'title_css' => env('TITLE_CSS', 'border: 1px solid white; font-size: 20px;'),
            'carbon' => $carbon,
            'team' => $team,
            'acompte' => 0,
            'color1' => env('COLOR1', '6b8a7a'),
            'color2' => env('COLOR2', '6b8a7a'),
            'color3' => env('COLOR3', '6b8a7a'),
        ];

        $pdf = Pdf::loadView("_pdf.attestation", $data);
        return $pdf->stream("Attestation $team->firstname $team->lastname ");
    }

    static function browserShot()
    {
        $carbon = new Carbon();

        $data = [
            'logo' => env('LOGO', ''),
            'title' => $type ?? "Attestation de Stage",
            'carbon' => $carbon,
        ];

        $pdf = Pdf::loadView("_pdf.attestation", $data);
        return $pdf->stream("Attestation  ");
    }

}
