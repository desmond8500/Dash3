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
}
