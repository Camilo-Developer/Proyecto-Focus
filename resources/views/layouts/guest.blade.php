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
        body {
            margin: 0;
            padding: 0;
            background-image: url('{{ asset("Imagenes2/Focus_bck.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
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
<script src="{{asset('user/bootstrap/bootstrap.bundle.min.js')}}"></script>
</body>
</html>
