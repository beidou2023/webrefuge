@extends('content')

@section('section')
<div class="container mt-5">
    <h2>Registro de Usuario</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="firstName" class="form-label">Nombre</label>
            <input type="text" name="firstName" class="form-control" required maxlength="45">
        </div>

        <div class="mb-3">
            <label for="lastName" class="form-label">Apellido</label>
            <input type="text" name="lastName" class="form-control" required maxlength="45">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" required maxlength="80">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required minlength="6">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" name="phone" class="form-control" required maxlength="20">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <textarea name="address" class="form-control" required maxlength="500"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Registrarse</button>
    </form>
</div>
@endsection
