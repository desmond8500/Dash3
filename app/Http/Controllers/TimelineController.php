<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public $projet_id;

    function demo(){
        return "demo";
    }

    // Invoice
    function add_invoice($projet_id, $invoice_id){
        Timeline::create([
            'user_id'=> auth()->user()->id,
            'title' => "Ajout d'un devis",
            'invoice_id' => $invoice_id,
            'projet_id' => $projet_id,

        ]);
    }

    // Journal
    function add_journal($projet_id, $journal_id){
        Timeline::create([
            'user_id'=> auth()->user()->id,
            'title' => "Ajout d'un journal",
            'journal_id' => $journal_id,
            'projet_id' => $projet_id,
        ]);
    }
}
