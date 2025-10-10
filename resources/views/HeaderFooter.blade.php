<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Pagina</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"> 
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-wIcEFz9WcEr+K1hYOyqEhdsmf9S6uvzQuR4Uc2aWoNROkhH1uMqM1sF8wLTpJztq0nP1CyUI4mUZlAjdKo5B9w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

@yield('content')

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>