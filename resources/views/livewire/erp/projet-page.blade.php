<div>
    @component('components.layouts.page-header', ['title'=>'Projet: '.$projet->name, 'breadcrumbs'=>$breadcrumbs])
        {{-- @if ()

        @endif --}}
    @endcomponent


    <div class="row g-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                        <li class="nav-item">
                            <a href="#tabs-resume" class="nav-link active" data-bs-toggle="tab">
                                <i class="ti ti-home"></i> Résumé
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-devis" class="nav-link " data-bs-toggle="tab">
                                <i class="ti ti-file-description"></i> Devis
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-task" class="nav-link" data-bs-toggle="tab">
                                <i class="ti ti-file-description"></i> Taches
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-journaux" class="nav-link" data-bs-toggle="tab">
                                <i class="ti ti-file-description"></i> Journaux
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-dossier" class="nav-link" data-bs-toggle="tab">
                                <i class="ti ti-file-description"></i> Dossier
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-contact" class="nav-link" data-bs-toggle="tab">
                                <i class="ti ti-file-description"></i> Contacts
                            </a>
                        </li>
                        <li class="nav-item ms-auto">
                            <a href="#tabs-reglages" class="nav-link" title="Settings" data-bs-toggle="tab">
                                <i class="ti ti-settings"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-resume">
                            @component('components.erp.projet.projet-resume',['projet'=>$projet, 'buildings' => $buildings])

                            @endcomponent
                        </div>

                        <div class="tab-pane  show" id="tabs-devis">
                            @livewire('erp.invoices-list', ['projet_id' => $projet_id])


                        </div>

                        <div class="tab-pane" id="tabs-task">
                            <h2>Liste des Taches</h2>
                            <div>
                                @livewire('erp.tasklist', ['projet_id' => $projet_id])
                            </div>
                        </div>

                        <div class="tab-pane" id="tabs-journaux">
                            <h2>Journal d'activité</h2>

                            @livewire('form.journal-add')

                            <div>

                            </div>
                        </div>

                        <div class="tab-pane" id="tabs-dossier">
                            <h2>Dossier</h2>
                            <div>Fringilla egestas nunc quis tellus diam rhoncus ultricies tristique enim at diam, sem nunc amet,
                                pellentesque id egestas velit sed</div>
                        </div>

                        <div class="tab-pane" id="tabs-reglages">
                            <h2>Settings tab</h2>
                            <div>Donec ac vitae diam amet vel leo egestas consequat rhoncus in luctus amet, facilisi sit mauris
                                accumsan nibh habitant senectus</div>
                        </div>

                        <div class="tab-pane" id="tabs-contact">
                            <h2>Contats</h2>
                            <div>Donec ac vitae diam amet vel leo egestas consequat rhoncus in luctus amet, facilisi sit mauris
                                accumsan nibh habitant senectus</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>



</div>
