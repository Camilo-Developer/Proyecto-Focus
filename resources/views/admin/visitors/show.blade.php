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
                                        <img 
                                            class="profile-user-img img-fluid img-circle"
                                            src="{{ asset('laravel_8/public/storage/' . $visitor->imagen) }}" 
                                            alt="VISITANTE"
                                            style="cursor: zoom-in;"
                                            onclick="expandVehicleImage('{{ asset('laravel_8/public/storage/' . $visitor->imagen) }}')"
                                        />
                                    </div>

                                    <h3 class="profile-username text-center">{{ mb_strtoupper($visitor->name) }}</h3>

                                    <p class="text-muted text-center">{{ mb_strtoupper($visitor->typeuser->name) }}</p>

                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-car"></i></span> <b>PLACA:</b> {{ mb_strtoupper($visitor->address ?? 'SIN VEHICULO') }}
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

                                        
                                    </ul>

                                </div>
                            </div>
                        </div>
                       

                        <div class="col-12 col-md-8">
                            <div class="card card-dark card-outline">
                                <div class="card-body box-profile">
                                        <h2 class="lead"><b>VEHICULOS RELACIONADOS</b></h2>
                                        <div class="row">
                                            @if($visitor->vehicles->isNotEmpty())        
                                                @foreach($visitor->vehicles as $index => $vehicle)
                                                   <div class="col-12 col-md-4">
                                                        <div class="card" >
                                                            <img 
                                                                    src="{{ asset('laravel_8/public/storage/' . $vehicle->imagen) }}" 
                                                                    class="card-img-top" 
                                                                    alt="VEHICULO"
                                                                    style="cursor: zoom-in;"
                                                                    onclick="expandVisitorImage('{{ asset('laravel_8/public/storage/' . $vehicle->imagen) }}')"
                                                                />

                                                            <div class="card-body">
                                                                <p class="card-text text-center">
                                                                    <b>{{ mb_strtoupper($vehicle->placa) }}</b>
                                                                </p>
                                                                <p class="card-text"><b>ESTADO:</b> {{ mb_strtoupper($vehicle->state->name) }}</p>
                                                            </div>
                                                        </div>
                                                   </div>
                                                @endforeach
                                            @else
                                            <div class="col-12 d-flex justify-content-center">
                                                SIN VEHICULOS
                                            </div>
                                            @endif
                                        </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
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
                                                            @forelse($employeeincomes as $employeeincome)
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
                                                             @empty
                                                                <tr>
                                                                    <td colspan="8" class="text-center text-muted">
                                                                        SIN REGISTROS
                                                                    </td>
                                                                </tr>
                                                            @endforelse
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
              <!-- Modal para imagen del VEHÍCULO -->
<div class="modal fade" id="modal-image-vehicle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content  border-0">
            <div class="modal-body text-center">
                <img id="expanded-image-vehicle" src="" class="img-fluid rounded" style="max-height: 80vh;">
                <div class="mt-3">
                    <button type="button" class="btn btn-light btn-sm" onclick="$('#modal-image-vehicle').modal('hide')">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para imagen del VISITANTE -->
<div class="modal fade" id="modal-image-visitor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content  border-0">
            <div class="modal-body text-center">
                <img id="expanded-image-visitor" src="" class="img-fluid rounded" style="max-height: 80vh;">
                <div class="mt-3">
                    <button type="button" class="btn btn-light btn-sm" onclick="$('#modal-image-visitor').modal('hide')">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
@endsection
@push('scripts')
<script>
    // Mostrar imagen del vehículo
    function expandVehicleImage(src) {
        document.getElementById('expanded-image-vehicle').src = src;
        $('#modal-image-vehicle').modal('show');
    }

    // Mostrar imagen del visitante
    function expandVisitorImage(src) {
        document.getElementById('expanded-image-visitor').src = src;
        $('#modal-image-visitor').modal('show');
    }

    // Corrección de scroll al cerrar los modales si hay otros abiertos (por si usas más modales en otras vistas)
    $('#modal-image-vehicle, #modal-image-visitor').on('hidden.bs.modal', function () {
        if ($('.modal.show').length) {
            $('body').addClass('modal-open');
        }
    });
</script>
@endpush


