@extends('content')

@section('section')
<h1>MANAGER</h1>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>
@endsection