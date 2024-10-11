<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Calcul d'autonomie</div>
            <div class="card-actions">
                <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Charge en watts </label>
                        <input type="number" min="1" class="form-control" wire:model.live="charge" placeholder="Ex: 1500w">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Autonomie souhaitée en heure {{ $autonomie }}</label>
                        <input type="number" min="0.1" class="form-control" wire:model.live="autonomie" placeholder="Ex: 2h">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Capacité des Batteries {{ $autonomie }}</label>
                        <input type="number" min="1" class="form-control" wire:model.live="batterie" placeholder="Ex: 7 Ah">
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="mb-3">Ampères : {{ round($charge/12, 1) }} A</div>
                    <div class="mb-3">Autonomie : {{ round(($charge/12)*$autonomie, 1) }} Ah</div>
                    <div class="mb-3">Batteries : {{ round((($charge/12)*$autonomie)/$batterie, 1) }} Batteries</div>
                    <div class="mb-3">Marge : {{ round(((($charge/12)*$autonomie)/$batterie)*1.2, 1) }} Batteries</div>
                </div>

            </div>


        </div>
        <div class="card-footer">

        </div>
    </div>
</div>
