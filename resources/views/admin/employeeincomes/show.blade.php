@extends('layouts.app2')
@section('title', 'DETALLE DEL INGRESO')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>DETALLE DEL INGRESO</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.employeeincomes.index')}}">LISTA DE INGRESOS</a></li>
                        <li class="breadcrumb-item active">DETALLE DEL INGRESO</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid" >
            <div class="row">
                <div class="col-12">
                    <h3>DATOS DEL INGRESO</h3>
                </div>
                <div class="col-12 col-md-3">
                    @if($employeeincome->type_income == 1)
                        <div class="card card-warning card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="{{asset('storage/'.$employeeincome->visitor->imagen)}}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{mb_strtoupper($employeeincome->visitor->name)}}</h3>

                                <p class="text-muted text-center">{{mb_strtoupper($employeeincome->visitor->typeuser->name)}}</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>NÚMERO DOCUMENTO:</b><br> <a >{{mb_strtoupper($employeeincome->visitor->document_number)}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>TELÉFONO:</b><br> <a >{{mb_strtoupper($employeeincome->visitor->phone)}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>DIRECCIÓN:</b><br> <a >{{mb_strtoupper($employeeincome->visitor->address)}}</a>
                                    </li>
                                </ul>

                                <a href="{{route('admin.visitors.show',$employeeincome->visitor_id)}}" class="btn btn-dark btn-block"><b>VER MÁS</b></a>
                            </div>
                        </div>
                    @else
                        <div class="card card-warning card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="{{asset('storage/'.$employeeincome->vehicle->imagen)}}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{mb_strtoupper($employeeincome->vehicle->placa)}}</h3>

                                
                                <a href="{{route('admin.vehicles.show',$employeeincome->vehicle_id)}}" class="btn btn-dark btn-block"><b>VER MÁS</b></a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-12 col-md-9">
                    <div class="card card-dark card-outline">
                        <div class="card-body box-profile">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <p><b>TIPO INGRESO:</b></p>
                                    <span>
                                        @if($employeeincome->type_income == 1)
                                            PEATONAL
                                        @else
                                            VEHICULAR
                                        @endif
                                    </span>
                                </div>
                                <div class="col-12 col-md-3">
                                    <p><b>CONJUNTO:</b></p>
                                    <span>
                                       {{mb_strtoupper($employeeincome->setresidencial->name ?? 'SIN CONJUNTO')}}
                                    </span>
                                </div>
                                <div class="col-12 col-md-3">
                                    <p><b>AGLOMERACIÓN:</b></p>
                                    <span>
                                       {{mb_strtoupper($employeeincome->agglomeration->name ?? 'SIN AGLOMEREACIÓN')}}
                                    </span>
                                </div>
                                <div class="col-12 col-md-3">
                                    <p><b>UNIDAD:</b></p>
                                    <span>
                                       {{mb_strtoupper($employeeincome->unit->name ?? 'SIN UNIDAD')}}
                                    </span>
                                </div>
                                <div class="col-12 col-md-3">
                                    <p><b>FECHA INGRESO:</b></p>
                                    <span>
                                       {{\Carbon\Carbon::parse($employeeincome->admission_date)->translatedFormat('d M Y h:i A')}}
                                    </span>
                                </div>
                                <div class="col-12 col-md-3">
                                    <p><b>PORTERO INGRESO:</b></p>
                                    <span>
                                       {{mb_strtoupper($employeeincome->user->name ?? 'SIN NOMBRE') . mb_strtoupper($employeeincome->user->lastname ?? '')}}
                                    </span>
                                </div>
                                <div class="col-12 col-md-3">
                                    <p><b>PORTERÍA INGRESO:</b></p>
                                    <span>
                                       {{mb_strtoupper($employeeincome->goal->name ?? 'SIN PORTERÍA')}}
                                    </span>
                                </div>
                                @if($employeeincome->type_income == 1)
                                    <div class="col-12 col-md-3">
                                        <p><b>VEHICULO:</b></p>
                                        <span>
                                        {{mb_strtoupper($employeeincome->vehicle->name ?? 'SIN VEHICUO')}}
                                        </span>
                                    </div>
                                @else
                                    <div class="col-12 col-md-3">
                                        <p><b>VISITANTE:</b></p>
                                        <span>
                                        {{mb_strtoupper($employeeincome->visitor->name ?? 'SIN VISITANTE')}}
                                        </span>
                                    </div>
                                @endif
                                <div class="col-12 mt-2" style="background: #d4d4d4!important;border-radius: 5px;">
                                    <p class="mt-1"><b>NOTA:</b></p>
                                    {!! $employeeincome->nota ?? 'SIN NOTA' !!}
                                </div>
                                <div class="col-12">
                                    <p class="mt-1"><b>ELEMENTOS:</b></p>
                                    <div class="row">
                                        @forelse($employeeincome->elements as $element)
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12 col-md-3 d-flex align-items-center">
                                                                <img src="{{ asset('storage/' . $element->pivot->imagen) }}" alt="Imagen elemento"
                                                                    style="width: 100%; height: auto; object-fit: contain; display: block;">
                                                            </div>
                                                            <div class="col-12 col-md-9">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <p><b>ELEMENTO:</b></p>
                                                                        <span>{{ mb_strtoupper($element->name ?? 'SIN ELEMENTO') }}</span>
                                                                    </div>
                                                                    <div class="col-12 mt-2" style="background: #d4d4d4!important; border-radius: 5px;">
                                                                        <p class="mt-1"><b>NOTA:</b></p>
                                                                        {!! $element->pivot->nota ?? 'SIN NOTA' !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <span class="text-uppercase">SIN ELEMENTO</span>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                        </div>
                    </div>
                        
                    </div>
                </div>
                <div class="col-12">
                    <h3>DATOS DE LA SALIDA</h3>
                </div>
                <div class="col-12">
                    <div class="card card-warning card-outline">
                            <div class="card-body box-profile">
                                <div class="row">
                                    @if($exitEntry)
                                        <div class="col-12 col-md-4">
                                            <p><b>FECHA SALIDA:</b></p>
                                            <span>
                                            {{\Carbon\Carbon::parse($exitEntry->departure_date)->translatedFormat('d M Y h:i A')}}
                                            </span>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <p><b>PORTERO SALIDA:</b></p>
                                            <span>
                                            {{mb_strtoupper($exitEntry->user->name ?? 'SIN PORTERO') . ' ' . mb_strtoupper($exitEntry->user->lastname ?? '')}}
                                            </span>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <p><b>PORTERÍA SALIDA:</b></p>
                                            <span>
                                            {{mb_strtoupper($exitEntry->goal->name ?? 'SIN PORTERÍA')}}
                                            </span>
                                        </div>
                                        <div class="col-12 mt-2" style="background: #d4d4d4!important;border-radius: 5px;">
                                            <p class="mt-1"><b>NOTA:</b></p>
                                            {!! $exitEntry->nota ?? 'SIN NOTA' !!}
                                        </div>

                                        <div class="col-12">
                                            <p class="mt-1"><b>ELEMENTOS:</b></p>
                                            <div class="row">
                                                @forelse($exitEntry->elements as $elementEntry)
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-12 col-md-3 d-flex align-items-center">
                                                                        <img src="{{ asset('storage/' . $elementEntry->pivot->imagen) }}" alt="Imagen elemento"
                                                                        style="width: 100%; height: auto; object-fit: contain; display: block;">
                                                                    </div>

                                                                    <div class="col-12 col-md-9">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <p><b>ELEMENTO:</b></p>
                                                                                <span>{{ mb_strtoupper($elementEntry->name ?? 'SIN ELEMENTO') }}</span>
                                                                            </div>
                                                                            <div class="col-12 mt-2" style="background: #d4d4d4!important; border-radius: 5px;">
                                                                                <p class="mt-1"><b>NOTA:</b></p>
                                                                                {!! $elementEntry->pivot->nota ?? 'SIN NOTA' !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="col-12">
                                                        <span class="text-uppercase">SIN ELEMENTO</span>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    @else
                                    <div class="col-12">
                                        SIN SALIDA
                                    </div>
                                    @endif
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
@endsection
