<div class="">

    <div class="card">
        <div class="card-header">
            <div class="card-title">Documents</div>
            <div class="card-actions">
                <button class="btn btn-primary btn-icon" wire:click="$dispatch('open-add-invoiceDocument')" data-bs-toggle="tooltip" title="Ajouter un document">
                    <i class="ti ti-plus"></i>
                </button>
            </div>
        </div>
        @if ($documents->isEmpty())
        <div class="card-body">
            <div class="text-center text-muted">Aucun document</div>
        </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align:center; width: 5px;">#</th>
                        <th>Document</th>
                        <th style="text-align:center; width: 30px;">Type</th>
                        <th style="text-align:center; width: 10px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $key => $document)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <a href="{{ asset($document->file) }}" target="_blank">{{ $document->name }}</a>
                        </td>
                        <td>
                            <div>{{ $document->type }}</div>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-icon" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>

                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    {{-- <a class="dropdown-item text-success"  href="#" wire:click="edit('{{ $document->id }}')"><i class="ti ti-edit"></i> Editer</a> --}}
                                    <a class="dropdown-item text-danger" href="#" wire:click="delete('{{ $document->id }}')"><i class="ti ti-trash"></i> Supprimer</a>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @component('components.modal', ["id"=>'add-invoiceDocument', 'title' => 'Ajouter un document', 'method' => 'store'])
        <form class="row" wire:submit="store">
            @include('_form.invoice_document_form')
        </form>
        <script> window.addEventListener('open-add-invoiceDocument', event => { window.$('#add-invoiceDocument').modal('show'); }) </script>
        <script> window.addEventListener('close-add-invoiceDocument', event => { window.$('#add-invoiceDocument').modal('hide'); }) </script>
    @endcomponent

    @component('components.modal', ["id"=>'edit-invoiceDocument', 'title' => 'Editer une dépense', 'method' => 'update'])
        <form class="row" wire:submit="update">
            @include('_form.invoice_document_form')
        </form>
        <script> window.addEventListener('open-edit-invoiceDocument', event => { window.$('#edit-invoiceDocument').modal('show'); }) </script>
        <script> window.addEventListener('close-edit-invoiceDocument', event => { window.$('#edit-invoiceDocument').modal('hide'); }) </script>
    @endcomponent

</div>
