<div class="col-12">
    <div class="row">
        <div class="col-12">
            @if($nameUnit || $stateUnit || $agglomerationUnit || $setresidencialUnit)
                <div class="row">
                    <div class="col-12">
                        <h5>
                            FILTROS APLICADOS
                        </h5>
                        <ul class="list-inline">
                            @if ($nameUnit)
                                <li class="list-inline-item">
                                    NOMBRE: {{ mb_strtoupper($nameUnit) }}
                                    <a href="#" wire:click.prevent="removeFilter('nameUnit')" class="text-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($stateUnit)
                                <li class="list-inline-item">
                                    ESTADO: {{ mb_strtoupper($states->where('id',$stateUnit)->first()->name) }}
                                    <a href="#" wire:click.prevent="removeFilter('stateUnit')" class="text-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($agglomerationUnit)
                                <li class="list-inline-item">
                                    AGLOMEREACIÓN: {{ mb_strtoupper($agglomerations->where('id',$agglomerationUnit)->first()->name) }}
                                    <a href="#" wire:click.prevent="removeFilter('agglomerationUnit')" class="text-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($setresidencialUnit)
                                <li class="list-inline-item">
                                    CONJUNTO: {{ mb_strtoupper($setresidencials->where('id',$setresidencialUnit)->first()->name) }}
                                    <a href="#" wire:click.prevent="removeFilter('setresidencialUnit')" class="text-danger">
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
                            <label for="nameUnit">NOMBRE</label>
                            <input wire:model="nameUnit" type="text" class="form-control" id="nameUnit" placeholder="NOMBRE">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="stateUnit">ESTADOS</label>
                            <select wire:model="stateUnit" class="form-control" id="stateUnit">
                                <option value="">-- SELECCIONAR -- </option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ mb_strtoupper($state->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="agglomerationUnit">AGLOMERACIONES</label>
                            <select wire:model="agglomerationUnit" class="form-control" id="agglomerationUnit3">
                                <option value="">-- SELECCIONAR --</option>
                                @foreach($agglomerations as $agglomeration)
                                    <option value="{{ $agglomeration->id }}">{{ mb_strtoupper($agglomeration->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if(!auth()->user()->hasRole('SUB_ADMINISTRADOR'))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="setresidencialUnit">CONJUNTO</label>
                            <select wire:model="setresidencialUnit" class="form-control" id="setresidencialUnit3">
                                <option value="">-- SELECCIONAR --</option>
                                @foreach($setresidencials as $setresidencial)
                                    <option value="{{ $setresidencial->id }}">{{ mb_strtoupper($setresidencial->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-12 mb-2">
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
                        <th scope="col">NOMBRE</th>
                        <th scope="col">AGLOMERACIÓN</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">CONJUNTO</th>
                        <th scope="col">ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($units as $unit)
                        <tr class="text-center">
                            <th scope="row" style="width: 50px;">{{$unit->id}}</th>
                            <td>{{ mb_strtoupper($unit->name) }}</td>
                            <td>
                                <span style="display: inline-flex; align-items: center; gap: 5px;">
                                    {{ mb_strtoupper($unit->agglomeration->name) }}
                                    @if($unit->agglomeration->state_id == 1) 
                                        <div style="width: 10px; height: 10px; border-radius: 100%; background-color: green;"></div>
                                    @else 
                                        <div style="width: 10px; height: 10px; border-radius: 100%; background-color: red;"></div>
                                    @endif
                                </span>
                            </td>
                            <td>@if($unit->state_id == 1) <div class="badge badge-success">{{ mb_strtoupper($unit->state->name) }}</div> @else <div class="badge badge-danger">{{ mb_strtoupper($unit->state->name) }}</div> @endif </td>
                            <td>
                                <span style="display: inline-flex; align-items: center; gap: 5px;">
                                    {{ mb_strtoupper($unit->agglomeration->setresidencial->name) }}
                                    @if($unit->agglomeration->setresidencial->state_id == 1) 
                                        <div style="width: 10px; height: 10px; border-radius: 100%; background-color: green;"></div>
                                    @else 
                                        <div style="width: 10px; height: 10px; border-radius: 100%; background-color: red;"></div>
                                    @endif
                                </span>
                            </td>
                            <td style="width: 100px;">
                                <div class="btn-group">
                                    @can('admin.units.edit')
                                        <a  href="{{ route('admin.units.edit', $unit) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('admin.units.destroy')
                                        <button type="button" class="btn mx-2 btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $unit->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <!-- Confirmación de eliminación Modal -->
                                        <div class="modal fade" id="confirmDeleteModal_{{ $unit->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">CONFIRMAR ELIMINACIÓN</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿ESTAS SEGURO QUE QUIERES ELIMINAR ESTA UNIDAD?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                                        <form method="post" action="{{ route('admin.units.destroy', $unit) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                    @can('admin.units.show')
                                        <a  href="{{ route('admin.units.show', $unit->id) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$units->links()}}

            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        $('#agglomerationUnit3').select2();
        $('#agglomerationUnit3').on('change', function(e) {
            var agglomerationID = $('#agglomerationUnit3').select2("val");
            @this.set('agglomerationUnit',agglomerationID);
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        $('#setresidencialUnit3').select2();
        $('#setresidencialUnit3').on('change', function(e) {
            var setresidencialID = $('#setresidencialUnit3').select2("val");
            @this.set('setresidencialUnit',setresidencialID);
        });
    });
</script>
