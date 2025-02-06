@extends('layouts.app2')
@section('title', 'DETALLE DE LA PORTERÍA')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>DETALLE DE LA PORTERÍA</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.goals.index')}}">LISTA DE PORTERIAS</a></li>
                        <li class="breadcrumb-item active">DETALLE DE LA PORTERÍA</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid" >
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p>
                                <span class="text-bold">NOMBRE:</span> {{ mb_strtoupper($goal->name) }}
                            </p>
                            <p>
                                <span class="text-bold">CONJUNTO:</span> {{ mb_strtoupper($goal->setresidencial->name) }}
                                @if($goal->setresidencial->state_id == 1)
                                    <span class="badge badge-success">ACTIVO</span>
                                @else
                                    <span class="badge badge-danger">INACTIVO</span>
                                @endif
                            </p>
                            <p class="card-text" style="display: inline-flex; align-items: center;">
                                <span class="text-bold" style="margin-right: 5px;">ESTADO:</span>  
                                @if($goal->state_id == 1)
                                    <div class="badge badge-success" style="display: inline-block;">ACTIVO</div>
                                @else
                                    <div class="badge badge-danger" style="display: inline-block;">INACTIVO</div>
                                @endif
                            </p>
                            <div class="form-group">
                                <label>PORTEROS:</label>
                                <p class="form-control-static">
                                    @if($goal->users->isEmpty())
                                        SIN PORTEROS
                                    @else
                                        <ol>
                                            @foreach($goal->users as $user)
                                                <li>
                                                    {{ mb_strtoupper($user->name) . ' '}}
                                                    {{ mb_strtoupper($user->lastname) }}
                                                    @if($user->state_id == 1)
                                                        <span class="badge badge-success" style="margin-left: 10px;">ACTIVO</span>
                                                    @else
                                                        <span class="badge badge-danger" style="margin-left: 10px;">INACTIVO</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ol>
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
