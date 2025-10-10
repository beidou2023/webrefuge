@extends('content')

@section('section')
 <h2>Iniciar Sesión</h2>
    @if ($errors->any())
        <div style="color:red;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email') }}"><br><br>

        <label>Contraseña:</label>
        <input type="password" name="password"><br><br>

        <button type="submit">Ingresar</button>
    </form>
@endsection