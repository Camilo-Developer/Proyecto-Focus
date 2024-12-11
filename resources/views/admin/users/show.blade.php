@extends('layouts.app2')
@section('title', 'DETALLE DEL USUARIO')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>DETALLE DEL USUARIO</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">LISTA DEL USUARIO</a></li>
                        <li class="breadcrumb-item active">DETALLE DEL USUARIO</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
    <div class="container-fluid">
        <div class="card card-default color-palette-box">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <div class="form-group">
                            <label>NOMBRES:</label>
                            <p class="form-control-static">{{ strtoupper($user->name) }}</p>
                        </div>

                        <div class="form-group">
                            <label>APELLIDOS:</label>
                            <p class="form-control-static">{{ strtoupper($user->lastname) }}</p>
                        </div>

                        <div class="form-group">
                            <label>TIPO DE DOCUMENTO:</label>
                            <p class="form-control-static">
                                @switch($user->type_document)
                                    @case('CC') CÉDULA DE CIUDADANÍA (CC) @break
                                    @case('CE') CÉDULA DE EXTRANJERÍA (CE) @break
                                    @case('TI') TARJETA DE IDENTIDAD (TI) @break
                                    @case('RC') REGISTRO CIVIL (RC) @break
                                    @case('PA') PASAPORTE (PA) @break
                                    @case('PEP') PERMISO ESPECIAL DE PERMANENCIA (PEP) @break
                                    @case('NIT') NÚMERO DE IDENTIFICACIÓN TRIBUTARIA (NIT) @break
                                    @case('DNI') DOCUMENTO NACIONAL DE IDENTIDAD (DNI) @break
                                    @default SIN DEFINIR
                                @endswitch
                            </p>
                        </div>

                        <div class="form-group">
                            <label>NÚMERO DE DOCUMENTO:</label>
                            <p class="form-control-static">{{ $user->document_number }}</p>
                        </div>

                        <div class="form-group">
                            <label>CORREO ELECTRÓNICO:</label>
                            <p class="form-control-static">{{ strtoupper($user->email) }}</p>
                        </div>

                        <div class="form-group">
                            <label>ESTADO:</label>
                            <p class="form-control-static">{{ strtoupper($user->state->name) }}</p>
                        </div>

                        <div class="form-group">
                            <label>ROL:</label>
                            <p class="form-control-static">
                                {{ strtoupper($user->roles->pluck('name')->join(', ')) }}
                            </p>
                        </div>
                        <div class="form-group">
                            <label>PORTERÍAS:</label>
                            <p class="form-control-static">
                                @if($user->goals->isEmpty())
                                    SIN PORTERÍAS
                                @else
                                    {{ strtoupper($user->goals->pluck('name')->join(', ')) }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
