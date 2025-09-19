@extends('layouts.app2')
@section('title', 'DETALLE DEL CONJUNTO')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>DETALLE DEL CONJUNTO</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.setresidencials.index')}}">LISTADO DE CONJUNTOS</a></li>
                        
                        <li class="breadcrumb-item active">DETALLE DEL CONJUNTO</li>
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
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <img src="{{asset('laravel_8/public/storage/'.$setresidencial->imagen)}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text"><span class="text-bold">NOMBRE:</span> {{mb_strtoupper($setresidencial->name)}}</p>
                                    <p class="card-text"><span class="text-bold">DIRECCIÓN:</span> {{mb_strtoupper($setresidencial->address)}}</p>
                                    <p class="card-text"><span class="text-bold">NIT:</span> {{mb_strtoupper($setresidencial->nit)}}</p>
                                    <p class="card-text" style="display: inline-flex; align-items: center;">
                                        <span class="text-bold" style="margin-right: 5px;">ESTADO:</span>  
                                        @if($setresidencial->state_id == 1)
                                            <div class="badge badge-success" style="display: inline-block;">ACTIVO</div>
                                        @else
                                            <div class="badge badge-danger" style="display: inline-block;">INACTIVO</div>
                                        @endif
                                    </p>
                                    <p class="card-text"><span class="text-bold">ADMINISTRADORES:</span></p>
                                    <div class="row">
                                        <div class="col-12">
                                            <ol style="padding-left: 20px;"> <!-- Lista ordenada -->
                                                @foreach($setresidencial->users as $user)
                                                    @if($user->hasRole(1) || $user->hasRole(2))
                                                        <li >
                                                            <span>
                                                                {{ mb_strtoupper($user->name) }} {{ mb_strtoupper($user->lastname) }}
                                                            </span>
                                                            @if($user->state_id == 1)
                                                                <div class="badge badge-success" style="margin-left: 10px;">ACTIVO</div>
                                                            @else
                                                                <div class="badge badge-danger" style="margin-left: 10px;">INACTIVO</div>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                    <p class="card-text mt-3"><span class="text-bold">PORTEROS:</span></p>
                                    <div class="row">
                                        <div class="col-12">
                                            <ol style="padding-left: 20px;">
                                            @if($setresidencial->users->isEmpty())
                                            SIN PORTEROS
                                            @else
                                                @foreach($setresidencial->users as $user)
                                                    @if($user->hasRole(3)) 
                                                        <li >
                                                            <span>
                                                                {{ mb_strtoupper($user->name) }} {{ mb_strtoupper($user->lastname) . ' '}}
                                                            </span>
                                                            @if($user->state_id == 1)
                                                                <div class="badge badge-success">ACTIVO</div>
                                                            @else
                                                                <div class="badge badge-danger">INACTIVO</div>
                                                            @endif
                                                            @if (!$loop->last)
                                                                <span>, </span> 
                                                            @endif
                                                        </li>
                                                        @else
                                                SIN PORTEROS

                                                    @endif
                                                @endforeach
                                                @endif

                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
