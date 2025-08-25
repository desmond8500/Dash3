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

    public function with(): array {
        return [
            // 'spents' => $this->invoice->spents,
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

            </div>
        </div>
        <table class="table table-hover">
            <tbody>
                <tr>
                    <td>Total Acomptes</td>
                    <td class="text-end">{{ number_format($acomptes->sum('montant'), 0,'.', ' ') }} F</td>
                </tr>
                <tr>
                    <td>Total Dépenses</td>
                    <td class="text-end">{{ number_format($spents->sum('montant'), 0,'.', ' ') }} F</td>
                </tr>
                <tr>
                    <td>Restants</td>
                    <td class="text-end">{{ number_format($acomptes->sum('montant') - $spents->sum('montant'), 0,'.', ' ') }} F</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
