<div>
    @component('components.layouts.page-header', ['title'=>'Gestion de batiment', 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            @livewire('form.add-fiche-zone', ['fiche_id' => $fiche->id])
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Liste des zones</div>
                    <div class="card-actions">
                        <a class="btn btn-outline-primary btn-icon" href="{{ route('fiche_pdf',['fiche_id'=>$fiche->id]) }}" target="_blank">
                            <i class="ti ti-file-type-pdf"></i>
                        </a>
                    </div>
                </div>
                <table class="table table-hover">
                    <thead class="sticky-top">
                        <tr>
                            <td>#</td>
                            <td>Zone</td>
                            <td>Equipement</td>
                            <td>Nom</td>
                            <td>Code</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($zones ?? [] as $key => $zone)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $zone->number }}</td>
                                <td>{{ $zone->name }}</td>
                                <td>{{ $zone->code }}</td>
                                <td>{{ $zone->equipement }}</td>
                                <td style="width:50px">
                                    <button class="btn btn-primary btn-icon" wire:click="edit('{{ $zone->id }}')">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
    </div>

    @component('components.modal', ["id"=>'editFicheZone', 'title' => 'Editer une zone'])
        <form class="row" wire:submit="update">
            @include('_form.fiche_zone_form')
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" wire:click="delete">
                    <i class="ti ti-trash"></i>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <script> window.addEventListener('open-editFicheZone', event => { $('#editFicheZone').modal('show'); }) </script>
        <script> window.addEventListener('close-editFicheZone', event => { $('#editFicheZone').modal('hide'); }) </script>
    @endcomponent
</div>
