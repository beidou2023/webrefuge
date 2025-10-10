@extends('HeaderFooter')
@section('content')

<nav class="navbar navbar-expand-lg custom-navbar mb-0">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="{{ route('index') }}">MY REFUGE</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('myths') ? 'active' : '' }}" href="{{ route('myths') }}">Mitos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cares') ? 'active' : '' }}" href="{{ route('cares') }}">Cuidados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('adoption') ? 'active' : '' }}" href="{{ route('adoption') }}">Adóptame</a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link text-white" style="border: none; background: none; padding: 0;">
                                <i class="bi bi-box-arrow-right me-2"></i>Salir
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Registrarse</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@yield('section')


<footer class="footer bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row">

            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">My Refuge</h5>
                <p>Un espacio dedicado a la adopción y cuidado de ratas rescatadas. Juntos podemos hacer la diferencia.</p>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Navegación</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('index') }}" class="footer-link">Inicio</a></li>
                    <li><a href="{{ route('myths') }}" class="footer-link">Mitos</a></li>
                    <li><a href="{{ route('cares') }}" class="footer-link">Cuidados</a></li>
                    <li><a href="{{ route('adoption') }}" class="footer-link">Adóptame</a></li>
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="footer-link">Dashboard</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Conéctate</h5>
                <p>Síguenos en redes sociales para conocer más historias.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white fs-5"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>

        </div>

        <hr class="border-light mt-4">
        <div class="text-center">
            <small>&copy; {{ date('Y') }} My Refuge. Todos los derechos reservados.</small>
        </div>
    </div>
</footer>



@endsection