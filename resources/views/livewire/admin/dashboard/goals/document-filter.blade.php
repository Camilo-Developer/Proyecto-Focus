<div class="row">
    <div class="col-12">
        <form wire:submit.prevent="applyFilters" class="filter-form">
            <div class="form-group">
                <label for="documentNumberVisitor">NÚMERO DE DOCUMENTO</label>
                <input wire:model.defer="documentNumberVisitor" type="number" class="form-control form-control-border" id="documentNumberVisitor">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-warning">
                    <i class="fa fa-search"></i> BUSCAR
                </button>
            </div>
        </form>
    </div>
    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">BÚSQUEDA DEL VISITANTE</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" wire:click.prevent="removeFilter('documentNumberVisitor')">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($visitorExists)
                        <div class="row">
                            <div class="col-12 col-lg-4 d-flex align-items-stretch flex-column">
                                <div class="card card-warning card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img 
                                                class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('storage/' . $visitor->imagen) }}" 
                                                alt="User profile picture"
                                                style="cursor: zoom-in;"
                                                onclick="expandImage('{{ asset('storage/' . $visitor->imagen) }}')"
                                            >
                                        </div>
                                        <h3 class="profile-username text-center">{{ mb_strtoupper($visitor->name) }}</h3>
                                        <p class="text-muted text-center">{{ mb_strtoupper($visitor->typeuser->name) }}</p>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            @if($visitor->type_user_id != 1)
                                            <li class="small">
                                                <span class="fa-li"><i class="fas fa-lg fa-car"></i></span> <b>PLACA:</b> {{ mb_strtoupper($visitor->address ?? 'SIN VEHICULO') }}
                                            </li>
                                            @endif
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
                                        <a href="{{route('admin.visitors.show',$visitor)}}" class="btn btn-dark btn-block mt-2"><b>VER MÁS</b></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-8 ">
                                <div class="card card-dark card-outline">
                                    <div class="card-body box-profile">
                                        <h2 class="lead"><b>VEHÍCULOS RELACIONADOS</b></h2>
                                        <div class="row">
                                            @if($visitor->vehicles->isNotEmpty())        
                                                @foreach($visitor->vehicles as $index => $vehicle)
                                                   <div class="col-12 col-lg-4">
                                                        <div class="card" >
                                                            <img 
                                                                src="{{ asset('storage/' . $vehicle->imagen) }}" 
                                                                class="card-img-top" 
                                                                alt="VEHÍCULO"
                                                                style="cursor: zoom-in;"
                                                                onclick="expandImage('{{ asset('storage/' . $vehicle->imagen) }}')"
                                                            />
                                                            <div class="card-body">
                                                                <p class="card-text text-center">
                                                                    <b>{{ mb_strtoupper($vehicle->placa) }}</b>
                                                                </p>
                                                                <p class="card-text"><b>ESTADO:</b> {{ mb_strtoupper($vehicle->state->name) }}</p>
                                                                <div class="d-flex justify-content-center">
                                                                   <button 
                                                                        class="btn {{ $index % 2 === 0 ? 'btn-warning' : 'btn-dark' }}" 
                                                                        wire:click="selectVehicle({{ $vehicle->id }})"
                                                                        @if($selectedVehicleId !== null && $selectedVehicleId !== $vehicle->id) disabled @endif
                                                                    >
                                                                        @if($selectedVehicleId === $vehicle->id)
                                                                            DESMARCAR
                                                                        @else
                                                                            SELECCIONAR
                                                                        @endif
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                   </div>
                                                @endforeach
                                            @else
                                            <div class="col-12 d-flex justify-content-center">
                                                SIN VEHÍCULOS
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card card-dark card-outline">
                                    <div class="card-body box-profile">
                                        <h2 class="lead"><b>DATOS DEL ÚLTIMO INGRESO</b></h2>
                                        @if($employeeincomeExists)
                                            <div style="max-height: 343px; overflow-y: auto; overflow-x: hidden; padding-right: 10px;">
                                                <div class="row ">
                                                    <div class="col-12 col-md-4">
                                                        <p class="small"><b>TIPO INGRESO:</b><br>
                                                            @if($employeeincome->type_income == 1)
                                                             PEATONAL
                                                            @else
                                                                VEHICULAR
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class="small"><b>FECHA INGRESO:</b><br>
                                                            {{ \Carbon\Carbon::parse($employeeincome->admission_date)->translatedFormat('d M Y h:i A') }}
                                                        </p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class="small"><b>PORTERÍA ENTRADA:</b><br>{{ mb_strtoupper($employeeincome->goal->name ?? 'SIN PORTERIA')  }}</p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class="small"><b>PORTERO ENTRADA:</b><br>{{ mb_strtoupper($employeeincome->user->name  ?? 'SIN PORTERO')  . ' ' . mb_strtoupper($employeeincome->user->lastname ?? '') }}</p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class="small"><b>CONJUNTO:</b><br>{{ mb_strtoupper($employeeincome->setresidencial->name ?? 'SIN CONJUNTO')  }}</p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class="small"><b>AGLOMERACIÓN:</b><br>{{ mb_strtoupper($employeeincome->agglomeration->name ?? 'SIN AGLOMERACIÓN')  }}</p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class="small"><b>UNIDAD:</b><br>{{ mb_strtoupper($employeeincome->unit->name ?? 'SIN UNIDAD')  }}</p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class="small"><b>INGRESO VEHÍCULO:</b><br>
                                                           @if($employeeincome->vehicles->isNotEmpty())
                                                                {{ mb_strtoupper($employeeincome->vehicles
                                                                    ->where('pivot.visitor_id', $visitor->id)
                                                                    ->pluck('placa')
                                                                    ->implode(', ')) }}
                                                            @else
                                                                NO
                                                            @endif

                                                        </p>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="row m-1" style="background: #d4d4d4!important;border-radius: 5px;">
                                                            <div class="col-12">
                                                                <p class="small"><b>NOTA ENTRADA:</b></p>
                                                            </div>
                                                            <div class="col-12" >
                                                                <div class="row ">
                                                                    <div class="col-12" >
                                                                        {!! $employeeincome->nota ?? 'SIN NOTA'!!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="mt-1"><b>ELEMENTOS INGRESOS:</b></p>
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
                                        @else
                                            <div class="alert alert-danger">
                                                NO SE ENCONTRÓ NINGÚN INGRESO PENDIENTE.
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-center">
                                                     @if($selectedVehicleId)
                                                        <button 
                                                            wire:click="crearIngresoConValidacion2" 
                                                            class="btn btn-warning"
                                                        >
                                                            CREAR INGRESO
                                                        </button>

                                                    @else
                                                        <a href="{{ route('admin.employeeincomes.createIncom.goal', ['ingVi' => $visitor->id])  }}" class="btn btn-warning">CREAR INGRESO</a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                                
                            @if($exitentry != null)
                                <div class="col-12">
                                    <div class="card card-warning card-outline">
                                        <div class="card-body box-profile">
                                            <h2 class="lead"><b>DATOS DE LA SALIDA</b></h2>
                                            <div class="row">
                                                <div class="col-12 col-md-4">
                                                        <p class="small"><b>TIPO SALIDA:</b><br>
                                                            @if($exitentry->type_income == 1)
                                                             PEATONAL
                                                            @else
                                                                VEHICULAR
                                                            @endif
                                                        </p>
                                                    </div>
                                                <div class="col-12 col-md-4">
                                                    <p class="small"><b>FECHA SALIDA:</b><br>
                                                    @if($exitentry != null)
                                                    {{ \Carbon\Carbon::parse($exitentry->departure_date)->translatedFormat('d M Y h:i A') }}
                                                    @else
                                                        SIN FECHA
                                                    @endif
                                                    </p>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <p class="small"><b>PORTERÍA SALIDA:</b><br>{{ mb_strtoupper($exitentry->goal->name ?? 'SIN PORTERÍA')  }}</p>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <p class="small"><b>PORTERO SALIDA:</b><br>{{ mb_strtoupper($exitentry->user->name ?? 'SIN PORTERO' ) . ' ' .  mb_strtoupper($exitentry->user->lastname ?? '' )  }}</p>
                                                </div>
                                                <div class="col-12 col-md-4">

                                                          <p class="small"><b>SALIDA VEHÍCULO:</b><br>
                                                            @if($exitentry->vehicles->isNotEmpty())
                                                                {{ mb_strtoupper($exitentry->vehicles
                                                                    ->where('pivot.visitor_id', $visitor->id)
                                                                    ->pluck('placa')
                                                                    ->implode(', ')) }}
                                                            @else
                                                                NO
                                                            @endif
                                                        </p>
                                                    </div>
                                                <div class="col-12">
                                                    <div class="row m-1" style="background: #d4d4d4!important;border-radius: 5px;">
                                                        <div class="col-12">
                                                            <p class="small"><b>NOTA ENTRADA:</b></p>
                                                        </div>
                                                        <div class="col-12" >
                                                            <div class="row ">
                                                                <div class="col-12" >
                                                                    {!! $exitentry->nota ?? 'SIN NOTA' !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <p class="mt-1"><b>ELEMENTOS SALIDA:</b></p>
                                                    <div class="row">
                                                        @if($exitentry && $exitentry->elements)
                                                        @forelse($exitentry->elements as $element)
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
                                                        @else
                                                        <div class="col-12">
                                                                <span class="text-uppercase">SIN ELEMENTO</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-danger">
                            NO SE ENCONTRÓ NINGÚN VISITANTE CON ESTE NÚMERO DE DOCUMENTO.
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <a href="{{route('admin.visitors.create', ['Doc' => $documentNumberVisitor])}}" class="btn btn-warning">CREAR VISITANTE</a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" wire:click.prevent="removeFilter('documentNumberVisitor')" >CERRAR</button>
                    @if ($visitorExists)
                        @if ($employeeincomeExists)
                            @php
                                $firstExitEntry = $exitentry;
                            @endphp
                            @if (is_null($firstExitEntry))
                                <button type="button" class="btn btn-warning" wire:click="registerDeparture">SALIDA RÁPIDA</button>
                                @if($selectedVehicleId)
                                    <button 
                                        wire:click="SalidaValidation" 
                                        class="btn btn-dark"
                                    >
                                        SALIDA NORMAL
                                    </button>
                                @else
                                    <a href="{{route('admin.employeeincomes.createExit',$employeeincome)}}?ingVi={{ $visitor->id }}&iden=p" class="btn btn-dark">SALIDA NORMAL</a>
                                @endif
                            @else
                               @if($selectedVehicleId)
                                    <button class="btn btn-dark" wire:click="createIncomeVisiOnly">INGRESO RÁPIDO</button>

                                    <button 
                                        wire:click="crearIngresoConValidacion" 
                                        class="btn btn-warning"
                                    >
                                        INGRESO NORMAL
                                    </button>
                                @else
                                    <button class="btn btn-dark" wire:click="createIncomeVisiOnly">INGRESO RÁPIDO</button>
                                    <a href="{{ route('admin.employeeincomes.createIncom.goal', ['ingVi' => $visitor->id]) }}" class="btn btn-warning">
                                        INGRESO NORMAL
                                    </a>
                                @endif

                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        .selectable-unit {
            cursor: pointer;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: none;
        }

        .selectable-unit:hover {
            background-color: #0d6efd;
        }

        .selectable-unit:has(input:checked) {
            background-color: #0d6efd;
            color: #fff;
        }
    </style>

    @if($showUnitModal)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">SELECCIONE LA UNIDAD A INGRESAR</h5>
                </div>
      <div class="modal-body">
    <div class="list-group">
        @foreach($visitorUnits as $unit)
            <label class="list-group-item selectable-unit mt-2">
                <input type="radio" wire:model="selectedUnit" value="{{ $unit->id }}" class="d-none">
                {{ mb_strtoupper($unit->name) }}
            </label>
        @endforeach
    </div>
</div>


                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="$set('showUnitModal', false)">CANCELAR</button>
                    <button class="btn btn-primary" wire:click="confirmUnitSelection">CONFIRMAR</button>
                </div>
                </div>
            </div>
        </div>
    @endif


    <div class="modal fade" id="modal-image-view" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-body text-center">
                    <img id="expanded-image" src="" class="img-fluid" style="max-height: 80vh; border-radius: 10px;">
                    <div class="mt-3">
                        <button type="button" class="btn btn-light btn-sm" onclick="$('#modal-image-view').modal('hide')">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    Livewire.on('openModalVisitor', () => {
        $('#modal-default').modal('show');
    });
    Livewire.on('departureRegistered', () => {
        Swal.fire({
            icon: 'success',
            title: 'Salida registrada correctamente',
            showConfirmButton: false,
            timer: 2000
        });
        $('#modal-default').modal('hide');
    });
    function expandImage(src) {
        document.getElementById('expanded-image').src = src;
        $('#modal-image-view').modal('show');
    }
    $('#modal-image-view').on('hidden.bs.modal', function () {
        if ($('#modal-default').hasClass('show')) {
            $('body').addClass('modal-open');
        }
    });
</script>
<script>
    Livewire.on('alertIngresoBloqueado', () => {
        Swal.fire({
            icon: 'warning',
            title: 'INGRESO DENEGADO',
            text: 'ESTE VEHÍCULO YA TIENE UN INGRESO REGISTRADO Y NO HA SALIDO AÚN.',
        });
    });
</script>
<script>
    Livewire.on('alertIngresoBloqueado2', () => {
        Swal.fire({
            icon: 'warning',
            title: 'INGRESO DENEGADO',
            text: 'ESTE VEHÍCULO YA TIENE UN INGRESO REGISTRADO Y NO HA SALIDO AÚN.',
        });
    });
</script>

<script>
    document.addEventListener('livewire:initialized', () => {

    Livewire.on('alertSalida', () => {
        Swal.fire({
            icon: 'warning',
            title: 'SALIDA DENEGADO',
            text: 'ESTE VEHÍCULO YA TIENE UNA SALIDA REGISTRADA Y NO HA INGRESADO AÚN.',
        });
    });
    });

</script>
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('alert', ({ message }) => {
            Swal.fire({
                icon: 'warning',
                title: 'ATENCIÓN',
                text: message,
                confirmButtonText: 'ACEPTAR '
            });
        });
    });
</script>

<script>
    Livewire.on('incomeRegistered', () => {
        Swal.fire({
            icon: 'success',
            title: 'INGRESO CREADO CORRECTAMENTE.',
            showConfirmButton: false,
            timer: 2000
        });
        $('#modal-default').modal('hide');
    });
</script>
@endpush