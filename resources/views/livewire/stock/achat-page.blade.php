<div>
    @component('components.layouts.page-header', ['title'=>'Achat', 'breadcrumbs'=>$breadcrumbs])
    @livewire('form.achat-add')
    @endcomponent

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $achat->name }}</div>
                    <div class="card-actions">
                        <button class="btn btn-primary btn-icon" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path> <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path> <path d="M16 5l3 3"></path> </svg>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {{ nl2br($achat->description) }}
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Liste des articles</div>
                    <div class="card-actions">
                        <button class="btn btn-primary" > <i class="ti ti-plus"></i> article </button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Désignation</td>
                            <td>Quantité</td>
                            <td>Prix HT</td>
                            <td>TVA</td>
                            <td>Prix TTC</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="card-body">

                </div>
                <div class="card-footer">

                </div>
            </div>

            @component('components.modal', ["id"=>'addModal'])
                <form class="row" wire:submit="register">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
                <script> window.addEventListener('open-addModal', event => { $('#addModal').modal('show'); }) </script>
                <script> window.addEventListener('close-addModal', event => { $('#addModal').modal('hide'); }) </script>
            @endcomponent

        </div>
    </div>
</div>
