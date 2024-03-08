@php
    $total = 0;
@endphp
<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Articles à acheter</div>
            <div class="card-actions">
                <a class="btn btn-primary" href="{{ route('commande_pdf') }}" target="_blank">PDF</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Désignation</th>
                    <th>Quantite</th>
                    <th>Prix</th>
                    <th>Total</th>
                    <th class="text-center" width="100px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commandes as $key => $commande)
                    <tr>
                        <td>{{ $key +1 }}</td>
                        <td>{{ $commande->article->designation }}</td>
                        <td>{{ $commande->quantity }}</td>
                        <td>{{ number_format($commande->article->price,0,2) }} CFA</td>
                        <td>{{ number_format($commande->article->price * $commande->quantity,0,2) }} CFA</td>
                        <td class="text-center">
                            <button class="btn btn-icon btn-primary" wire:click="increment('{{ $commande->id }}')"> <i class="ti ti-plus"></i> </button>
                            <button class="btn btn-icon btn-primary" wire:click="decrement('{{ $commande->id }}')"> <i class="ti ti-minus"></i> </button>
                        </td>
                    </tr>
                    @php
                        $total+= $commande->article->price * $commande->quantity;
                    @endphp
                @endforeach
            </tbody>
        </table>
        <div class="card-body">
            <b>TOTAL :</b> <span>{{ number_format($total,0,2) }}</span>
        </div>
    </div>

    @component('components.modal', ["id"=>'addModal', 'title' => 'Titre'])
        <form class="row" wire:submit="store">

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-addModal', event => { $('#addModal').modal('show'); }) </script>
        <script> window.addEventListener('close-addModal', event => { $('#addModal').modal('hide'); }) </script>
    @endcomponent
</div>
