<div>
    <div class="col-12">
        @if($nameUnit || $stateUnit || $agglomerationUnit)
            <div class="row">
                <div class="col-12">
                    <h5>
                        Filtros aplicados
                    </h5>
                    <ul class="list-inline">
                        @if ($nameUnit)
                            <li class="list-inline-item">
                                Nombre: {{ $nameUnit }}
                                <a href="#" wire:click.prevent="removeFilter('nameUnit')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($stateUnit)
                            <li class="list-inline-item">
                                Estado: {{ $states->where('id',$stateUnit)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('stateUnit')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($agglomerationUnit)
                            <li class="list-inline-item">
                                Algomeracion: {{ $agglomerations->where('id',$agglomerationUnit)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('agglomerationUnit')" class="text-danger">
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
                        <label for="nameUnit">Nombre</label>
                        <input wire:model="nameUnit" type="text" class="form-control" id="nameUnit" placeholder="Ingrese el nombre de la unidad">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="stateUnit">Estados</label>
                        <select wire:model="stateUnit" class="form-control" id="stateUnit">
                            <option value="">Seleccionar Estado </option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="agglomerationUnit">Aglomeraciones</label>
                        <select wire:model="agglomerationUnit" class="form-control" id="agglomerationUnit">
                            <option value="">Seleccionar Aglomeraciones</option>
                            @foreach($agglomerations as $agglomeration)
                                <option value="{{ $agglomeration->id }}">{{ $agglomeration->name }}</option>
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
                    <th scope="col">Aglomeración</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $countUnit = 1;
                @endphp
                @foreach($units as $unit)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countUnit}}</th>
                        <td>{{ $unit->name }}</td>
                        <td>{{ $unit->state->name }}</td>
                        <td>{{ $unit->agglomeration->name }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.units.edit')
                                    <button type="button" data-toggle="modal" data-target="#modalEditUnit_{{$loop->iteration}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('admin.units.destroy')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $unit->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $unit->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar esta unidad?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('admin.units.destroy', $unit) }}">
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
                        $countUnit++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
