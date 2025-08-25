<div class="mb-2">

    <div class="card">
        <div class="card-header">
            <div class="card-title">Dépenses: {{ number_format($spents->sum('montant'), 0,'.', ' ') }} F CFA</div>
            <div class="card-actions">
                <button class="btn btn-primary btn-icon" wire:click="$dispatch('open-add-invoiceSpent')">
                    <i class="ti ti-plus"></i>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                @if ($spents->isEmpty())
                    <div class="text-center pt-1 text-muted">Aucune dépense</div>
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
                    @foreach ($spents as $key => $spent)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <div>{{ $spent->name }}</div>
                            <div class="text-muted">{!! nl2br($spent->description) !!}</div>
                        </td>
                        <td class="text-end">{{ number_format($spent->montant, 0,'.', ' ') }} F</td>
                        <td class="text-end">
                            <div>{{ $spent->formatDate() }}</div>
                        </td>
                        <td>

                            <div class="dropdown">
                                <button class="btn btn-icon" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>

                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item text-success" href="#" wire:click="edit('{{ $spent->id }}')"><i class="ti ti-edit"></i> Editer</a>
                                    <a class="dropdown-item text-danger" href="#" wire:click="delete('{{ $spent->id }}')"><i class="ti ti-trash"></i> Supprimer</a>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @component('components.modal', ["id"=>'add-invoiceSpent', 'title' => 'Ajouter une dépense', 'method'=>'store'])
    <form class="row" wire:submit="store">
        @include('_form.spent_form')
    </form>
    <script> window.addEventListener('open-add-invoiceSpent', event => { window.$('#add-invoiceSpent').modal('show'); }) </script>
    <script> window.addEventListener('close-add-invoiceSpent', event => { window.$('#add-invoiceSpent').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'edit-invoiceSpent', 'title' => 'Editer une dépense', 'method'=>'update'])
        <form class="row" wire:submit="update">
            @include('_form.spent_form')
        </form>
        <script> window.addEventListener('open-edit-invoiceSpent', event => { window.$('#edit-invoiceSpent').modal('show'); }) </script>
        <script> window.addEventListener('close-edit-invoiceSpent', event => { window.$('#edit-invoiceSpent').modal('hide'); }) </script>
    @endcomponent

</div>
