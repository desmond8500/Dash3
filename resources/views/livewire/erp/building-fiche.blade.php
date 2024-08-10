<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">Fiches</div>
            <div class="card-actions">
                <a class="btn btn-primary" href="{{ route('esser_pdf') }}" target="_blank">
                    <i class="ti ti-plus"></i> Fiche
                </a>
                <a class="btn btn-primary" href="{{ route('esser_pdf2') }}" target="_blank">
                    <i class="ti ti-plus"></i> Fiche 2
                </a>
                <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
            </div>
        </div>
        <div class="card-body">
            <ul>
                <li>Fiche Extinction Esser</li>
                <li>Fiche Détection  Esser Flexes</li>
            </ul>

        </div>
        <div class="card-footer">

        </div>
    </div>
</div>
