<div>
    <div class="d-flex justify-content-between">
        <h2>Fichiers</h2>
        <div class="btn-list">
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    </div>

    <div>
        @foreach ($buildings as $building)
            <div class="row row-deck g-2">
                @foreach ($building->documents as $document)
                <div class="col-md-4">
                    @include('_card.building_document')
                </div>
                @endforeach

            </div>
        @endforeach

    </div>

    <hr>


    <a class="btn btn-primary" target="_blank" href="{{ route('test_pdf') }}">PDF Test</a>
    <a class="btn btn-primary" target="_blank" href="{{ route('proces_verbal_pdf') }}">Process Verbal</a>
    <a class="btn btn-primary" target="_blank" href="{{ route('doe_pdf') }}">DOE</a>
    <hr>


</div>
