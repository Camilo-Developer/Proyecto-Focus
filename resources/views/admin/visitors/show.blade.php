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
                        <div class="col-12 col-md-4">
                            <div class="card card-warning card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="{{asset('storage/' . $visitor->imagen)}}" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center">{{ mb_strtoupper($visitor->name) }}</h3>

                                    <p class="text-muted text-center">{{ mb_strtoupper($visitor->typeuser->name) }}</p>

                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-map"></i></span> <b>DIRECCIÓN:</b> {{ mb_strtoupper($visitor->address) }}
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> <b>TELÉFONO:</b> {{ mb_strtoupper($visitor->phone) }}
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-address-card"></i></span> <b>NÚMERO DE DOCUMENTO:</b> {{ mb_strtoupper($visitor->document_number) }}
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-check-square"></i></span> <b>CONFIRMACIÓN:</b> @if($visitor->confirmation == 1) SI @elseif($visitor->confirmation == 2) NO @endif
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-ban"></i></span> <b>ESTADO:</b> {{ mb_strtoupper($visitor->state->name) }}
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <b>CONJUNTO:</b> {{ mb_strtoupper($visitor->setresidencial->name) }}
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-map-marker-alt"></i></span> <b>UNIDADES:
                                                
                                            </b> 
                                            @if($visitor->units->isNotEmpty())    
                                                @foreach($visitor->units as $unit)
                                                    {{mb_strtoupper($unit->name)}}
                                                @endforeach
                                            @else
                                                SIN UNIDADES
                                            @endif
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-truck"></i></span>
                                            <b>EMPRESA:</b> {{ mb_strtoupper($visitor->company?->name ?? 'SIN EMPRESA') }}
                                        </li>

                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-car"></i></span> <b>VEHICULOS:</b>
                                            @if($visitor->vehicles->isNotEmpty())        
                                                @foreach($visitor->vehicles as $index => $vehicle)
                                                    {{ mb_strtoupper($vehicle->placa) }}@if(!$loop->last), @endif
                                                @endforeach
                                            @else
                                                SIN VEHICULOS
                                            @endif
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                       
                        <div class="col-12 col-md-8">
                            <div class="card card-dark card-outline">
                                <div class="card-body box-profile">
                                        <h2 class="lead"><b>DATOS DEL INGRESO DEL VISITANTE</b></h2>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th scope="col">#</th>
                                                                <th scope="col">CONJUNTO</th>
                                                                <th scope="col">AGLOMERACIÓN</th>
                                                                <th scope="col">UNIDAD</th>
                                                                <th scope="col">TIPO INGRESO</th>
                                                                <th scope="col">INGRESO</th>
                                                                <th scope="col">SALIDA</th>
                                                                <th scope="col">ACCIONES</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($employeeincomes as $employeeincome)
                                                                <tr class="text-center">
                                                                    <th scope="row" style="width: 50px;">{{$employeeincome->id}}</th>
                                                                    <td>{{ mb_strtoupper($employeeincome->setresidencial->name ?? 'SIN CONJUNTO') }}</td>
                                                                    <td>{{ mb_strtoupper($employeeincome->agglomeration->name ?? 'SIN AGLOMERACIÓN') }}</td>
                                                                    <td>{{ mb_strtoupper($employeeincome->unit->name ?? 'SIN UNIDAD') }}</td>
                                                                    <td>
                                                                        @if($employeeincome->type_income == 1)
                                                                            PEATONAL
                                                                        @else
                                                                            VEHICULAR
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                       {{\Carbon\Carbon::parse($employeeincome->admission_date)->translatedFormat('d M Y h:i A')}}
                                                                    </td>
                                                                    <td>
                                                                        @if($employeeincome->exitentries->first() != null)
                                                                       {{ \Carbon\Carbon::parse($employeeincome->exitentries->first()->departure_date)->translatedFormat('d M Y h:i A') }}
                                                                       @else
                                                                       SIN SALIDA
                                                                       @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{route('admin.employeeincomes.show',$employeeincome)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                   
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="card-footer">
                                     <div class="d-flex justify-content-center mt-3">
                                                        {{ $employeeincomes->links() }}
                                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
