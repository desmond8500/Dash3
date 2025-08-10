<div>
    @component('components.layouts.page-header', ['title'=> 'Dashboard 2'])

    @endcomponent

    <div class="row g">
        <div class="col-md">
            <div class="input-icon">
                <input type="text" class="form-control form-control-rounded" wire:model.live="search" placeholder="Chercher ">
                <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                </span>
            </div>
        </div>

    </div>

</div>
