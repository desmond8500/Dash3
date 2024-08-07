<div>
    <div class="d-flex justify-content-between">
        <h2>Dossier</h2>
        <div class="btn-list">
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    </div>

    <a class="btn btn-primary" target="_blank" href="{{ route('test_pdf') }}">PDF Test</a>
    <a class="btn btn-primary" target="_blank" href="{{ route('proces_verbal_pdf') }}">Process Verbal</a>
    <a class="btn btn-primary" target="_blank" href="{{ route('doe_pdf') }}">DOE</a>
</div>
