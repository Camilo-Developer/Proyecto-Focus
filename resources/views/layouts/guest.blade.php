<!DOCTYPE html>
<html lang="es">
<head>
    <title>@yield('title') | FOCUS</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link href="{{asset('user/bootstrap/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    min-height: 100vh;
}

body {
    background-image: url('{{ asset("Imagenes2/Focus_bck.png") }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed; /* hace que el fondo siempre cubra */
}

        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        @yield('content')
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{asset('user/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('components.flash_alerts')

</body>
</html>
