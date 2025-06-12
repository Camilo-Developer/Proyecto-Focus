<div class="col-12">
   <div class="row">
        <div class="col-12">
                @if($nameSetResidencial || $nitSetResidencial || $stateSetResidencial || $userSetResidencial)
                    <div class="row">
                        <div class="col-12">
                            <h5>
                                FILTROS APLICADOS
                            </h5>
                            <ul class="list-inline">
                                @if ($nameSetResidencial)
                                    <li class="list-inline-item">
                                        NOMBRE: {{ mb_strtoupper($nameSetResidencial) }}
                                        <a href="#" wire:click.prevent="removeFilter('nameSetResidencial')" class="text-danger">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </li>
                                @endif
                                @if ($nitSetResidencial)
                                    <li class="list-inline-item">
                                        NIT: {{ mb_strtoupper($nitSetResidencial) }}
                                        <a href="#" wire:click.prevent="removeFilter('nitSetResidencial')" class="text-danger">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </li>
                                @endif
                                @if ($stateSetResidencial)
                                    <li class="list-inline-item">
                                        ESTADO: {{ mb_strtoupper($states->where('id',$stateSetResidencial)->first()->name) }}
                                        <a href="#" wire:click.prevent="removeFilter('stateSetResidencial')" class="text-danger">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </li>
                                @endif

                                @if ($userSetResidencial)
                                    <li class="list-inline-item">
                                        ADMINISTRADOR: {{ mb_strtoupper($users->where('id',$userSetResidencial)->first()->name) . ' ' .  mb_strtoupper($users->where('id',$userSetResidencial)->first()->lastname)}}
                                        <a href="#" wire:click.prevent="removeFilter('userSetResidencial')" class="text-danger">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </li>
                                @endif
                            
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-12 mb-3">
                <form wire:submit.prevent="applyFilters" class="filter-form" wire:ignore>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nameSetResidencial">NOMBRE</label>
                                <input wire:model="nameSetResidencial" type="text" class="form-control" id="nameSetResidencial" placeholder="NOMBRE">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nitSetResidencial">NIT</label>
                                <input wire:model="nitSetResidencial" type="text" class="form-control" id="nitSetResidencial" placeholder="NIT">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="stateSetResidencial">ESTADO</label>
                                <select wire:model="stateSetResidencial" class="form-control" id="stateSetResidencial">
                                    <option value="">-- SELECCIONAR --</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ mb_strtoupper($state->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="userSetResidencial">ADMINISTRADORES</label>
                                <select wire:model="userSetResidencial" class="form-control" id="userSetResidencial3">
                                    <option value="">-- SELECCIONAR --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ mb_strtoupper($user->name) }} {{ mb_strtoupper($user->lastname) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
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
                                <th scope="col">DIRECCIÓN</th>
                                <th scope="col">NIT</th>
                                <th scope="col">ADMINISTRADOR</th>
                                <th scope="col">ESTADO</th>
                                <th scope="col">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($setresidencials as $setresidencial)
                            <tr class="text-center">
                                <th scope="row" style="width: 50px;">{{$setresidencial->id}}</th>
                                <td>{{ mb_strtoupper($setresidencial->name) }}</td>
                                <td>{{ mb_strtoupper($setresidencial->address) }}</td>
                                <td>{{ mb_strtoupper($setresidencial->nit ?? 'SIN NIT') }}</td>
                                <td>
                                    @if($setresidencial->users->isEmpty())
                                        SIN USUARIO
                                    @else
                                        @foreach($setresidencial->users as $user)
                                            @if($user->hasRole(1) || $user->hasRole(2)) 
                                                <span style="display: inline-block; vertical-align: middle;">{{ mb_strtoupper($user->name) }} {{ mb_strtoupper($user->lastname) }}</span>
                                                @if($user->state_id == 1)
                                                    <div style="display: inline-block; width: 6px; height: 6px; border-radius: 100%; background-color: green; vertical-align: middle; margin-left: 5px;"></div>
                                                @else
                                                    <div style="display: inline-block; width: 6px; height: 6px; border-radius: 100%; background-color: red; vertical-align: middle; margin-left: 5px;"></div>
                                                @endif
                                                @if (!$loop->last)
                                                    <span>,</span> <!-- Si no es el último, mostrar una coma -->
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </td>

                                <td>@if($setresidencial->state_id == 1) <div class="badge badge-success">{{ mb_strtoupper($setresidencial->state->name) }}</div> @else <div class="badge badge-danger">{{ mb_strtoupper($setresidencial->state->name) }}</div> @endif</td>
                                <td style="width: 100px;">
                                    <div class="btn-group">
                                        @can('admin.setresidencials.edit')
                                            <a href="{{route('admin.setresidencials.edit',$setresidencial)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        @endcan
                                        @can('admin.setresidencials.destroy')
                                            <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#confirmDeleteModal_{{ $setresidencial->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Confirmación de eliminación Modal -->
                                            <div class="modal fade" id="confirmDeleteModal_{{ $setresidencial->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">CONFIRMAR ELIMINACIÓN</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿ESTÁS SEGURO QUE QUIERES ELIMINAR ESTE CONJUNTO?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                                            <form method="post" action="{{ route('admin.setresidencials.destroy', $setresidencial) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endcan
                                        @can('admin.setresidencials.show')
                                            <a href="{{route('admin.setresidencials.show',$setresidencial)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$setresidencials->links()}}

                </div>

            </div>
   </div>
    
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        $('#userSetResidencial3').select2();
        $('#userSetResidencial3').on('change', function(e) {
            var userID = $('#userSetResidencial3').select2("val");
            @this.set('userSetResidencial',userID);
        });
    });
</script>
