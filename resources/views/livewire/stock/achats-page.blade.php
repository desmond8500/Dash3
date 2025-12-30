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
                    <th width="100px" class="text-center">Facture</th>
                    <th width="150px" class="text-end">Actions</th>
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
                        <td class="text-center">
                            @foreach ($achat->factures as $key => $facture)
                                <div class="d-flex justify-content-between mb-1">
                                    <a href="{{ asset($facture->folder) }}" target="_blank">
                                        <i class="ti ti-file-pdf"></i>
                                        Facture {{ $key+1 }}
                                    </a>
                                </div>
                            @endforeach
                        </td>
                        <td class="text-end">
                            <div class="btn-list">
                                <button class="btn btn-primary btn-icon" wire:click="edit('{{ $achat->id }}')" data-bs-toggle="tooltip" title="Editer">
                                    <i class="ti ti-edit"></i>
                                </button>
                                @if (!$achat->rows->count() && !$achat->factures->count())
                                    <button class="btn btn-danger btn-icon" wire:click="delete('{{ $achat->id }}')" data-bs-toggle="tooltip" title="Supprimer">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                @endif
                                @if (!$achat->transaction_id)
                                    <button class="btn btn-primary btn-icon" wire:click="add_transaction('{{ $achat->id }}')" data-bs-toggle="tooltip" title="Ajouter une transaction">
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

    @component('components.modal', ["id"=>'editAchat', 'title'=>"Editer l'achat", 'method'=>"achat_update"])
        <form class="row" wire:submit="update">
            @include('_form.achat_form')
        </form>
        <script> window.addEventListener('open-editAchat', event => { window.$('#editAchat').modal('show'); }) </script>
        <script> window.addEventListener('close-editAchat', event => { window.$('#editAchat').modal('hide'); }) </script>
    @endcomponent

</div>
