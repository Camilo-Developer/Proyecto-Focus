<div class="col-12">
    <div class="row">
        <div class="col-12">
            @if($nameAglomeration || $typeAglomeration || $stateAglomeration || $setresidencialAglomeration)
                <div class="row">
                    <div class="col-12">
                        <h5>
                            FILTROS APLICADOS
                        </h5>
                        <ul class="list-inline">
                            @if ($nameAglomeration)
                                <li class="list-inline-item">
                                    NOMBRE: {{ mb_strtoupper($nameAglomeration) }}
                                    <a href="#" wire:click.prevent="removeFilter('nameAglomeration')" class="text-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($typeAglomeration)
                                <li class="list-inline-item">
                                    TIPO: {{ mb_strtoupper($typeAglomeration) }}
                                    <a href="#" wire:click.prevent="removeFilter('typeAglomeration')" class="text-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($stateAglomeration)
                                <li class="list-inline-item">
                                    ESTADO: {{ mb_strtoupper($states->where('id',$stateAglomeration)->first()->name) }}
                                    <a href="#" wire:click.prevent="removeFilter('stateAglomeration')" class="text-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($setresidencialAglomeration)
                                <li class="list-inline-item">
                                    CONJUNTO: {{ mb_strtoupper($setresidencials->where('id',$setresidencialAglomeration)->first()->name) }}
                                    <a href="#" wire:click.prevent="removeFilter('setresidencialAglomeration')" class="text-danger">
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
                            <label for="nameAglomeration">NOMBRE</label>
                            <input wire:model="nameAglomeration" type="text" class="form-control" id="nameAglomeration" placeholder="NOMBRE">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="typeAglomeration">TIPO</label>
                            <input wire:model="typeAglomeration" type="text" class="form-control" id="typeAglomeration" placeholder="TIPO">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="stateAglomeration">ESTADOS</label>
                            <select wire:model="stateAglomeration" class="form-control" id="stateAglomeration">
                                <option value="">-- SELECCIONAR -- </option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ mb_strtoupper($state->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if(!auth()->user()->hasRole('SUB_ADMINISTRADOR'))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="setresidencialAglomeration">CONJUNTO</label>
                                <select wire:model="setresidencialAglomeration" class="form-control select2" id="setresidencialAglomeration3" wire:ignore>
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
                            <th scope="col">TIPO</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col">CONJUNTO</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $countAgglomeration = 1;
                    @endphp
                    @foreach($agglomerations as $agglomeration)
                        <tr class="text-center">
                            <th scope="row" style="width: 50px;">{{$countAgglomeration}}</th>
                            <td>{{ mb_strtoupper($agglomeration->name) }}</td>
                            <td>{{ mb_strtoupper($agglomeration->type_agglomeration) }}</td>
                            <td>
                                @if($agglomeration->state_id == 1) <div class="badge badge-success">{{ mb_strtoupper($agglomeration->state->name) }}</div> @else <div class="badge badge-danger">{{ mb_strtoupper($agglomeration->state->name) }}</div> @endif
                            </td>
                            <td>
                                <span style="display: inline-flex; align-items: center; gap: 5px;">
                                    {{ mb_strtoupper($agglomeration->setresidencial->name) }}
                                    @if($agglomeration->setresidencial->state_id == 1) 
                                        <div style="width: 10px; height: 10px; border-radius: 100%; background-color: green;"></div>
                                    @else 
                                        <div style="width: 10px; height: 10px; border-radius: 100%; background-color: red;"></div>
                                    @endif
                                </span>
                                        
                            </td>
                            <td style="width: 100px;">
                                <div class="btn-group">
                                    @can('admin.agglomerations.edit')
                                        <a  href="{{ route('admin.agglomerations.edit', $agglomeration) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('admin.agglomerations.destroy')
                                        <button type="button" class="btn mx-2 btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $agglomeration->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <!-- Confirmación de eliminación Modal -->
                                        <div class="modal fade" id="confirmDeleteModal_{{ $agglomeration->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">CONFIRMAR ELIMINACIÓN</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿ESTAS SEGURO QUE QUIERES ELIMINAR ESTE CONJUNTO?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                                                        <form method="post" action="{{ route('admin.agglomerations.destroy', $agglomeration) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                    @can('admin.agglomerations.show')
                                        <a  href="{{ route('admin.agglomerations.show', $agglomeration->id) }}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @php
                            $countAgglomeration++;
                        @endphp
                    @endforeach
                    </tbody>
                </table>
                {{$agglomerations->links()}}
            </div>

        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        $('#setresidencialAglomeration3').select2();
        $('#setresidencialAglomeration3').on('change', function(e) {
            var setresidencialID = $('#setresidencialAglomeration3').select2("val");
            @this.set('setresidencialAglomeration',setresidencialID);
        });
    });
</script>