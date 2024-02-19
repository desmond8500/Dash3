<?php

namespace App\Exports;

use App\Models\Client;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

// class ClientsExport implements FromCollection
class ClientsExport implements FromView
{
    // public function collection()
    // {
    //     return Client::all();
    // }

    public function view(): View
    {
        return view('excel.clients_table', [
            'clients' => Client::all()
        ]);
    }
}
