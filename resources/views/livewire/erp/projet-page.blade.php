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
            @if ($projet->favorite )
                <button class="btn btn-ghost-danger btn-icon" wire:click="toggleFavorite"><i class="ti ti-star-filled"></i></button>
            @else
                <button class="btn btn-ghost-secondary btn-icon" wire:click="toggleFavorite"><i class="ti ti-star"></i></button>
            @endif
        </div>
    @endcomponent

    <div class="row mb-3">
        <div class="col-md-4">
            <div class="mb-3">
                @livewire('cards/projet_card_extended', ['projet_id' => $projet_id])
            </div>
            <div class="mb-3">
                @livewire('tables/buildings_list_extended', ['projet_id' => $projet_id])
            </div>
        </div>
        <div class="col-md-8">
            <nav class="nav nav-segmented w-100 mb-2 border  " role="tablist" wire:ignore>
                <button class="nav-link active" role="tab" data-bs-toggle="tab" aria-selected="true" aria-current="page" wire:click="$set('tabs', 'devis')">
                    Devis
                </button>
                <button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1" wire:click="$set('tabs', 'taches')">
                    Taches
                </button>
                <button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1" wire:click="$set('tabs', 'contacts')">
                    Contacts
                </button>
                <button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1" wire:click="$set('tabs', 'badges')">
                    Badges
                </button>
                <button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1" wire:click="$set('tabs', 'notes')">
                    Notes
                </button>
                <button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1" wire:click="$set('tabs', 'journaux')">
                    Journaux
                </button>
                <button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1" wire:click="$set('tabs', 'documents')">
                    Documents
                </button>
                <button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1" wire:click="$set('tabs', 'installations')">
                    Installations
                </button>
            </nav>

            @switch($tabs)
                @case("devis")
                    @livewire('tables/invoices_table_extended', ['projet_id' => $projet_id])
                @break
                @case("taches")
                    @livewire('tasklist_simple_extended', ['projet_id' => $projet_id], key("project-tasks-".$projet_id))
                    {{-- @livewire('erp.tasks.tasklist1', ['projet_id' => $projet_id]) --}}
                @break
                @case("contacts")
                    <div class="border border-primary p-2 rounded mt-2">
                        @livewire('contact-list', ['projet_id' => $projet_id, 'card_class' => 'col-md-6', 'paginate'=>10])
                    </div>
                @break

                @case("badges")
                    @livewire('badges', ['projet_id' => $projet_id])
                @break
                @case("notes")
                    @livewire('erp.projet-notes', ['projet_id' => $projet_id])
                @break
                @case("documents")
                    @livewire('tables/documents_list_extended', ['projet_id' => $projet_id])
                @break

                @case("journaux")
                    @livewire('erp.journaux', ['projet_id' => $projet_id, 'class'=> 'col-md-6', 'paginate' => 8],)
                @break

                @case("installations")
                    @livewire('erp.installations', ['projet_id' => $projet_id])
                @break

                @default

            @endswitch
        </div>
    </div>



</div>
