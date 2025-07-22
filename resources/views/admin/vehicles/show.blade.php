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
                        <div class="col-12 col-md-4">
                            <div class="card card-warning card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                           <img 
                                                class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('storage/' . $vehicle->imagen) }}" 
                                                alt="VEHICULO"
                                                style="cursor: zoom-in;"
                                                onclick="expandVehicleImage('{{ asset('storage/' . $vehicle->imagen) }}')"
                                            />

                                    </div>
                                    <h3 class="profile-username text-center">{{ mb_strtoupper($vehicle->placa) }}</h3>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-ban"></i></span> <b>ESTADO:</b> {{ mb_strtoupper($vehicle->state->name) }}
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <b>CONJUNTO:</b> {{ mb_strtoupper($vehicle->setresidencial->name) }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                       

                        <div class="col-12 col-md-8">
                            <div class="card card-dark card-outline">
                                <div class="card-body box-profile">
                                        <h2 class="lead"><b>VISITANTES RELACIONADOS</b></h2>
                                        @php
                                            use Illuminate\Support\Str;
                                        @endphp
                                        <div class="row">
                                            @if($vehicle->visitors->isNotEmpty())        
                                                    @foreach($vehicle->visitors as $visitor)
                                                        <div class="col-4">
                                                            <div class="card" >
                                                                <img 
                                                                    src="{{ asset('storage/' . $visitor->imagen) }}" 
                                                                    class="card-img-top" 
                                                                    alt="VISITANTE"
                                                                    style="cursor: zoom-in;"
                                                                    onclick="expandVisitorImage('{{ asset('storage/' . $visitor->imagen) }}')"
                                                                />


                                                                <div class="card-body">
                                                                    <p class="card-text text-center" title="{{mb_strtoupper($visitor->name)}}">
                                                                        <b>
                                                                            {{ Str::limit( mb_strtoupper($visitor->name), 12, '...' ) }}
                                                                        </b>
                                                                    </p>
                                                                    <p class="card-text"><b>ESTADO:</b> {{ mb_strtoupper($visitor->state->name) }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                            @else
                                                SIN VISITANTES
                                            @endif
                                        </div>
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

    </section>
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

