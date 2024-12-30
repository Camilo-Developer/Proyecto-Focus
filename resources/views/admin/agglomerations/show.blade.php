@extends('layouts.app2')
@section('title', 'DETALLE DE LA AGLOMERACIÓN')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>DETALLE DE LA AGLOMERACIÓN</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.agglomerations.index')}}">LISTA DE AGLOMERACIONES</a></li>
                        <li class="breadcrumb-item active">DETALLE DE LA AGLOMERACIÓN</li>
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
                        <p><span class="text-bold">NOMBRE:</span> {{mb_strtoupper($agglomeration->name)}}</p>
                        <p><span class="text-bold">TIPO:</span> {{mb_strtoupper($agglomeration->type_agglomeration)}}</p>
                        <p>
                            <span class="text-bold">CONJUNTO:</span> {{ mb_strtoupper($agglomeration->setresidencial->name) }}
                            @if($agglomeration->setresidencial->state_id == 1)
                                <span class="badge badge-success">ACTIVO</span>
                            @else
                                <span class="badge badge-danger">INACTIVO</span>
                            @endif
                        </p>
                        <p class="card-text" style="display: inline-flex; align-items: center;">
                            <span class="text-bold" style="margin-right: 5px;">ESTADO:</span>  
                            @if($agglomeration->state_id == 1)
                                <div class="badge badge-success" style="display: inline-block;">ACTIVO</div>
                            @else
                                <div class="badge badge-danger" style="display: inline-block;">INACTIVO</div>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
