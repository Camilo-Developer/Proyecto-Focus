<div class="col-12">
    <div class="row">
    <div class="col-12">
        @if($plateVehicles || $statesVehicles)
            <div class="row">
                <div class="col-12">
                    <h5>
                        FILTROS APLICADOS
                    </h5>
                    <ul class="list-inline">
                        @if ($plateVehicles)
                            <li class="list-inline-item">
                                PLACA: {{ mb_strtoupper($plateVehicles) }}
                                <a href="#" wire:click.prevent="removeFilter('plateVehicles')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                       
                        @if ($statesVehicles)
                            <li class="list-inline-item">
                                ESTADO: {{ mb_strtoupper($states->where('id',$statesVehicles)->first()->name) }}
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
                        <label for="plateVehicles">PLACA</label>
                        <input wire:model="plateVehicles" type="text" class="form-control" id="plateVehicles">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="statesVehicles">ESTADO</label>
                        <select wire:model="statesVehicles" class="form-control" id="statesVehicles">
                            <option value="">SELECCIONAR </option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ mb_strtoupper($state->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-primary">APLICAR FILTROS</button>
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
                    <th scope="col">PLACA</th>
                    <th scope="col">CONJUNTO</th>
                    <th scope="col">ESTADO</th>
                    <th scope="col">ACCIONES</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $countVehicles = 1;
                @endphp
                @foreach($vehicles as $vehicle)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countVehicles}}</th>
                        <td>{{ mb_strtoupper($vehicle->placa) }}</td>
                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 5px;">
                                {{ mb_strtoupper($vehicle->setresidencial->name) }}
                                @if($vehicle->setresidencial->state_id == 1) 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: green;"></div>
                                @else 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: red;"></div>
                                @endif
                            </span>
                        </td>
                        <td>@if($vehicle->state_id == 1) <div class="badge badge-success">{{ mb_strtoupper($vehicle->state->name) }}</div> @else <div class="badge badge-danger">{{ mb_strtoupper($vehicle->state->name) }}</div> @endif</td>

                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.vehicles.edit')
                                    <a href="{{route('admin.vehicles.edit',$vehicle)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('admin.vehicles.destroy')
                                    <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#confirmDeleteModal_{{ $vehicle->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $vehicle->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">CONFIRMAR ELIMINACIÓN</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿ESTÁS SEGURO QUE QUIERES ELIMINAR ESTE VEHICULO?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                                    <form method="post" action="{{ route('admin.vehicles.destroy', $vehicle) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                                @can('admin.vehicles.show')
                                <a href="{{route('admin.vehicles.show',$vehicle)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
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
        {{$vehicles->links()}}
    </div>
    </div>
    
</div>
