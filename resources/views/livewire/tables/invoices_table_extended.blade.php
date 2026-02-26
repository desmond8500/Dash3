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
    public $statut;

    protected $listeners = ['get-invoices' => 'render'];

    public InvoiceForm $invoice_form;

    function mount($projet_id)
    {
        $this->projet_id = $projet_id;
    }

    public function with(): array
    {
        return [
            'invoices' => $this->get_invoices(),
            'statuses' => \App\Http\Controllers\InvoiceController::statut(),
        ];
    }

    // Status
    function update_status($invoice_id, $status)
    {
        $invoice = Invoice::find($invoice_id);
        $invoice->statut = $status;
        $invoice->save();
    }

    // Invoice

    function get_invoices(){
        if ($this->statut) {
            return Invoice::orderByDesc('created_at')
            ->where('projet_id',$this->projet_id)
            ->where('statut',$this->statut)
            ->search($this->search,'reference')
            ->paginate(8);
        } else {
            return Invoice::orderByDesc('created_at')
            ->where('projet_id',$this->projet_id)
            ->search($this->search,'reference')
            ->paginate(8);
        }
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

    function toggleInvoiceFavorite($id)
    {
        $this->invoice_form->set($id);
        $this->invoice_form->favorite();
    }

    function dupliquer($invoice_id)
    {
        $this->invoice_form->replicate($invoice_id);
    }

}; ?>

<div class="card">
    <div class="card-header">
        <div class="card-title">Devis</div>
        <div class="card-actions">
            <div class="btn-list">
                <div class="input-icon mb-2">
                    <input type="text" class="form-control form-control-rounded" wire:model.live="search"
                        placeholder="Chercher">
                    <span class="input-icon-addon">
                        <i class="ti ti-search"></i>
                    </span>
                </div>
                @livewire('invoice_add_extended', ['projet_id' => $projet_id], key(2))
                <div class="col-2 text-center" >
                    @include('_buttons.quotation_filter')
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            @if ($invoices->count())
                <thead >
                    <tr>
                        <th style="width:5px">#</th>
                        <th style="width:120px">Références</th>
                        <th>Description</th>
                        <th style="width: 120px" class="text-center">statut</th>
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
                            <div class="text-muted" data-bs-toggle="tooltip" title="Date de création" style="font-size:12px;">
                               <i class="ti ti-calendar-plus" style="font-size:15px;"></i>  {{ $invoice->formatDate($invoice->created_at)  }}
                            </div>
                            @if ($invoice->paydate)
                                <div class="text-success" data-bs-toggle="tooltip" title="Date de paiement" style="font-size:12px;">
                                    <i class="ti ti-calendar-check" style="font-size:15px;"></i> {{ $invoice->dateFormat($invoice->paydate) }}
                                </div>
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
                            <div data-bs-toggle="tooltip" title="Total">{{ number_format($invoice->total(), 0, '.', ' ') }} F</div>

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
                                    <a @class(["dropdown-item text-danger"=>$invoice->favorite == 1, "dropdown-item text-secondary"=> $invoice->favorite == 0 ]) wire:click="toggleInvoiceFavorite('{{ $invoice->id }}')"> <i class="ti ti-heart"></i> Favoris</a>
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

    {{-- Invoice --}}
    @component('components.modal', ["id"=>'editInvoice', 'title'=>'Editer un devis', 'method'=>'update_invoice'])
        <form class="row" wire:submit="update_invoice">
            @include('_form.invoice_form',['nosection'=>false])
        </form>

        <script> window.addEventListener('open-editInvoice', event => { window.$('#editInvoice').modal('show'); }) </script>
        <script> window.addEventListener('close-editInvoice', event => { window.$('#editInvoice').modal('hide'); }) </script>
    @endcomponent
</div>
