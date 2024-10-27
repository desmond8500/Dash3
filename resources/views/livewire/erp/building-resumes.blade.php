<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col">
                <h2>Résumé</h2>
            </div>
            <div class="col-auto">
                <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-2">
            <div class="card-header">
                <div class="card-title">{{ $building->name }}</div>
                <div class="card-actions">
                    <button class="btn btn-primary btn-icon" wire:click="editBuilding"><i class="ti ti-edit"></i></button>
                </div>
            </div>
            <div class="card-body">
                {{ nl2br($building->description) }}
            </div>
        </div>

    </div>
    <div class="col-md-8">

    </div>
</div>
