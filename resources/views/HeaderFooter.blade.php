<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Pagina</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"> 
</head>
<body>

@yield('content')

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>