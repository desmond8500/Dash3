<?php

use Livewire\Volt\Component;
use \App\Models\Invoice;
use \App\Models\InvoiceSpent;
use \App\Models\InvoiceAcompte;

new class extends Component {
    public $invoice_id;
    public $invoice;

    function mount($invoice_id) {
        $this->invoice_id = $invoice_id;
        $this->invoice = \App\Models\Invoice::find($this->invoice_id);
    }

    #On('invoice_resume_reload')
    public function with(): array {
        return [
            'spents' => InvoiceSpent::where('invoice_id', $this->invoice_id)->get(),
            'acomptes' => InvoiceAcompte::where('invoice_id', $this->invoice_id)->where('statut', 1)->get(),
        ];
    }

}; ?>

<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Budget</div>
            <div class="card-actions">
                <a href="{{ route('invoice_resume_pdf2',['invoice_id'=>$invoice->id ]) }}" target="_blank" class="btn btn-icon btn-primary">
                    <i class="ti ti-pdf"></i>
                </a>
            </div>
        </div>
        <table class="table table-hover">
            <tbody>
                <tr>
                    <td>Total Devis</td>
                    <td class="text-end">{{ number_format($invoice->total(), 0,'.', ' ') }} F</td>
                </tr>
                <tr >
                    <td class='bg-green-lt'>Total Acomptes</td>
                    <td class="text-end bg-green-lt">{{ number_format($acomptes->sum('montant'), 0,'.', ' ') }} F</td>
                </tr>
                <tr >
                    <td class='bg-green-lt'>Restant Acompte</td>
                    <td class="text-end bg-green-lt">{{ number_format($acomptes->sum('montant') - $spents->sum('montant'), 0,'.', ' ') }} F</td>
                </tr>
                <tr>
                    <td class='bg-red-lt'>Total Dépenses</td>
                    <td class="text-end bg-red-lt">{{ number_format($spents->sum('montant'), 0,'.', ' ') }} F</td>
                </tr>
                <tr>
                    <td class='bg-red-lt'>Reliquat</td>
                    <td class="text-end bg-red-lt">{{ number_format($invoice->total() - $spents->sum('montant'), 0,'.', ' ') }} F</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
