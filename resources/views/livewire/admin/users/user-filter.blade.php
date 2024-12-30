<div class="col-12">
    <style>
        .select2-container{
            width: 100%!important;
        }
    </style>
  <div class="col-12">
        @if($nameUser || $lastnameUser || $emailUser || $stateUser || $roleUser || $setResidencialUser)
            <div class="row">
                <div class="col-12">
                    <h5>
                        FILTROS APLICADOS
                    </h5>
                    <ul class="list-inline">
                        @if ($nameUser)
                            <li class="list-inline-item">
                                NOMBRE: {{ mb_strtoupper($nameUser) }}
                                <a href="#" wire:click.prevent="removeFilter('nameUser')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($lastnameUser)
                            <li class="list-inline-item">
                                APELLIDO: {{ mb_strtoupper($lastnameUser) }}
                                <a href="#" wire:click.prevent="removeFilter('lastnameUser')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($emailUser)
                            <li class="list-inline-item">
                                CORREO: {{ mb_strtoupper($emailUser) }}
                                <a href="#" wire:click.prevent="removeFilter('emailUser')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($stateUser)
                            <li class="list-inline-item">
                                ESTADO: {{ mb_strtoupper($states->where('id',$stateUser)->first()->name) }}
                                <a href="#" wire:click.prevent="removeFilter('stateUser')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($roleUser)
                            <li class="list-inline-item">
                                ROL: {{ mb_strtoupper($roles->where('id',$roleUser)->first()->name) }}
                                <a href="#" wire:click.prevent="removeFilter('roleUser')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($setResidencialUser)
                            <li class="list-inline-item">
                                CONJUNTO: {{ mb_strtoupper($setresidencials->where('id',$setResidencialUser)->first()->name) }}
                                <a href="#" wire:click.prevent="removeFilter('setResidencialUser')" class="text-danger">
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
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="nameUser">NOMBRE</label>
                        <input wire:model="nameUser" type="text" class="form-control" id="nameUser" placeholder="NOMBRE">
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="lastnameUser">APELLIDO</label>
                        <input wire:model="lastnameUser" type="text" class="form-control" id="lastnameUser" placeholder="APELLIDO">
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="emailUser">CORREO</label>
                        <input wire:model="emailUser" type="text" class="form-control" id="emailUser" placeholder="CORREO">
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="stateUser">ESTADO</label>
                        <select wire:model="stateUser" class="form-control" id="stateUser">
                            <option value="">-- SELECCIONAR --</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ mb_strtoupper($state->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12" >
                    <div class="collapse" id="advancedFilters">
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="roleUser">ROL</label>
                                    <select wire:model="roleUser" class="form-control" id="roleUser">
                                        <option value="">-- SELECCIONAR --</option>
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol->id }}">{{ mb_strtoupper($rol->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if(!auth()->user()->hasRole('SUB_ADMINISTRADOR'))
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="setResidencialUser1">CONJUNTO</label>
                                            </div>
                                            <div class="col-12">
                                                <select wire:model="setResidencialUser" class="form-control" id="setResidencialUser1">
                                                    <option value="">-- SELECCIONAR --</option>
                                                    @foreach($setresidencials as $setresidencial)
                                                        <option value="{{ $setresidencial->id }}">{{ mb_strtoupper($setresidencial->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary mb-3">APLICAR FILTRO</button>
                    <button type="button" class="btn btn-secondary mb-3" data-toggle="collapse" data-target="#advancedFilters" aria-expanded="false" aria-controls="advancedFilters">
                        FILTROS AVANZADOS
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">NOMBRE</th>
                        <th scope="col">APELLIDO</th>
                        <th scope="col">CORREO</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">ROL</th>
                        <th scope="col">CONJUNTO</th>
                        <th scope="col">ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $countUser = 1;
                    @endphp
                    @foreach($users as $user)
                        <tr class="text-center">
                            <th scope="row" style="width: 50px;">{{$user->id}}</th>
                            <td>{{ mb_strtoupper($user->name) }}</td>
                            <td>{{ mb_strtoupper($user->lastname) }}</td>
                            <td>{{ mb_strtoupper($user->email) }}</td>
                            <td>@if($user->state_id == 1) <div class="badge badge-success">{{ mb_strtoupper($user->state->name) }}</div> @else <div class="badge badge-danger">{{ mb_strtoupper($user->state->name) }}</div> @endif</td>
                            <td>
                                @foreach($user->roles as $role)
                                    {{ mb_strtoupper($role->name) }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @if($user->setresidencials->isEmpty())
                                    SIN CONJUNTO
                                @else
                                    @foreach($user->setresidencials as $setresidencial)
                                        <span style="display: inline-flex; align-items: center; gap: 5px;">
                                            {{ mb_strtoupper($setresidencial->name) }}
                                            @if($setresidencial->state_id == 1) 
                                                <div style="width: 10px; height: 10px; border-radius: 100%; background-color: green;"></div>
                                            @else 
                                                <div style="width: 10px; height: 10px; border-radius: 100%; background-color: red;"></div>
                                            @endif
                                        </span>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                @endif
                            </td>

                            <td style="width: 100px;">
                                <div class="btn-group">
                                    @can('admin.users.edit')
                                        <a  href="{{route('admin.users.edit',$user)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('admin.users.destroy')
                                        <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#confirmDeleteModal_{{ $user->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <!-- Confirmación de eliminación Modal -->
                                        <div class="modal fade" id="confirmDeleteModal_{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">CONFIRMAR ELIMINACIÓN</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿ESTÁS SEGURO QUE QUIERES ELIMINAR ESTE USUARIO?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                                        <form method="post" action="{{ route('admin.users.destroy', $user) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                    @can('admin.users.show')
                                        <a href="{{route('admin.users.show',$user)}}"  class="btn btn-success"><i class="fa fa-eye"></i></a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @php
                            $countUser++;
                        @endphp
                    @endforeach
                    </tbody>
                </table>

                {{$users->links()}}

            </div>
    </div>
  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        $('#setResidencialUser1').select2();
        $('#setResidencialUser1').on('change', function(e) {
            var userID = $('#setResidencialUser1').select2("val");
            @this.set('setResidencialUser',userID);
        });
    });
</script>