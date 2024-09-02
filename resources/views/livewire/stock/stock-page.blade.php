<div>
    @component('components.layouts.page-header', ['title'=>'Stock', 'breadcrumbs'=>$breadcrumbs])
        <button class="btn btn-icon" wire:click='$refresh'><i class="ti ti-reload"></i> </button>
    @endcomponent

    <div class="row g-2">
        @foreach ($sections as $section)
            <a class="col-md-3" href="{{ route($section['route']) }}">
                <div class="card p-2">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <img src="" alt="{{ $section['count'] }}" class="avatar">
                        </div>
                        <div class="col">
                            <div class="fw-bold">{{ $section['name'] }}</div>
                            {{-- <div class="text-muted">Description</div> --}}
                        </div>
                        <div class="col-auto">

                      </div>
                    </div>
                </div>
            </a>
        @endforeach

        <div class="col-md-6">

        </div>
        <div class="col-md-6">
            <div class="mt-2">
                @livewire('stock.commandes')

            </div>
        </div>
    </div>

</div>
