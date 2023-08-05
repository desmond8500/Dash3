<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <ol class="breadcrumb" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item"><a href="#">{{ $breadcrumb['name'] }}</a></li>
                    @endforeach
                </ol>
                <h2 class="page-title">
                    {{ $title ?? "Title" }}
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
