<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Building;
use App\Models\Commande;
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
        $carbon = new Carbon();

        $journal = Journal::find($journal_id);

        $data = [
            'logo' => env('LOGO', ''),
            'title' => "Rapport d'intervention",
            'title_css' => env('COLOR1', 'border: 1px solid white; font-size: 20px; color: #219C90;'),
            'journal' => $journal,
            'carbon' => $carbon,
            'color1' => env('COLOR1', '219C90'),
            'color2' => env('COLOR2', '219C90'),
            'color3' => env('COLOR3', '219C90'),
        ];

        $pdf = Pdf::loadView('_pdf.journal_pdf', $data);
        return $pdf->stream();
    }
}
