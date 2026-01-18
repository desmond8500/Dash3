<div>
    @component('components.layouts.page-header', ['title'=> 'Test page'])
        <div class="btn-list">
            <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
        </div>
    @endcomponent

    <a href="{{ route('pdf_v1',['title' => 'Document V1.0'])}}" target="_blank" class="btn btn-primary" >
        PDF
    </a>


</div>
