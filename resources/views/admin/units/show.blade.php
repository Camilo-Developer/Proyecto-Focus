@extends('layouts.app2')
@section('title', 'DETALLE DE LA UNIDAD')
@section('content')
          
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>DETALLE DE LA UNIDAD</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.units.index')}}">LISTADO DE UNIDADES</a></li>
                    <li class="breadcrumb-item active">DETALLE DE LA UNIDAD</li>
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
                        <p><span class="text-bold">NOMBRE:</span> {{mb_strtoupper($unit->name)}}</p>
                        <p>
                            <span class="text-bold">ESTADO:</span> 
                            @if($unit->state_id == 1)
                                <span class="badge badge-success" style="display: inline-block; vertical-align: middle;">ACTIVO</span>
                            @else
                                <span class="badge badge-danger" style="display: inline-block; vertical-align: middle;">INACTIVO</span>
                            @endif
                        </p>

                        <p>
                            <span class="text-bold">AGLOMERACIÓN:</span> 
                            {{ mb_strtoupper($unit->agglomeration->name) }}
                            @if($unit->agglomeration->state_id == 1)
                                <span class="badge badge-success" style="display: inline-block; vertical-align: middle;">ACTIVO</span>
                            @else
                                <span class="badge badge-danger" style="display: inline-block; vertical-align: middle;">INACTIVO</span>
                            @endif
                        </p>
                        <p>
                            <span class="text-bold">CONJUNTO:</span> 
                            {{ mb_strtoupper($unit->agglomeration->setresidencial->name) }}
                            @if($unit->agglomeration->setresidencial->state_id == 1)
                                <span class="badge badge-success" style="display: inline-block; vertical-align: middle;">ACTIVO</span>
                            @else
                                <span class="badge badge-danger" style="display: inline-block; vertical-align: middle;">INACTIVO</span>
                            @endif
                        </p>
                        <p><span class="text-bold">ADMINISTRADOR DEL CONJUNTO:</span> 
                            <ol style="padding-left: 20px;"> 
                                @foreach($unit->agglomeration->setresidencial->users as $user)
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

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
