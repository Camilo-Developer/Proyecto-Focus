<div>
    <div class="col-12">
        @if($nameShifts || $stateShifts || $setresidencialShifts )
            <div class="row">
                <div class="col-12">
                    <h5>
                        Filtros aplicados
                    </h5>
                    <ul class="list-inline">
                        @if ($nameShifts)
                            <li class="list-inline-item">
                                Nombre: {{ $nameShifts }}
                                <a href="#" wire:click.prevent="removeFilter('nameShifts')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($stateShifts)
                            <li class="list-inline-item">
                                Estado: {{ $states->where('id',$stateShifts)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('stateShifts')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($setresidencialShifts)
                            <li class="list-inline-item">
                                Conjuto: {{ $setresidencials->where('id',$setresidencialShifts)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('setresidencialShifts')" class="text-danger">
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
                        <label for="nameShifts">Nombre</label>
                        <input wire:model="nameShifts" type="text" class="form-control" id="nameShifts" placeholder="Ingrese el nombre del turno">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="stateShifts">Estados</label>
                        <select wire:model="stateShifts" class="form-control" id="stateShifts">
                            <option value="">Seleccionar Estado </option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="setresidencialShifts">Contratistas</label>
                        <select wire:model="setresidencialShifts" class="form-control" id="setresidencialShifts">
                            <option value="">Seleccionar contratista</option>
                            @foreach($setresidencials as $setresidencial)
                                <option value="{{ $setresidencial->id }}">{{ $setresidencial->name }}</option>
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
                    <th scope="col">Nombre</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Conjuto</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $countShifts = 1;
                @endphp
                @foreach($shifts as $shift)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countShifts}}</th>
                        <td>{{ $shift->name }}</td>
                        <td>{{ $shift->state->name }}</td>
                        <td>{{ $shift->setresidencial->name }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.shifts.edit')
                                    <button type="button" data-toggle="modal" data-target="#modalEditShifts_{{$shift->id}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('admin.shifts.destroy')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $shift->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $shift->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar este turno?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('admin.shifts.destroy', $shift) }}">
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
                        $countShifts++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
