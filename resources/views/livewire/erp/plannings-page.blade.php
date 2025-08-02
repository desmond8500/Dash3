<div>
    @component('components.layouts.page-header', ['title'=> 'Plannings'])
        <div class="btn-list">
            {{-- <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button> --}}
            <button class="btn btn-primary" wire:click="add_rv">Ajouter</button>
        </div>
    @endcomponent

    @dump($rvs)
    @dump($rvs2)
    @dump($availability)
    @dump($appointments)
    @dump($blocked)
    @dump($schedule)
</div>
