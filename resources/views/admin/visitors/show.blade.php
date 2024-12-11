@extends('layouts.app2')
@section('title', 'DETALLE DEL VISITANTE')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>DETALLE DEL VISITANTE</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.visitors.index')}}">LISTADO DE VISITANTES</a></li>
                        
                        <li class="breadcrumb-item active">DETALLE DEL VISITANTE</li>
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
                                <img src="{{asset('storage/'.$visitor->imagen)}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text"><span class="text-bold">NOMBRE:</span> {{strtoupper($visitor->name)}}</p>
                                    <p class="card-text"><span class="text-bold">TELÉFONO:</span> {{strtoupper($visitor->phone)}}</p>
                                    <p class="card-text"><span class="text-bold">DIRECCIÓN:</span> {{strtoupper($visitor->address)}}</p>
                                    <p class="card-text"><span class="text-bold">NÚMERO DOCUMENTO:</span> {{strtoupper($visitor->document_number)}}</p>
                                    <p class="card-text"><span class="text-bold">CONFIRMACIÓN:</span> @if($visitor->confirmation == 1) SI @else NO @endif</p>
                                    <p class="card-text"><span class="text-bold">ESTADO:</span> {{strtoupper($visitor->state->name)}}</p>
                                    <p class="card-text"><span class="text-bold">TIPO USUARIO:</span> {{strtoupper($visitor->typeuser->name)}}</p>
                                    <p class="card-text"><span class="text-bold">EMPRESA:</span> {{strtoupper($visitor->company->name)}}</p>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
@endsection
