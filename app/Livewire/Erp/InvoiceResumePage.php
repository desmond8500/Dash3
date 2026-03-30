<?php

namespace App\Livewire\Erp;

use App\Models\Invoice;
use Livewire\Component;

class InvoiceResumePage extends Component
{
    public $breadcrumbs = [
        // ['name' => 'ERP', 'link' => '/erp'],
        // ['name' => 'Factures', 'link' => '/erp/invoices'],
        // ['name' => 'Résumé', 'link' => '/erp/invoice/resume'],
    ];

    public $year = 2026;
    public $month;

    public function render()
    {
        return view('livewire.erp.invoice-resume-page',[
            'invoices' => $this->get_invoices(),
            'acomptes' => $this->getAcomptes(),
        ]);
    }

    public function get_invoices() {
        // $invoices = Invoice::whereYear('created_at', $this->year)
        //     ->whereMonth('created_at', $this->month)
        //     ->get();

        $invoices = Invoice::whereYear('paydate', $this->year)->orderBy('paydate', 'asc')->get();

        return $invoices;
    }

    function getAcomptes() {
        $acomptes = Invoice::where(function ($q) {
            $q->whereNull('paydate')
                ->orWhere('paydate', '');
        })
            ->whereYear('paydate', $this->year)
            ->whereHas('acomptes')
            ->get();
        return $acomptes;
    }

    function compta($invoice_id){
        $invoice = Invoice::find($invoice_id);
        $invoice->comptabilise = !$invoice->comptabilise;
        $invoice->save();
    }
}
