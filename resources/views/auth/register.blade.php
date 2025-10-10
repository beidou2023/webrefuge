@extends('content')

@section('section')
<div class="container mt-5">
    <h2>Registro de Usuario</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label for="firstName" class="form-label">Nombre</label>
            <input type="text" name="firstName" class="form-control" value="{{ old('firstName') }}">
            @error('firstName')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="lastName" class="form-label">Apellido</label>
            <input type="text" name="lastName" class="form-control" value="{{ old('lastName') }}">
            @error('lastName')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control">
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" >
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text"
           name="phone"
           class="form-control"
           
           value="{{ old('phone') }}"
           >
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <textarea name="address" class="form-control" >{{ old('address') }}</textarea>
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Registrarse</button>
        <a href="{{ route('login') }}" class="btn btn-link">¿Ya tienes cuenta? Inicia sesión</a>
    </form>
</div>
@endsection