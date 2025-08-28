<div class="col-12 ">
    <div class="row">
        <div class="col-12">
            @if($nameGoals || $stateGoals || $setresidencialGoals)
                <div class="row">
                    <div class="col-12">
                        <h5>
                            FILTROS APLICADOS
                        </h5>
                        <ul class="list-inline">
                            @if ($nameGoals)
                                <li class="list-inline-item">
                                    NOMBRE: {{ mb_strtoupper($nameGoals) }}
                                    <a href="#" wire:click.prevent="removeFilter('nameGoals')" class="text-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </li>
                            @endif
                            @if ($stateGoals)
                                <li class="list-inline-item">
                                    ESTADO: {{ mb_strtoupper($states->where('id',$stateGoals)->first()->name) }}
                                    <a href="#" wire:click.prevent="removeFilter('stateGoals')" class="text-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </li>
                            @endif

                            @if ($setresidencialGoals)
                                <li class="list-inline-item">
                                    CONJUNTO: {{ mb_strtoupper($setresidencials->where('id',$setresidencialGoals)->first()->name) }}
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
                            <label for="nameGoals">NOMBRE</label>
                            <input wire:model="nameGoals" type="text" class="form-control" id="nameGoals" placeholder="NOMBRE">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="stateGoals">ESTADO</label>
                            <select wire:model="stateGoals" class="form-control" id="stateGoals">
                                <option value="">--SELECCIONAR--</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ mb_strtoupper($state->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if(!auth()->user()->can('admin.permission.subadministrator'))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="setresidencialGoals">CONJUNTO</label>
                                <select wire:model="setresidencialGoals" class="form-control" id="setresidencialGoals3">
                                    <option value="">--SELECCIONAR--</option>
                                    @foreach($setresidencials as $setresidencial)
                                        <option value="{{ $setresidencial->id }}">{{ mb_strtoupper($setresidencial->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

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
                            <th scope="col">PORTERÍA</th>
                            <th scope="col">ESTADO</th>
                            <th scope="col">CONJUNTO</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $countGoals = 1;
                    @endphp
                    @foreach($goals as $goal)
                        <tr class="text-center">
                            <th scope="row" style="width: 50px;">{{$countGoals}}</th>
                            <td>{{ mb_strtoupper($goal->name) }}</td>
                            <td>@if($goal->state_id == 1) <div class="badge badge-success">{{ mb_strtoupper($goal->state->name) }}</div> @else <div class="badge badge-danger">{{ mb_strtoupper($goal->state->name) }}</div> @endif</td>
                            <td>

                            <span style="display: inline-flex; align-items: center; gap: 5px;">
                                            {{ mb_strtoupper($goal->setresidencial->name) }}
                                            @if($goal->setresidencial->state_id == 1) 
                                                <div style="width: 10px; height: 10px; border-radius: 100%; background-color: green;"></div>
                                            @else 
                                                <div style="width: 10px; height: 10px; border-radius: 100%; background-color: red;"></div>
                                            @endif
                                        </span>
                            </td>

                            <td style="width: 100px;">
                                <div class="btn-group">
                                    @can('admin.goals.edit')
                                        <a href="{{route('admin.goals.edit',$goal)}}"   class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('admin.goals.destroy')
                                        <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#confirmDeleteModal_{{ $goal->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <!-- Confirmación de eliminación Modal -->
                                        <div class="modal fade" id="confirmDeleteModal_{{ $goal->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">CONFIRMAR ELIMINACIÓN</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿ESTÁS SEGURO QUE QUIERES ELIMINAR ESTA PORTERÍA?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                                        <form method="post" action="{{ route('admin.goals.destroy', $goal) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                    @can('admin.goals.show')
                                        <a href="{{route('admin.goals.show',$goal)}}"  class="btn btn-success"><i class="fa fa-eye"></i></a>
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
                {{$goals->links()}}
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        $('#setresidencialGoals3').select2();
        $('#setresidencialGoals3').on('change', function(e) {
            var setresidencialID = $('#setresidencialGoals3').select2("val");
            @this.set('setresidencialGoals',setresidencialID);
        });
    });
</script>