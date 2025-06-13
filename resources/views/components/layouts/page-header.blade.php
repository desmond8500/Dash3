<div class="page-header mb-3">
    <div class="row ">
        <div class="col">
            <div class="mb-1">
                <ol class="breadcrumb" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                    @isset($breadcrumbs)
                        @foreach ($breadcrumbs as $bread)
                            @if ($loop->last)
                                <li class="breadcrumb-item active" aria-current="page"><a href="{{ $bread['route'] }}">{{ $bread['name'] }}</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ $bread['route'] }}">{{ $bread['name'] }}</a></li>
                            @endif
                        @endforeach
                    @endisset
                </ol>
            </div>
            <h2 class="page-title">
                <span class="text-truncate">{{ $title ?? 'Title' }}</span>
            </h2>
        </div>
        <div class="col-auto">

            <div class="d-none d-sm-block">
                {{ $slot }}
            </div>

            <div class="d-block d-sm-none">

                <button class='btn btn-primary btn-icon' wire:click="$dispatch('open-actionButtons')"><i class='ti ti-plus'></i> </button>

                @component('components.modal', ["id"=>'actionButtons', 'title' => 'Actions'])
                    {{ $slot }}


                    <script>
                        window.addEventListener('open-actionButtons', event => { $('#actionButtons').modal('show'); })
                    </script>
                    <script>
                        window.addEventListener('close-actionButtons', event => { $('#actionButtons').modal('hide'); })
                    </script>
                @endcomponent
            </div>

        </div>
    </div>
</div>
