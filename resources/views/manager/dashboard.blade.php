@extends('content')

@section('section')

<h1>MANAGER</h1>

First Name: {{ $user->firstName }} <br>
Role: {{ $user->role }}

@endsection