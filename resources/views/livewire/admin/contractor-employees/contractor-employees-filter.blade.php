<div>
    <div class="col-12">
        @if($nameEmployee || $stateEmployee || $contractorEmployee)
            <div class="row">
                <div class="col-12">
                    <h5>
                        Filtros aplicados
                    </h5>
                    <ul class="list-inline">
                        @if ($nameEmployee)
                            <li class="list-inline-item">
                                Nombre: {{ $nameEmployee }}
                                <a href="#" wire:click.prevent="removeFilter('nameEmployee')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($stateEmployee)
                            <li class="list-inline-item">
                                Estado: {{ $states->where('id',$stateEmployee)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('stateEmployee')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($contractorEmployee)
                            <li class="list-inline-item">
                                Contratista: {{ $contractors->where('id',$contractorEmployee)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('contractorEmployee')" class="text-danger">
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
                        <label for="nameEmployee">Nombre</label>
                        <input wire:model="nameEmployee" type="text" class="form-control" id="nameEmployee" placeholder="Ingrese el nombre del empleado">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="stateEmployee">Estados</label>
                        <select wire:model="stateEmployee" class="form-control" id="stateEmployee">
                            <option value="">Seleccionar Estado </option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="contractorEmployee">Contratistas</label>
                        <select wire:model="contractorEmployee" class="form-control" id="contractorEmployee">
                            <option value="">Seleccionar contratista</option>
                            @foreach($contractors as $contractor)
                                <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
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
                        <th scope="col">Contratista</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $countContractorEmployee = 1;
                @endphp
                @foreach($contractoremployees as $contractoremployee)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countContractorEmployee}}</th>
                        <td>{{ $contractoremployee->name }}</td>
                        <td>{{ $contractoremployee->state->name }}</td>
                        <td>{{ $contractoremployee->contractor->name }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.contractoremployees.edit')
                                    <button type="button" data-toggle="modal" data-target="#modalEditContractorEmployees_{{$loop->iteration}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('admin.contractoremployees.destroy')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $contractoremployee->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $contractoremployee->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar este empleado?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('admin.contractoremployees.destroy', $contractoremployee) }}">
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
                        $countContractorEmployee++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
