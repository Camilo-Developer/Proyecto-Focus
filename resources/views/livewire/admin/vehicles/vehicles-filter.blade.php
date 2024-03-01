<div>
    <div class="col-12">
        @if($plateVehicles || $ownerVehicles || $statesVehicles)
            <div class="row">
                <div class="col-12">
                    <h5>
                        Filtros aplicados
                    </h5>
                    <ul class="list-inline">
                        @if ($plateVehicles)
                            <li class="list-inline-item">
                                Placa: {{ $plateVehicles }}
                                <a href="#" wire:click.prevent="removeFilter('plateVehicles')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($ownerVehicles)
                            <li class="list-inline-item">
                                Propietario: {{ $ownerVehicles }}
                                <a href="#" wire:click.prevent="removeFilter('ownerVehicles')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($statesVehicles)
                            <li class="list-inline-item">
                                Estados: {{ $states->where('id',$statesVehicles)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('statesVehicles')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        @endif
    </div>
    <div class="col-12">
        <form wire:submit.prevent="applyFilters" class="filter-form" wire:ignore>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="plateVehicles">Placa</label>
                        <input wire:model="plateVehicles" type="text" class="form-control" id="plateVehicles">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="ownerVehicles">Propietario</label>
                        <input wire:model="ownerVehicles" type="text" class="form-control" id="ownerVehicles">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="statesVehicles">Estado</label>
                        <select wire:model="statesVehicles" class="form-control" id="statesVehicles">
                            <option value="">Seleccionar Estado </option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Propietario</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $countVehicles = 1;
                @endphp
                @foreach($vehicles as $vehicle)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countVehicles}}</th>
                        <td>{{ $vehicle->plate }}</td>
                        <td>{{ $vehicle->owner }}</td>
                        <td>{{ $vehicle->state->name }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.vehicles.edit')
                                    <button type="button" data-toggle="modal" data-target="#modalEditvehicles_{{$vehicle->id}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('admin.vehicles.destroy')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $vehicle->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $vehicle->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar este vehiculo?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('admin.vehicles.destroy', $vehicle) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @php
                        $countVehicles++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
