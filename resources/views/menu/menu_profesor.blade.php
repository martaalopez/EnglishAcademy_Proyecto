<aside class="sidebar" id="mainSidebar">

    <div class="sidebar__brand">
        <span class="sidebar__brand-text">English Academy</span>
    </div>

    <nav class="sidebar__nav">

        <span class="sidebar__section-label">Principal</span>
        <a href="{{ route('dashboard.profesor') }}" class="sidebar__link sidebar__link--active">
            <i class="fas fa-home"></i>
            <span class="sidebar__link-text">Inicio</span>
        </a>

        <span class="sidebar__section-label">Mi Espacio</span>

        <a href="{{ route('resultados.showResultados') }}" class="sidebar__link">
            <i class="fas fa-chart-bar"></i>
            <span class="sidebar__link-text">Resultados de alumnos</span>
        </a>

        <a href="{{ route('usuarios.show', ['usuario' => Auth::user()->id]) }}" class="sidebar__link">
            <i class="fas fa-user-circle"></i>
            <span class="sidebar__link-text">Mi perfil</span>
        </a>

        <a href="{{ route('clases.mensajes.index', Auth::user()->clase_id) }}" class="sidebar__link">
            <i class="fas fa-comments"></i>
            <span class="sidebar__link-text">Chat de la clase</span>
        </a>

    </nav>

    <div class="sidebar__footer">
        <div class="sidebar__user">
            <span>{{ substr(Auth::user()->name, 0, 2) }}</span>
            <span>{{ Auth::user()->name }}</span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>

</aside>