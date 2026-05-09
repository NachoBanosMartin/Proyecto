<header class="site-header">
    <div class="container header-contenido">
        <a href="{{ route('inicio') }}" class="header-logo-link">
            <img src="{{ asset('img/logo.png') }}" alt="Pantalla Extremeña" class="logo">
        </a>

        @if(session('usuario'))
            <div class="header-botones">
                <span class="saludo-usuario">
                    Hola, <strong>{{ session('usuario.nombre') }}</strong>
                </span>

                @if(session('usuario.tipoUsuario') === 'admin')
                    <a href="{{ route('admin.index') }}" class="btn-header">Panel Admin</a>
                @endif

                <a href="{{ route('perfil') }}" class="btn-header">Mi perfil</a>
                <a href="{{ route('favoritos.index') }}" class="btn-header">Mis favoritos</a>
                <form method="POST" action="{{ route('logout') }}" class="form-logout">
                    @csrf
                    <button type="submit" class="btn-header btn-logout">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        @else
            <div class="header-botones">
                <a href="{{ route('login') }}" class="btn-header">Iniciar sesión</a>
                <a href="{{ route('registro') }}" class="btn-header">Registrarse</a>
            </div>
        @endif
    </div>
</header>