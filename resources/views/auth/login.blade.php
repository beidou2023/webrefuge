@extends('content')

@section('section')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="material-card p-4">
                <h2 class="section-title mb-4 text-center">Iniciar Sesión</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </div>

                    <div class="mt-3 text-center">
                        <a href="{{ route('register') }}" class="btn btn-link">¿No tienes cuenta? Regístrate</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
