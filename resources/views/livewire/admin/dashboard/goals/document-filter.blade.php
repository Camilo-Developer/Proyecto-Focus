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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($visitorExists)
                        <div class="row">
                            <div class="col-12 col-md-6 d-flex align-items-stretch flex-column">
                                <div class="card bg-light d-flex flex-fill">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="lead"><b>{{ mb_strtoupper($visitor->name) }}</b></h2>
                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-users"></i></span> <b>TIPO DE USUARIO:</b> {{ mb_strtoupper($visitor->typeuser->name) }}</li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-map"></i></span> <b>DIRECCIÓN:</b> {{ mb_strtoupper($visitor->address) }}</li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> <b>TELÉFONO:</b> {{ mb_strtoupper($visitor->phone) }}</li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-address-card"></i></span> <b>NÚMERO DE DOCUMENTO:</b> {{ mb_strtoupper($visitor->document_number) }}</li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-check-square"></i></span> <b>CONFIRMACIÓN:</b> @if($visitor->confirmation == 1) SI @elseif($visitor->confirmation == 2) NO @endif</li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-ban"></i></span> <b>ESTADO:</b> {{ mb_strtoupper($visitor->state->name) }}</li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <b>CONJUNTO:</b> {{ mb_strtoupper($visitor->setresidencial->name) }}</li>
                                                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-map-marker-alt"></i></span> <b>UNIDADES:</b> 
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
                                                            @foreach($visitor->vehicles as $vehicle)
                                                                {{mb_strtoupper($vehicle->name)}}
                                                            @endforeach
                                                        @else
                                                            SIN VEHICULOS
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-5 text-center">
                                                <img src="{{asset('storage/' . $visitor->imagen)}}" alt="user-avatar" class="img-circle img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-stretch flex-column">
                                <div class="card bg-light d-flex flex-fill">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <h2 class="lead"><b>INGRESO</b></h2>
                                                @if($employeeincomeExists)
                                                    <div style="max-height: 300px; overflow-y: auto; overflow-x: hidden; padding-right: 10px;">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <p class="small"><b>FECHA INGRESO:</b><br>{{ $employeeincome->admission_date }}</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="small"><b>FECHA SALIDA:</b><br>{{ $employeeincome->departure_date ?? 'SIN SALIDA' }}</p>
                                                            </div>
                                                            <div class="col-4">
                                                                <p class="small"><b>CONJUNTO:</b><br>{{ mb_strtoupper($employeeincome->setresidencial->name) ?? 'SIN CONJUNTO' }}</p>
                                                            </div>
                                                            <div class="col-4">
                                                                <p class="small"><b>AGLOMERACIÓN:</b><br>{{ mb_strtoupper($employeeincome->agglomeration->name) ?? 'SIN AGLOMERACIÓN' }}</p>
                                                            </div>
                                                            <div class="col-4">
                                                                <p class="small"><b>UNIDAD:</b><br>{{ mb_strtoupper($employeeincome->unit->name) ?? 'SIN UNIDAD' }}</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="small"><b>PORTERÍA ENTRADA:</b><br>{{ mb_strtoupper($employeeincome->goal->name) ?? 'SIN PORTERIA' }}</p>
                                                            </div>
                                                            <div class="col-6">
                                                                <p class="small"><b>PORTERO ENTRADA:</b><br>{{ mb_strtoupper($employeeincome->user->name . ' ' . $employeeincome->user->lastname) ?? 'SIN PORTERO' }}</p>
                                                            </div>

                                                            <div class="col-6">
                                                                <p class="small"><b>PORTERÍA SALIDA:</b><br>{{ mb_strtoupper(optional($employeeincome->goal2)->name ?? 'SIN PORTERIA') }}</p>
                                                            </div>
                                                            

                                                            <div class="col-12">
                                                                <p class="small"><b>NOTA:</b></p>
                                                                {!! $employeeincome->nota !!}
                                                            </div>
                                                            <div class="col-12">
                                                                <p class="small"><b>ELEMENTOS:</b></p>
                                                                <div class="row">
                                                                    @if($employeeincome->elements->isNotEmpty())    
                                                                        @foreach($employeeincome->elements as $element)
                                                                            <div class="col-12">
                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <div class="row">
                                                                                            <div class="col-6">
                                                                                                <p>ELEMENTO: {{ mb_strtoupper($element->name) }}</p>
                                                                                                <p>NOTA:</p>
                                                                                                {!! $element->pivot->nota !!}
                                                                                            </div>
                                                                                            <div class="col-6 text-center">
                                                                                                <img src="{{asset('storage/' . $element->pivot->imagen)}}" alt="user-avatar" class="img-circle img-fluid">
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <div class="col-12">
                                                                            SIN ELEMENTOS
                                                                        </div>
                                                                    @endif
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
                                </div>
                            </div>
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                    @if ($visitorExists)
                        @if($employeeincomeExists)
                            @if($employeeincome->departure_date == null)
                                <button type="button" class="btn btn-success" wire:click="registerDeparture">INGRESAR SALIDA</button>
                            @else
                                <a href="{{route('admin.employeeincomes.create')}}" class="btn btn-warning" >CREAR INGRESO</a>
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
