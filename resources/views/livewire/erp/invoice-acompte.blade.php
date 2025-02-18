<div class="mb-2">

    <div class="card">
        <div class="card-header">
            <div class="card-title">Acompte: {{ number_format($acomptes->sum('montant'), 0,'.', ' ') }} F CFA</div>
            <div class="card-actions">
                <button class="btn btn-primary btn-icon" wire:click="$dispatch('open-add-invoiceAcompte')">
                    <i class="ti ti-plus"></i>
                </button>
            </div>
        </div>
        <table class="table">
            @if ($acomptes->isEmpty())
                <div class="text-center pt-1 text-muted">Aucun acompte</div>

            @else
                <thead>
                    <tr>
                        <th style="text-align:center; width: 5px;">#</th>
                        <th>Nom</th>
                        <th style="text-align:center; width: 10px;">Montant</th>
                        <th style="text-align:center; width: 30px;">Date</th>
                        <th style="text-align:center; width: 10px;">_</th>
                    </tr>
                </thead>
            @endif
            <tbody>
                @foreach ($acomptes as $key => $acompte)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <div>{{ $acompte->name }}</div>
                            <div class="text-muted">{{ nl2br($acompte->description) }}</div>
                        </td>
                        <td class="text-end">{{ number_format($acompte->montant, 0,'.', ' ') }} F</td>
                        <td class="text-end">
                            <div>{{ $acompte->date }}</div>
                            <div>
                                @if ($acompte->statut)
                                    <span class="text-success">Payé</span>
                                @else
                                    <span class="text-danger">Payé</span>
                                @endif
                            </div>
                        </td>
                        <td>

                            <div class="dropdown">
                                <button class="btn btn-icon" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    <i class="ti ti-dots-vertical"></i>
                                </button>

                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item text-success" href="#" wire:click="edit('{{ $acompte->id }}')"><i class="ti ti-edit"></i> Editer</a>
                                    <a class="dropdown-item text-danger" href="#" wire:click="delete('{{ $acompte->id }}')"><i class="ti ti-trash"></i> Supprimer</a>
                                    <a class="dropdown-item" target="_blank" href="{{ route('facture_acompte_pdf',[
                                        'invoice_id'=>$acompte->invoice_id,
                                        'type'=>" Facture d'acompte",'acompte_id'=>$acompte->id]) }}"> <i class="ti ti-file-type-pdf"></i> Facture d'acompte </a>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @component('components.modal', ["id"=>'add-invoiceAcompte', 'title' => 'Ajouter un acompte'])
        <form class="row" wire:submit="store">
            @include('_form.acompte_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-add-invoiceAcompte', event => { window.$('#add-invoiceAcompte').modal('show'); }) </script>
        <script> window.addEventListener('close-add-invoiceAcompte', event => { window.$('#add-invoiceAcompte').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'edit-invoiceAcompte', 'title' => 'Editer un acompte'])
        <form class="row" wire:submit="update">
            @include('_form.acompte_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-edit-invoiceAcompte', event => { window.$('#edit-invoiceAcompte').modal('show'); }) </script>
        <script> window.addEventListener('close-edit-invoiceAcompte', event => { window.$('#edit-invoiceAcompte').modal('hide'); }) </script>
    @endcomponent

</div>
