@extends('layouts.app2')
@section('title', 'DETALLE DEL VEHICULO')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>DETALLE DEL VEHICULO</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.vehicles.index')}}">LISTADO DE VEHICULOS</a></li>
                        <li class="breadcrumb-item active">DETALLE DEL VEHICULO</li>
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
                                <span class="text-bold">PLACA:</span> {{ mb_strtoupper($vehicle->placa) }}
                            </p>
                            <p class="card-text" style="display: inline-flex; align-items: center;">
                                <span class="text-bold" style="margin-right: 5px;">ESTADO:</span>  
                                @if($vehicle->state_id == 1)
                                    <div class="badge badge-success" style="display: inline-block;">ACTIVO</div>
                                @else
                                    <div class="badge badge-danger" style="display: inline-block;">INACTIVO</div>
                                @endif
                            </p>
                           
                            <div class="form-group">
                                <label>UNIDADES:</label>
                                <p class="form-control-static">
                                    @if($vehicle->units->isEmpty())
                                        SIN UNIDADES
                                    @else
                                        <ol>
                                            @foreach($vehicle->units as $unit)
                                                <li>
                                                    {{ mb_strtoupper($unit->name) }}
                                                    @if($unit->state_id == 1)
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

                            <div class="form-group">
                                <label>VISITANTES:</label>
                                <p class="form-control-static">
                                    @if($vehicle->visitors->isEmpty())
                                        SIN VISITANTES
                                    @else
                                        <ol>
                                            @foreach($vehicle->visitors as $visitor)
                                                <li>
                                                    {{ mb_strtoupper($visitor->name) }}
                                                    @if($visitor->state_id == 1)
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
