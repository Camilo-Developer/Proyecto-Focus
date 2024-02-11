<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Focus</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="icon" href="{{asset('logo.png')}}" type="image/x-icon">
    <link rel="icon" sizes="192x192" href="{{asset('logo.png')}}">
    <link rel="stylesheet" href="{{url('recursos/admin/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{url('recursos/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{url('recursos/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="shortcut icon" href="{{asset('imagen/favicon.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{url('recursos/admin/plugins/jqvmap/jqvmap.min.css')}}">
    <link rel="stylesheet" href="{{url('recursos/admin/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{url('recursos/admin/dist/css/style.css')}}">
    <link rel="stylesheet" href="{{url('recursos/admin/js/stylesda.css')}}">
    <link rel="stylesheet" href="{{url('recursos/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="{{url('recursos/admin/js/ppp.css')}}">
    <link rel="stylesheet" href="{{url('recursos/admin/plugins/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{url('recursos/admin/plugins/summernote/summernote-bs4.min.css')}}">
    <link rel="stylesheet" href="{{url('recursos/admin/plugins/select2/css/select2.min.css')}}" />
    <style>
        .select2-container--default .select2-selection--single{
            height: 37px!important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <form action="{{route('logout')}}" method="post" id="cerrar">
        @csrf
    </form>
    <div class="preloader loader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{url('recursos/admin/dist/img/logo-focus.jpeg')}}" alt="AdminLTELogo" height="120" width="280">
    </div>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('dashboard')}}" class="nav-link">Inicio</a>
            </li>
        </ul>
        @if(auth()->user()->can('admin.dashboard'))
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="background background--light">
                        <button id="cerrar-button" class="logoutButton logoutButton--dark" style="--figure-duration: 100; --transform-figure: none; --walking-duration: 100; --transform-arm1: none; --transform-wrist1: none; --transform-arm2: none; --transform-wrist2: none; --transform-leg1: none; --transform-calf1: none; --transform-leg2: none; --transform-calf2: none;">
                            <svg class="doorway" viewBox="0 0 100 100">
                                <path d="M93.4 86.3H58.6c-1.9 0-3.4-1.5-3.4-3.4V17.1c0-1.9 1.5-3.4 3.4-3.4h34.8c1.9 0 3.4 1.5 3.4 3.4v65.8c0 1.9-1.5 3.4-3.4 3.4z"></path>
                                <path class="bang" d="M40.5 43.7L26.6 31.4l-2.5 6.7zM41.9 50.4l-19.5-4-1.4 6.3zM40 57.4l-17.7 3.9 3.9 5.7z"></path>
                            </svg>
                            <svg class="figure" viewBox="0 0 100 100">
                                <circle cx="52.1" cy="32.4" r="6.4"></circle>
                                <path d="M50.7 62.8c-1.2 2.5-3.6 5-7.2 4-3.2-.9-4.9-3.5-4-7.8.7-3.4 3.1-13.8 4.1-15.8 1.7-3.4 1.6-4.6 7-3.7 4.3.7 4.6 2.5 4.3 5.4-.4 3.7-2.8 15.1-4.2 17.9z"></path>
                                <g class="arm1">
                                    <path d="M55.5 56.5l-6-9.5c-1-1.5-.6-3.5.9-4.4 1.5-1 3.7-1.1 4.6.4l6.1 10c1 1.5.3 3.5-1.1 4.4-1.5.9-3.5.5-4.5-.9z"></path>
                                    <path class="wrist1" d="M69.4 59.9L58.1 58c-1.7-.3-2.9-1.9-2.6-3.7.3-1.7 1.9-2.9 3.7-2.6l11.4 1.9c1.7.3 2.9 1.9 2.6 3.7-.4 1.7-2 2.9-3.8 2.6z"></path>
                                </g>
                                <g class="arm2">
                                    <path d="M34.2 43.6L45 40.3c1.7-.6 3.5.3 4 2 .6 1.7-.3 4-2 4.5l-10.8 2.8c-1.7.6-3.5-.3-4-2-.6-1.6.3-3.4 2-4z"></path>
                                    <path class="wrist2" d="M27.1 56.2L32 45.7c.7-1.6 2.6-2.3 4.2-1.6 1.6.7 2.3 2.6 1.6 4.2L33 58.8c-.7 1.6-2.6 2.3-4.2 1.6-1.7-.7-2.4-2.6-1.7-4.2z"></path>
                                </g>
                                <g class="leg1">
                                    <path d="M52.1 73.2s-7-5.7-7.9-6.5c-.9-.9-1.2-3.5-.1-4.9 1.1-1.4 3.8-1.9 5.2-.9l7.9 7c1.4 1.1 1.7 3.5.7 4.9-1.1 1.4-4.4 1.5-5.8.4z"></path>
                                    <path class="calf1" d="M52.6 84.4l-1-12.8c-.1-1.9 1.5-3.6 3.5-3.7 2-.1 3.7 1.4 3.8 3.4l1 12.8c.1 1.9-1.5 3.6-3.5 3.7-2 0-3.7-1.5-3.8-3.4z"></path>
                                </g>
                                <g class="leg2">
                                    <path d="M37.8 72.7s1.3-10.2 1.6-11.4 2.4-2.8 4.1-2.6c1.7.2 3.6 2.3 3.4 4l-1.8 11.1c-.2 1.7-1.7 3.3-3.4 3.1-1.8-.2-4.1-2.4-3.9-4.2z"></path>
                                    <path class="calf2" d="M29.5 82.3l9.6-10.9c1.3-1.4 3.6-1.5 5.1-.1 1.5 1.4.4 4.9-.9 6.3l-8.5 9.6c-1.3 1.4-3.6 1.5-5.1.1-1.4-1.3-1.5-3.5-.2-5z"></path>
                                </g>
                            </svg>
                            <svg class="door" viewBox="0 0 100 100">
                                <path d="M93.4 86.3H58.6c-1.9 0-3.4-1.5-3.4-3.4V17.1c0-1.9 1.5-3.4 3.4-3.4h34.8c1.9 0 3.4 1.5 3.4 3.4v65.8c0 1.9-1.5 3.4-3.4 3.4z"></path>
                                <circle cx="66" cy="50" r="3.7"></circle>
                            </svg>
                            <span class="button-text">Cerrar</span>
                        </button>
                    </div>
                </li>
            </ul>
        @endif
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{route('admin.dashboard')}}" class="brand-link">
            <!--
            <img src="{{--url('recursos/admin/dist/img/AdminLTELogo.png')--}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
             -->
            <span class="brand-text font-weight-light">Focus</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">

                <div class="image">
                    <img src="https://ui-avatars.com/api/?name={{ substr(auth()->user()->name, 0, 1) . substr(auth()->user()->lastname, 0, 1) }}&color=7F9CF5&background=EBF4FF" class="img-circle elevation-2" alt="User Image">
                </div>

                <div class="info">
                    @if(auth()->user()->can('admin.dashboard'))
                        <a href="{{route('admin.dashboard')}}" class="d-block">{{auth()->user()->name}} {{auth()->user()->lastname}}</a>
                    @endif
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{route('admin.dashboard')}}" class="nav-link @if($_SERVER['REQUEST_URI'] === "/admin/dashboard") active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Inicio
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/" class="nav-link">
                            <i class="fa fa-home nav-icon " aria-hidden="true"></i>
                            <p>
                                Inicio App
                            </p>
                        </a>
                    </li>
                    <li class="nav-header">Accesos</li>

                    @can('admin.states.index')
                        <li class="nav-item">
                            <a href="{{route('admin.states.index')}}" class="nav-link @if($_SERVER['REQUEST_URI'] === "/admin/states") active @endif">
                                <i class="nav-icon fab fa-usps"></i>
                                <p title="Estados">
                                    Estados
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('admin.roles.index')
                        <li class="nav-item">
                            <a href="{{route('admin.roles.index')}}" class="nav-link @if(Str::startsWith(request()->getRequestUri(), '/admin/roles')) active @endif">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p title="Roles">
                                    Roles
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('admin.setresidencials.index')
                        <li class="nav-item">
                            <a href="{{route('admin.setresidencials.index')}}" class="nav-link @if(Str::startsWith(request()->getRequestUri(), '/admin/setresidencials')) active @endif">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p title="Roles">
                                    Conjuntos
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('admin.agglomerations.index')
                        <li class="nav-item">
                            <a href="{{route('admin.agglomerations.index')}}" class="nav-link @if(Str::startsWith(request()->getRequestUri(), '/admin/agglomerations')) active @endif">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p title="Roles">
                                    Aglomeraciones
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('admin.units.index')
                        <li class="nav-item">
                            <a href="{{route('admin.units.index')}}" class="nav-link @if(Str::startsWith(request()->getRequestUri(), '/admin/units')) active @endif">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p title="Unidades">
                                    Unidades
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('admin.contractors.index')
                        <li class="nav-item">
                            <a href="{{route('admin.contractors.index')}}" class="nav-link @if(Str::startsWith(request()->getRequestUri(), '/admin/contractors')) active @endif">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p title="Contratistas">
                                    Contratistas
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('admin.contractoremployees.index')
                        <li class="nav-item">
                            <a href="{{route('admin.contractoremployees.index')}}" class="nav-link @if(Str::startsWith(request()->getRequestUri(), '/admin/contractoremployees')) active @endif">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p title="Empleados del Contratista">
                                    Empleados Contratista
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('admin.users.index')
                        <li class="nav-item">
                            <a href="{{route('admin.users.index')}}" class="nav-link @if(Str::startsWith(request()->getRequestUri(), '/admin/users')) active @endif">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p title="Usuarios">
                                    Usuarios
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('admin.elements.index')
                        <li class="nav-item">
                            <a href="{{route('admin.elements.index')}}" class="nav-link @if(Str::startsWith(request()->getRequestUri(), '/admin/elements')) active @endif">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p title="Elementos">
                                    Elementos
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('admin.goals.index')
                        <li class="nav-item">
                            <a href="{{route('admin.goals.index')}}" class="nav-link @if(Str::startsWith(request()->getRequestUri(), '/admin/goals')) active @endif">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p title="Porterias">
                                    Porterias
                                </p>
                            </a>
                        </li>
                    @endcan
                    
                    @can('admin.visitors.index')
                    <li class="nav-item">
                        <a href="{{route('admin.visitors.index')}}" class="nav-link @if(Str::startsWith(request()->getRequestUri(), '/admin/visitors')) active @endif">
                            <i class="nav-icon fab fa-product-hunt"></i>
                            <p title="Visitantes">
                                Visitantes
                            </p>
                        </a>
                    </li>
                    @endcan




                    <li class="nav-header ">Configuraciones</li>
                    <li class="nav-item" title="{{auth()->user()->email}}">
                        <a   class="nav-link disabled">
                            <i class="nav-icon far fa-envelope"></i>
                            <p>{{auth()->user()->email}}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a style="cursor: pointer;" onclick="document.getElementById('cerrar').submit()" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Cerrar Sesión</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <main>
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>
    <footer class="main-footer">
        <strong>Copyright &copy; 2023 <a href="#">Focus</a>.</strong>
        Derechos Reservados.
        <div class="float-right d-none d-sm-inline-block">
            <b>Versión</b> 1.1.0
        </div>
    </footer>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{url('recursos/admin/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{url('recursos/admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{url('recursos/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('recursos/admin/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{url('recursos/admin/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{url('recursos/admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<script src="{{url('recursos/admin/plugins/moment/moment.min.js')}}"></script>
<script src="{{url('recursos/admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{url('recursos/admin/js/script.js')}}"></script>
<script src="{{url('recursos/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{url('recursos/admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{url('recursos/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{url('recursos/admin/dist/js/adminlte.js')}}"></script>
<script src="{{url('recursos/admin/dist/js/demo.js')}}"></script>
<script src="{{url('recursos/admin/plugins/select2/js/select2.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

<script>
    if (document.getElementsByClassName('glide')) {
        const glider = new Glide('.gliderrr', {
            autoplay: 10000,
            type: 'carousel',
            perView: 4,
            breakpoints: {
                800: {
                    perView: 2
                }
            }
        });
        // The classname for the element that gets transformed
        const tiltableElement = '.glide__container';
        glider.mount();
    };

    if (document.getElementById('choice-button')) {
        var element = document.getElementById('choice-button');
        const example = new Choices(element, {
            searchEnabled: false
        });

    }
    if (document.getElementById('choice-remove-button')) {
        var element = document.getElementById('choice-remove-button');
        const example = new Choices(element, {
            searchEnabled: false
        });
    }

    if (document.getElementById('language-button')) {
        var element = document.getElementById('language-button');
        const example = new Choices(element, {
            searchEnabled: false
        });

    }
    if (document.getElementById('currency-button')) {
        var element = document.getElementById('currency-button');
        const example = new Choices(element, {
            searchEnabled: false
        });
    }
</script>
<script>
    // Función para retrasar el envío del formulario
    function retrasarEnvio() {
        setTimeout(function () {
            // Selecciona el formulario y lo envía
            document.getElementById('cerrar').submit();
        }, 1400); // 5000 milisegundos = 5 segundos
    }

    // Agrega un evento de clic al botón
    document.getElementById('cerrar-button').addEventListener('click', function (e) {
        e.preventDefault(); // Previene el envío inmediato del formulario al hacer clic
        retrasarEnvio(); // Llama a la función para retrasar el envío
    });
</script>
@include('components.flash_alerts')
@yield('js')
</body>
</html>
