<div>
    @component('components.layouts.page-header', ['title'=>'Achats', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.article-add')
            @livewire('form.achat-add')
            @livewire('form.provider-add')
            @livewire('form.brand-add')
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent


    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th width="10px">#</th>
                    <th>Nom</th>
                    <th width="10px" class="bg-red-lt text-center">Date</th>
                    <th width="120px" class="bg-blue-lt text-center">TVA</th>
                    <th width="150px" class="text-end">Total</th>
                    <th class="text-center">Facture</th>
                    <th width="130px" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($achats as $key => $achat)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <a href="{{ route('achat', ['achat_id'=> $achat->id]) }}">{{ $achat->name }}</a> <br>
                            <a href="{{ route('achat', ['achat_id'=> $achat->id]) }}" class="text-muted">{!! nl2br($achat->description) !!}</a>
                        </td>
                        <td class="text-center">{{ $achat->date }}</td>
                        <td class="text-center">{{ number_format($achat->tva(), 0, 2) }} F</td>
                        <td class="text-end">
                            <div>{{ number_format($achat->total(), 0, 2) }} F HT<span class="text-white">C</span> </div>
                            <div class="text-danger">{{ number_format($achat->ttc(), 0, 2) }} F TTC</div>
                        </td>
                        <td>
                            @foreach ($achat->factures as $facture)
                                <div class="d-flex justify-content-between mb-1">
                                    <a href="{{ asset($facture->folder) }}" target="_blank">
                                        <i class="ti ti-file-pdf"></i>
                                        {{ basename($facture->folder) }}
                                    </a>
                                </div>
                            @endforeach
                        </td>
                        <td class="text-end">
                            <div class="btn-list">
                                <button class="btn btn-primary btn-icon" wire:click="edit('{{ $achat->id }}')">
                                    <i class="ti ti-edit"></i>
                                </button>
                                @if (!$achat->transaction_id)
                                    <button class="btn btn-primary btn-icon" wire:click="add_transaction('{{ $achat->id }}')">
                                        <i class="ti ti-coins"></i>
                                    </button>
                                @endif

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @component('components.modal', ["id"=>'editAchat', 'title'=>"Editer l'achat"])
        <form class="row" wire:submit="update">
            @include('_form.achat_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editAchat', event => { $('#editAchat').modal('show'); }) </script>
        <script> window.addEventListener('close-editAchat', event => { $('#editAchat').modal('hide'); }) </script>
    @endcomponent

</div>
