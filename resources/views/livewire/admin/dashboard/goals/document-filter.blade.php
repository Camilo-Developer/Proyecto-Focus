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

    <!-- Modal -->
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
                            <div class="col-12 col-md-4 d-flex align-items-stretch flex-column">
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

                                        <a href="{{route('admin.visitors.show',$visitor)}}" class="btn btn-dark btn-block mt-2"><b>VER MÁS</b></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-8 ">
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
                                                NO SE ENCONTRÓ NINGÚN INGRESO PENDIENTE.
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-center">
                                                    <a href="{{ route('admin.employeeincomes.create') }}" class="btn btn-warning">CREAR INGRESO</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

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


                        </div>
                    @else
                        <div class="alert alert-danger">
                            NO SE ENCONTRÓ NINGÚN VISITANTE CON ESTE NÚMERO DE DOCUMENTO.
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <a href="{{route('admin.visitors.create')}}" class="btn btn-warning">CREAR VISITANTE</a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" wire:click.prevent="removeFilter('documentNumberVisitor')" >CERRAR</button>
                    @if ($visitorExists)
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
                                <a href="{{ route('admin.employeeincomes.createIncom.goal', ['ingVi' => $visitor->id])  }}" class="btn btn-warning">CREAR INGRESO</a>
                            @endif
                        @endif
                    @endif
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

        // Si deseas cerrar el modal:
        $('#modal-default').modal('hide');
    });
</script>
@endpush
