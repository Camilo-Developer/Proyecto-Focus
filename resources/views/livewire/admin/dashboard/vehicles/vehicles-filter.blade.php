<div class="row">
    <style>
    /* Forzamos el modal-image-view por encima del modal principal */
    .modal.modal-image-topmost {
        z-index: 1060 !important;
    }

    .modal-backdrop.modal-image-backdrop {
        z-index: 1059 !important;
    }
</style>

    <div class="col-12">
        <form wire:submit.prevent="applyFilters" class="filter-form">
            <div class="form-group">
                <label for="placaVehicles">PLACA DEL VEHICULO</label>
                <input wire:model.defer="placaVehicles" type="text" class="form-control form-control-border" id="placaVehicles">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-warning">
                    <i class="fa fa-search"></i> BUSCAR
                </button>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-default-vehicles" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">BÚSQUEDA DEL VEHICULO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" wire:click.prevent="removeFilter('placaVehicles')">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if ($vehiclesExists)
                        <div class="row">
                            <div class="col-12 col-md-4 d-flex align-items-stretch flex-column">
                                <div class="card card-warning card-outline">
                                    <div class="card-body box-profile">
                                        
                                        <div class="text-center">
                                            <img 
                                                class="profile-user-img img-fluid img-circle"
                                                src="{{ asset('storage/' . $vehicle->imagen) }}" 
                                                alt="User profile picture"
                                                style="cursor: zoom-in;"
                                                onclick="expandImage('{{ asset('storage/' . $vehicle->imagen) }}')"
                                            >
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
                                        <a href="{{route('admin.vehicles.show',$vehicle)}}" class="btn btn-dark btn-block mt-2"><b>VER MÁS</b></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-8 ">
                                <div class="card card-dark card-outline">
                                    <div class="card-body box-profile">
                                        <h2 class="lead"><b>VISITANTE RELACIONADOS</b></h2>
                                        <div class="row">
                                            @if($vehicle->visitors->isNotEmpty())        
                                                @foreach($vehicle->visitors as $index => $visitor)
                                                   <div class="col-12 col-md-4">
                                                        <div class="card" >
                                                             <img 
                                                                src="{{ asset('storage/' . $visitor->imagen) }}" 
                                                                class="card-img-top" 
                                                                alt="VISITANTE"
                                                                style="cursor: zoom-in;"
                                                                onclick="expandImage('{{ asset('storage/' . $visitor->imagen) }}')"
                                                            />
                                                            <div class="card-body">
                                                                <p class="card-text text-center">
                                                                    <b>{{ mb_strtoupper($visitor->name) }}</b>
                                                                </p>
                                                                <p class="card-text"><b>ESTADO:</b> {{ mb_strtoupper($visitor->state->name) }}</p>
                                                            </div>
                                                        </div>
                                                   </div>

                                                  
                                                @endforeach
                                            @else
                                            <div class="col-12 d-flex justify-content-center">
                                                SIN VISITANTES
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

                                                    <div class="col-12">
                                                        <div class="row m-1" style="background: #d4d4d4!important;border-radius: 5px;">
                                                            <div class="col-12">
                                                                <p class="small"><b>NOTA ENTRADA:</b></p>
                                                            </div>
                                                            <div class="col-12" >
                                                                <div class="row ">
                                                                    <div class="col-12" >
                                                                        {!! $employeeincome->nota !!}
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
                                                NO SE ENCONTRÓ NINGÚN INGRESO.
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-center">
                                                    <a href="{{ route('admin.employeeincomes.createIncom.vehicle', ['ingVi' => $vehicle->id])  }}" class="btn btn-warning">CREAR INGRESO</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($employeeincome && $employeeincome->exitentries && $employeeincome->exitentries->first())
                                @php
                                    $exitentries = $employeeincome->exitentries->first();
                                @endphp
                                @if($exitentries != null)
                                    <div class="col-12">
                                        <div class="card card-warning card-outline">
                                            <div class="card-body box-profile">
                                                <h2 class="lead"><b>DATOS DE LA SALIDA</b></h2>
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <p class="small"><b>FECHA SALIDA:</b><br>
                                                        @if($exitentries != null)
                                                        {{ \Carbon\Carbon::parse($exitentries->admission_date)->translatedFormat('d M Y h:i A') }}
                                                        @else
                                                            SIN FECHA
                                                        @endif
                                                        </p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class="small"><b>PORTERÍA SALIDA:</b><br>{{ mb_strtoupper($exitentries->goal->name ?? 'SIN PORTERÍA')  }}</p>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <p class="small"><b>PORTERO SALIDA:</b><br>{{ mb_strtoupper($exitentries->user->name ?? 'SIN PORTERO' ) . ' ' .  mb_strtoupper($exitentries->user->lastname ?? '' )  }}</p>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="row m-1" style="background: #d4d4d4!important;border-radius: 5px;">
                                                            <div class="col-12">
                                                                <p class="small"><b>NOTA ENTRADA:</b></p>
                                                            </div>
                                                            <div class="col-12" >
                                                                <div class="row ">
                                                                    <div class="col-12" >
                                                                        {!! $exitentries->nota ?? 'SIN NOTA' !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <p class="mt-1"><b>ELEMENTOS SALIDA:</b></p>
                                                        <div class="row">
                                                            @if($exitentries && $exitentries->elements)
                                                            @forelse($exitentries->elements as $element)
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
                            @endif

                        </div>
                    @else
                        <div class="alert alert-danger">
                            NO SE ENCONTRÓ NINGÚN VEHICULO CON ESTA PLACA.
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <a href="{{route('admin.vehicles.create')}}" class="btn btn-warning">CREAR VEHICULO</a>
                            </div>
                        </div>
                    @endif
                
                </div>
                 <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" wire:click.prevent="removeFilter('placaVehicles')" >CERRAR</button>
                    @if ($vehiclesExists)
                        @if ($employeeincomeExists)
                            @php
                                $firstExitEntry = $employeeincome->exitentries->first();
                            @endphp

                            @if (is_null($firstExitEntry))
                                {{-- No hay registros de salida: mostrar botones de salida --}}
                                <button type="button" class="btn btn-warning" wire:click="registerDeparture">SALIDA RÁPIDA</button>
                                <a href="{{route('admin.employeeincomes.createExit',$employeeincome)}}" class="btn btn-dark">SALIDA NORMAL</a>
                            @else
                                {{-- Ya hay registros de salida: mostrar botón de ingreso --}}
                                <a href="{{ route('admin.employeeincomes.createIncom.vehicle', ['ingVi' => $vehicle->id])  }}" class="btn btn-warning">CREAR INGRESO</a>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para imagen en pantalla completa -->
    <div class="modal fade" id="modal-image-view" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-transparent border-0">
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
    // Evento Livewire para abrir modal principal
    Livewire.on('openModalVehicle', () => {
        $('#modal-default-vehicles').modal('show');
    });

    // Evento Livewire para cerrar modal principal con notificación
    Livewire.on('departureRegistered', () => {
        Swal.fire({
            icon: 'success',
            title: 'Salida registrada correctamente',
            showConfirmButton: false,
            timer: 2000
        });
        $('#modal-default-vehicles').modal('hide');
    });

    // Función para abrir el modal de la imagen ampliada
    function expandImage(src) {
        document.getElementById('expanded-image').src = src;

        // Aseguramos que tenga clases elevadas
        $('#modal-image-view').addClass('modal-image-topmost');

        // Abrimos el modal
        $('#modal-image-view').modal('show');

        // Aumentamos z-index también al backdrop del segundo modal
        // Bootstrap crea el backdrop dinámicamente, así que lo hacemos después de un pequeño delay
        setTimeout(() => {
            $('.modal-backdrop').last().addClass('modal-image-backdrop');
        }, 10);
    }


    // Fix Bootstrap bug: restaurar scroll si otro modal sigue abierto
    $('#modal-image-view').on('hidden.bs.modal', function () {
        if ($('#modal-default-vehicles').hasClass('show')) {
            $('body').addClass('modal-open');
        }
    });
</script>
@endpush

