<div>
    @component('components.layouts.page-header', ['title'=> 'Projets', 'breadcrumbs'=>$breadcrumbs])
    <div class="d-flex">
        <input type="text" class="form-control" wire:model.live="search" placeholder="Rechercher"
            wire:keydown.enter='ProjetSearch'>
        <button class="btn btn-primary ms-1" wire:click="$dispatch('open-addProjet')">
            <i class="ti ti-plus"></i> Projet
        </button>
    </div>
    @endcomponent

    <div class="row row-cards g-2" data-masonry='{"percentPosition": true }'>
        @forelse ($projets as $projet)
            <div class="col-md-3">
                @include('_card.projet_card')
            </div>
        @empty
            @component('components.no-result')

            @endcomponent
        @endforelse
        <div class="mt-1">
            {{ $projets->links() }}
        </div>
    </div>

    @component('components.modal', ["id"=>'addProjet', 'title'=> 'Ajouter un projet'])
    <form class="row" wire:submit="store">
        @include('_form.projet_form')
    </form>
    <script>
        window.addEventListener('open-addProjet', event => { $('#addProjet').modal('show'); })
    </script>
    <script>
        window.addEventListener('close-addProjet', event => { $('#addProjet').modal('hide'); })
    </script>
    @endcomponent

    @component('components.modal', ["id"=>'editProjet', 'title'=> 'Editer un projet'])
    <form class="row" wire:submit="update">
      @include('_form.projet_form')
    </form>
    <script>
        window.addEventListener('open-editProjet', event => { $('#editProjet').modal('show'); })
    </script>
    <script>
        window.addEventListener('close-editProjet', event => { $('#editProjet').modal('hide'); })
    </script>
    @endcomponent
</div>
