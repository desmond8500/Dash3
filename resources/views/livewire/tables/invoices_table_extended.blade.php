<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\InvoiceForm;
use Livewire\WithPagination;
use App\Models\Invoice;
use App\Http\Controllers\InvoiceController;

new class extends Component {
    use WithPagination;
    public $projet_id;
    public $search;

    public InvoiceForm $invoiceForm;

    function mount($projet_id)
    {
        $this->projet_id = $projet_id;
    }

    public function with(): array
    {
        return [
            'invoices' => Invoice::orderByDesc('id')->where('projet_id', $this->projet_id)->paginate(8),
            'statuses' => InvoiceController::statut(),
        ];
    }

    function editInvoice($id)
    {
        $this->invoice_form->set($id);
        $this->dispatch('open-editInvoice');
    }

    function update_invoice()
    {
        $this->invoice_form->update();
        $this->dispatch('close-editInvoice');
    }
    function delete_invoice($id)
    {
        $this->invoice_form->set($id);
        $message = $this->invoice_form->delete();

        if ($message == 'error') {
            $this->js("alert('Ce devis contient des sections, veuillez les supprimer avant ')");
        }

        $this->dispatch('close-editInvoice');
    }

    function toggleInvoiceFavorite()
    {
        $this->invoice_form->favorite();
    }

    function dupliquer($invoice_id)
    {
        $this->invoiceForm->replicate($invoice_id);
    }
}; ?>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover">
            @if ($invoices->count())
                <thead class="sticky-top">
                    <tr>
                        <th style="width:5px">#</th>
                        <th style="width:100px">Références</th>
                        <th>Description</th>
                        <th style="width: 120px">statut</th>
                        <th class="text-end" style="width: 130px">Total</th>
                        <th class="text-center" style="width: 10px"></th>
                    </tr>
                </thead>
            @endif
            <tbody>
                @foreach ($invoices as $key => $invoice)
                    <tr class="cursor-pointer " wire:key="{{ $invoice->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <a href="{{ route('invoice', ['invoice_id' => $invoice->id]) }}" target="_blank">
                                {{ ucfirst($invoice->reference) }}
                            </a>
                            @if ($invoice->paydate)
                                <div class="text-purple" data-bs-toggle="tooltip" title="Date de paiement">
                                    {{ $invoice->dateFormat($invoice->paydate) }}</div>
                            @endif
                        </td>
                        <td>
                            {{ $invoice->description }}
                        </td>
                        <td>
                            @component('components.status', [
                                'status' => $invoice->statut,
                                'invoice_id' => $invoice->id,
                                'statuses' => $statuses,
                            ])
                            @endcomponent
                        </td>
                        <td class="text-end">
                            <div>{{ number_format($invoice->total(), 0, '.', ' ') }} F</div>
                            <div class="text-muted" data-bs-toggle="tooltip" title="Date de création"> {{ $invoice->formatDate($invoice->created_at) }}</div>
                        </td>
                        <td>
                            <div class="dropdown open">
                                <button class="btn btn-action" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item" wire:click="dupliquer('{{ $invoice->id }}')"> <i class="ti ti-copy"></i> Dupliquer</a>
                                    <a class="dropdown-item" wire:click="editInvoice('{{ $invoice->id }}')"> <i class="ti ti-edit"></i> Editer</a>
                                    <a class="dropdown-item text-danger" wire:click="delete_invoice('{{ $invoice->id }}')"> <i class="ti ti-trash"></i> Supprimer</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $invoices->links() }}
    </div>
</div>
