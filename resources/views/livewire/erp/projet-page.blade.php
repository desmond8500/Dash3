<div>
    @component('components.layouts.page-header', ['title'=>'Projet: '.$projet->name, 'breadcrumbs'=>$breadcrumbs])
        <div class="btn-list">
            <a href="{{ route('timeline',['projet_id'=> $projet_id]) }}" class="btn ">Timeline</a>
            @livewire('form.task-add', ['projet_id' => $projet_id])
            @livewire('form.journal-add', ['projet_id' => $projet_id])
            @livewire('form.transaction-add', ['projet_id' => $projet_id])
            @env('local')
                <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
            @endenv
        </div>
    @endcomponent

    <div class="row g-2" wire:ignore>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" >
                        <li class="nav-item">
                            <a href="#tabs-resume" class="nav-link active" data-bs-toggle="tab">
                                <i class="ti ti-home"></i> Résumé
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="#tabs-devis" class="nav-link " data-bs-toggle="tab">
                                <i class="ti ti-file-description"></i> Devis
                            </a>
                        </li> --}}
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
                        <li class="nav-item">
                            <a href="#tabs-badge" class="nav-link" data-bs-toggle="tab">
                                <i class="ti ti-file-description"></i> Badge
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-notes" class="nav-link" data-bs-toggle="tab">
                                <i class="ti ti-file-description"></i> Notes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-structure" class="nav-link" data-bs-toggle="tab">
                                <i class="ti ti-file-description"></i> Structure
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
                            @livewire('erp.projet-resume', ['projet_id'=>$projet_id, 'buildings' => $buildings, 'invoices' => $invoices])
                        </div>

                        {{-- <div class="tab-pane  show" id="tabs-devis">
                            @livewire('erp.invoices-list', ['projet_id' => $projet_id])
                        </div> --}}

                        <div class="tab-pane" id="tabs-task">
                            @livewire('erp.tasklist', ['projet_id' => $projet_id])
                        </div>

                        <div class="tab-pane" id="tabs-journaux">
                            @livewire('erp.journaux', ['projet_id' => $projet_id],)
                        </div>

                        <div class="tab-pane" id="tabs-dossier">
                            @livewire('erp.dossier', ['projet_id' => $projet_id])
                        </div>

                        <div class="tab-pane" id="tabs-contact">
                            <h2>Contats</h2>
                            @livewire('contact-list', ['projet_id' => $projet->id, 'card_class'=>'col-md-4'])
                        </div>

                        <div class="tab-pane" id="tabs-badge">
                            @livewire('badges', ['projet_id' => $projet_id])
                        </div>

                        <div class="tab-pane" id="tabs-notes">
                            @livewire('erp.projet-notes', ['projet_id' => $projet->id], )
                        </div>

                        <div class="tab-pane" id="tabs-notes">
                            @livewire('erp.projet-notes', ['projet_id' => $projet->id], )
                        </div>

                        <div class="tab-pane" id="tabs-structure">
                            @livewire('erp.building-list', ['projet_id' => $projet->id])
                        </div>

                        <div class="tab-pane" id="tabs-reglages">
                            <h2>Settings tab</h2>
                            <div>Donec ac vitae diam amet vel leo egestas consequat rhoncus in luctus amet, facilisi sit mauris
                                accumsan nibh habitant senectus</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
