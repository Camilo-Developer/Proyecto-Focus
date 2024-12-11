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
                        <div class="col-12">
                            <div class="card" style="width: 20rem;">
                                <img src="{{asset('storage/'.$setresidencial->imagen)}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text"><span class="text-bold">NOMBRE:</span> {{strtoupper($setresidencial->name)}}</p>
                                    <p class="card-text"><span class="text-bold">DIRECCIÓN:</span> {{strtoupper($setresidencial->address)}}</p>
                                    <p class="card-text"><span class="text-bold">NIT:</span> {{strtoupper($setresidencial->nit)}}</p>
                                    <p class="card-text"><span class="text-bold">ESTADO:</span> {{strtoupper($setresidencial->state->name)}}</p>
                                    <p class="card-text"><span class="text-bold">RESPONSABLE:</span> {{strtoupper($setresidencial->user->name)}} {{strtoupper($setresidencial->user->lastname)}}</p>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
@endsection
