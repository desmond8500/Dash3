<div>
    @section('page-title')
        Configuration de l'interface
    @endsection
    @section('page-action')

    @endsection
    @section('breadcrumb')
        {{-- <li class="breadcrumb-item"><a href="{{ route('tabler.erp.clients') }}">Clients</a></li> --}}
        <li class="breadcrumb-item">Administration</li>
    @endsection

    <div class="row">
        <div class="col-md-2">
            <div class="card card-body">
                <div class="subheader mb-2">Catégories</div>
                <div class="list-group list-group-transparent mb-3">
                    <a wire:click="$set('page', 'users')" class="list-group-item list-group-item-action d-flex align-items-center active" href="#">
                        Utilisateurs
                        <small class="text-muted ml-auto">{{ $users }}</small>
                    </a>
                    <a wire:click="$set('page','personnalisation')" class="list-group-item list-group-item-action d-flex align-items-center" href="#">
                        Interface
                        <small class="text-muted ml-auto"> </small>
                    </a>

                </div>
            </div>
        </div>
        <div class="col-md-9">
            @if ($page == 'users')
                @livewire("tabler.admin.users")
            @elseif($page == 'personnalisation')
                @livewire("tabler.admin.personnalisation")
            @else
                <div class="card card-body">
                    {{ $page }}
                </div>
            @endif

        </div>
    </div>
</div>
