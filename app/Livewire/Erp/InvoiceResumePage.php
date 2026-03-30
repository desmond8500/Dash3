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
            'acomptes_sum' => $this->getAcomptesSum(),
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
        $year = $this->year;
        $acomptes = Invoice::with('acomptes')
            ->unpaid()
            ->whereHas('acomptes', function ($q) use ($year) {
                $q->whereYear('date', $year);
            })
            ->with(['acomptes' => function ($q) use ($year) {
                $q->whereYear('date', $year);
            }])
            ->get();
        return $acomptes;
    }
    function getAcomptesSum() {
        $year = $this->year;
        $acomptes = Invoice::with('acomptes')
            ->unpaid()
            ->whereHas('acomptes', function ($q) use ($year) {
                $q->whereYear('date', $year);
            })
            ->with(['acomptes' => function ($q) use ($year) {
                $q->whereYear('date', $year);
            }])
            ->where('statut', true)
            ->sum('montant');
        return $acomptes;
    }

    function compta($invoice_id){
        $invoice = Invoice::find($invoice_id);
        $invoice->comptabilise = !$invoice->comptabilise;
        $invoice->save();
    }
}
