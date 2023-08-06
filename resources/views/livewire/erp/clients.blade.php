<div>
    @component('components.layout.page-header', ['title'=> 'Clients', 'breadcrumbs' => $breadcrumbs])
    <div class="btn-list">
        <button class="btn btn-primary" >Button</button>
        <button class="btn btn-primary" wire:click='inc' >Button</button>
    </div>
    @endcomponent

   <div class="row row-deck">
    <div class="col">
        Test = {{ $test }}
    </div>
   </div>
</div>
