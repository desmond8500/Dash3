<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Facture $facture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facture $facture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facture $facture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facture $facture)
    {
        //
    }


    function demo(){
        $mois = [];
        $debut = Carbon::create(2025, 1, 1);
        $fin = Carbon::now()->startOfMonth();

        while ($debut <= $fin) {
            $mois[$debut->format('Y-m')] = ucfirst(
                $debut->translatedFormat('F Y')
            );
            $debut->addMonth();
        }

        return $mois;
    }
}
