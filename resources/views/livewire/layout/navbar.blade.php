<header class="navbar navbar-expand-md ">
    <div class="container-xl"> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href="{{ route('index') }}" wire:navigate>
                    {{ env('APP_NAME', 'Tabler') }}
                </a>
            </h1>
        </div>
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
                    @can($menu['can'])
                        @isset ($menu['submenu'])
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-third" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-title text-dark">
                                        {{ $menu['name'] }}
                                    </span>
                                </a>
                                <div class="dropdown-menu">
                                    @foreach ($menu['submenu'] as $submenu)
                                        <a class="dropdown-item" href="{{ route($submenu['route']) }}" >
                                            {{ $submenu['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route($menu['route']) }}" >
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-{{ $menu['icon'] }}"></i>
                                    </span>
                                    <span class="nav-link-title">
                                        {{ $menu['name'] }}
                                    </span>
                                </a>
                            </li>
                        @endisset
                    @endcan
                @endforeach
            @endauth

        </ul>
        <div class="navbar-nav flex-row order-md-last ms-auto">
            @auth
                <div class="btn-list align-items-center">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <img src="{{ asset($user->avatar) }}" alt="A" class="avatar avatar-sm border border-secondary">
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ $user->firstname }} {{ $user->lastname }}</div>
                                <div class="mt-1 small text-secondary">{{ $user->function ?? '_' }}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="{{ route('profile') }}" wire:navigate class="dropdown-item"><i class="ti ti-user"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('settings') }}" class="dropdown-item"><i class="ti ti-settings"></i> Paramètres</a>
                            <a wire:click="logout()" class="dropdown-item text-danger"> <i class="ti ti-logout"></i> Déconnexion</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="nav-item ">
                    <div class="btn-list">
                        <a class="btn btn-primary" wire:click="dispatch('open-login')">Connexion</a>
                        <a class="btn btn-light" wire:click="dispatch('open-register')">Inscription</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <div style="color: black">

        @component('components.modal', ["id"=>'register', 'title'=>' Inscription', 'method'=>'register'])
        <form class="row" wire:submit="register">
            @include('_form.register_form')
        </form>

            <script> addEventListener('open-register', event => { window.$('#register').modal('show'); }) </script>
            <script> addEventListener('close-register', event => { window.$('#register').modal('hide'); }) </script>
        @endcomponent

        @component('components.modal', ["id"=>'login', 'title'=>'Connexion', 'class'=>'modal-sm'])

            @include('_form.login_form')

            <script> addEventListener('open-login', event => { window.$('#login').modal('show'); }) </script>
            <script> addEventListener('close-login', event => { window.$('#login').modal('hide'); }) </script>
        @endcomponent
    </div>
</header>
