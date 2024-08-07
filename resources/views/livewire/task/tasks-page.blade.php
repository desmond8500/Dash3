<div>
    @component('components.layouts.page-header', ['title'=> 'Taches', 'breadcrumbs' => $breadcrumbs])
        {{-- @livewire('erp.task-add') --}}
        <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
    @endcomponent

    @livewire('erp.tasklist')
</div>
