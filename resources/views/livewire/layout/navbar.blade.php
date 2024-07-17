<header class="navbar navbar-dark navbar-expand-md d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{ route('index') }}" >
                {{ env('APP_NAME', 'Tabler') }}
            </a>
        </h1>

        {{-- Right side Buttons --}}
        <div class="navbar-nav flex-row order-md-last">
            @auth
                <div class="d-none d-md-flex">
                    <div class="nav-item dropdown d-none d-md-flex me-3">
                        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none" /> <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /> <path d="M9 17v1a3 3 0 0 0 6 0v-1" /> </svg>
                            <span class="badge bg-red"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Last updates</h3>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span
                                                    class="status-dot status-dot-animated bg-red d-block"></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 1</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    Change deprecated html tags to text decoration classes (#29604)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 2</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    justify-content:between ⇒ justify-content:space-between (#29734)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions show">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow"
                                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span class="status-dot d-block"></span></div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 3</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    Update change-version.js (#29736)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto"><span
                                                    class="status-dot status-dot-animated bg-green d-block"></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block">Example 4</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    Regenerate package-lock.json (#29730)
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#" class="list-group-item-actions">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <img src="{{ asset($user->avatar) }}" alt="A" class="avatar avatar-sm">
                        <div class="d-none d-xl-block ps-2">
                            <div>{{ $user->firstname }} {{ $user->lastname }}</div>
                            <div class="mt-1 small text-secondary">UI Designer</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        {{-- <a href="#" class="dropdown-item">Status</a> --}}
                        <a href="{{ route('profile') }}" wire:navigate class="dropdown-item">Profile</a>
                        {{-- <a href="#" class="dropdown-item">Feedback</a> --}}
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('settings') }}" class="dropdown-item">Paramètres</a>
                        <a wire:click="logout()" class="dropdown-item text-danger">Déconnexion</a>
                    </div>
                </div>
            @else
                <div class="nav-item ">
                    <div class="btn-list">
                        <a class="btn btn-primary" wire:click="dispatch('open-login')">Connexion</a>
                        <a class="btn btn-light" wire:click="dispatch('open-register')" >Inscription</a>
                    </div>
                </div>
            @endauth
        </div>

        {{-- Navbar menu Links --}}
        <div class="collapse navbar-collapse" id="navbar-menu" wire:ignore>
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}" wire:navigate>
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="ti ti-home"></i>
                            </span>
                            <span class="nav-link-title">
                                Accueil
                            </span>
                        </a>
                    </li>

                    @auth
                        @foreach ($menus as $menu)
                            @if ($menu['name'] == 'Test')
                                @env('local')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route($menu['route']) }}" wire:navigate>
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <i class="ti ti-{{ $menu['icon'] }}"></i>
                                            </span>
                                            <span class="nav-link-title">
                                                {{ $menu['name'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endenv
                            @else
                                @isset ($menu['submenu'])
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#navbar-third" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                            role="button" aria-expanded="false">
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <i class="ti ti-chevron-down"></i>
                                            </span>
                                            <span class="nav-link-title">
                                                {{ $menu['name'] }}
                                            </span>
                                        </a>
                                        <div class="dropdown-menu">
                                            @foreach ($menu['submenu'] as $submenu)
                                                <a class="dropdown-item" href="{{ route($submenu['route']) }}" wire:navigate>
                                                    {{ $submenu['name'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route($menu['route']) }}" wire:navigate>
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                <i class="ti ti-{{ $menu['icon'] }}"></i>
                                            </span>
                                            <span class="nav-link-title">
                                                {{ $menu['name'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endisset
                            @endif
                        @endforeach
                    @endauth
                </ul>
            </div>
        </div>

    </div>

    {{-- Modal Forms --}}
    <div style="color: black">

        @component('components.modal', ["id"=>'register', 'title'=>'Inscription'])
            <form class="row" wire:submit="register">
                @include('_form.register_form')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>

            <script> window.addEventListener('open-register', event => { $('#register').modal('show'); }) </script>
            <script> window.addEventListener('close-register', event => { $('#register').modal('hide'); }) </script>
        @endcomponent

        @component('components.modal', ["id"=>'login', 'title'=>'Connexion', 'class'=>'modal-sm'])

            @include('_form.login_form')

            <script> window.addEventListener('open-login', event => { $('#login').modal('show'); }) </script>
            <script> window.addEventListener('close-login', event => { $('#login').modal('hide'); }) </script>
        @endcomponent
    </div>

</header>
