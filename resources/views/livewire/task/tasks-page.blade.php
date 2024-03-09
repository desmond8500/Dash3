<div>
    @component('components.layouts.page-header', ['title'=> 'Taches', 'breadcrumbs' => $breadcrumbs])
        {{-- @livewire('erp.task-add') --}}
    @endcomponent

    @livewire('erp.tasklist')
</div>
