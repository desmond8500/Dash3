<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\InvoiceRow;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExport implements FromView
{
    public $invoice;
    public function __construct($invoice_id)
    {
        $this->invoice = Invoice::find($invoice_id);
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        return view('_xls.invoice',[
            'rows' => $this->invoice->rows
        ]);
    }


}
