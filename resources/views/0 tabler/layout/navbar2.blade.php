 <div class="collapse navbar-collapse" id="navbar-menu">
    <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
        <ul class="navbar-nav">
            {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                    </span>
                    <span class="nav-link-title">
                        Erp
                    </span>
                    </a>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('tabler.erp.clients') }}" >
                        Clients
                    </a>
                    <a class="dropdown-item" href="{{ route('tabler.erp.finances') }}" >
                        Finances
                    </a>
                    <a class="dropdown-item" href="{{ route('tabler.erp.config') }}" >
                        Configurations
                    </a>

                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3" /><line x1="12" y1="12" x2="20" y2="7.5" /><line x1="12" y1="12" x2="12" y2="21" /><line x1="12" y1="12" x2="4" y2="7.5" /></svg>
                    </span>
                    <span class="nav-link-title">
                        Stock
                    </span>
                    </a>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('tabler.stock.articles') }}" >
                        Articles
                    </a>
                    <a class="dropdown-item" href="{{ route('tabler.stock.fournisseurs') }}" >
                        Fournisseurs
                    </a>

                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="15" y1="8" x2="15.01" y2="8" /><rect x="4" y="4" width="16" height="16" rx="3" /><path d="M4 15l4 -4a3 5 0 0 1 3 0l5 5" /><path d="M14 14l1 -1a3 5 0 0 1 3 0l2 2" /></svg>
                    </span>
                    <span class="nav-link-title">
                        Medias
                    </span>
                    </a>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('tabler.medias.images') }}" >
                        Images
                    </a>
                    <a class="dropdown-item" href="{{ route('tabler.medias.videos') }}" >
                        Videos
                    </a>

                    </div>
                </li> --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10h3v-3l-3.5 -3.5a6 6 0 0 1 8 8l6 6a2 2 0 0 1 -3 3l-6 -6a6 6 0 0 1 -8 -8l3.5 3.5" /></svg>
                    </span>
                    <span class="nav-link-title">
                        Admin
                    </span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" target="_blank" href="{{ route('home') }}" >
                        Infyom
                    </a>
                    <a class="dropdown-item" target="_blank" href="https://ssh-smi.alwaysdata.net/" >
                        Server
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
