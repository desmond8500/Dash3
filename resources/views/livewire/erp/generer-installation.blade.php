<div class="row">
    <div class="col">
        <div>{{ $system_name }}</div>


    </div>
    <div class="col-auto">
        <div class="dropdown open">
            <button class="btn" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                <i class="ti ti-chevron-down"></i> Sélectionnez un système
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                @foreach ($systems as $system)
                    <a class="dropdown-item" wire:click="$set('system_name', '{{ $system->name }}')"> <i class="ti ti-edit"></i> {{ $system->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
