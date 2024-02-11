<div>
    <div class="col-12">
        @if($nameGoals || $stateGoals || $setresidencialGoals)
            <div class="row">
                <div class="col-12">
                    <h5>
                        Filtros aplicados
                    </h5>
                    <ul class="list-inline">
                        @if ($nameGoals)
                            <li class="list-inline-item">
                                Nombre: {{ $nameGoals }}
                                <a href="#" wire:click.prevent="removeFilter('nameGoals')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($stateGoals)
                            <li class="list-inline-item">
                                Estado: {{ $states->where('id',$stateGoals)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('stateGoals')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($setresidencialGoals)
                            <li class="list-inline-item">
                                Estado: {{ $setresidencials->where('id',$setresidencialGoals)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('setresidencialGoals')" class="text-danger">
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
                        <label for="nameGoals">Nombre Porteria</label>
                        <input wire:model="nameGoals" type="text" class="form-control" id="nameGoals" placeholder="Ingrese el nombre de la  porteria">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="stateGoals">Eestado de la  porteria</label>
                        <select wire:model="stateGoals" class="form-control" id="stateGoals">
                            <option value="">Seleccionar porteria</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="setresidencialGoals">Eestado de la  porteria</label>
                        <select wire:model="setresidencialGoals" class="form-control" id="setresidencialGoals">
                            <option value="">Seleccionar porteria</option>
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
                        <th scope="col">Porteria</th>
                        <th scope="col">Estado de Porteria</th>
                        <th scope="col">Conjunto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $countGoals = 1;
                @endphp
                @foreach($goals as $goal)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countGoals}}</th>
                        <td>{{ $goal->name }}</td>
                        <td>{{ $goal->state->name }}</td>
                        <td>{{ $goal->setresidencial->name }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.goals.edit')
                                    <button type="button" data-toggle="modal" data-target="#modalEditGoals_{{$goal->id}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('admin.goals.destroy')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $goal->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $goal->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar esta porteria?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('admin.goals.destroy', $goal) }}">
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
                        $countGoals++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
