<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Propositions Technique</div>
            <div class="card-actions">
                <button class='btn btn-primary btn-icon' wire:click="$dispatch('open-addInvoiceProposal')" ><i class='ti ti-plus'></i> </button>
            </div>
        </div>
        <div class="p-2">
            @foreach ($proposals as $key => $proposal)
                <div class="card p-2 mb-1">
                    <div class="row">
                        <a class="col" href="{{ route('invoice_proposal', ['proposal_id' => $proposal->id]) }}" target="_blank">
                            <div class="card-title">Proposition {{ $key+1 }}</div>
                        </a>
                        <div class="col-auto">
                          <button class="btn btn-outline-primary btn-icon" wire:click="edit('{{ $proposal->id }}')">
                            <i class="ti ti-edit"></i>
                          </button>
                          <button class="btn btn-outline-danger btn-icon" wire:click="delete('{{ $proposal->id }}')">
                            <i class="ti ti-trash"></i>
                          </button>
                      </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="card-footer">

        </div>
    </div>


    @component('components.modal', ["id"=>'addInvoiceProposal', 'title' => 'Ajouter une proposition technique', 'size' => 'modal-lg', 'method'=>'store'])
        <form class="row" wire:submit="store">
            @include('_form.invoice_proposal_form')
        </form>
        <script> window.addEventListener('open-addInvoiceProposal', event => { window.$('#addInvoiceProposal').modal('show'); }) </script>
        <script> window.addEventListener('close-addInvoiceProposal', event => { window.$('#addInvoiceProposal').modal('hide'); }) </script>
    @endcomponent
    @component('components.modal', ["id"=>'editInvoiceProposal', 'title' => 'Editer une proposition technique', 'size' => 'modal-lg', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.invoice_proposal_form')
        </form>
        <script> window.addEventListener('open-editInvoiceProposal', event => { window.$('#editInvoiceProposal').modal('show'); }) </script>
        <script> window.addEventListener('close-editInvoiceProposal', event => { window.$('#editInvoiceProposal').modal('hide'); }) </script>
    @endcomponent
</div>
