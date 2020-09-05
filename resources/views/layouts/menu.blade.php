<li class="nav-item {{ Request::is('projetClients*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('projetClients.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Projet  Clients</span>
    </a>
</li>
<li class="nav-item {{ Request::is('projetProjets*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('projetProjets.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Projet  Projets</span>
    </a>
</li>
