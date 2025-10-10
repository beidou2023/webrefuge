@extends('content')

@section('section')

<h1>USER</h1>

First Name: {{ $user->firstName }} <br>
Role: {{ $user->role }}

@endsection