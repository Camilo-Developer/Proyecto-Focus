<div>
    <div class="col-12">
        @if($nameUser || $lastnameUser || $emailUser || $stateUser)
            <div class="row">
                <div class="col-12">
                    <h5>
                        FILTROS APLICADOS
                    </h5>
                    <ul class="list-inline">
                        @if ($nameUser)
                            <li class="list-inline-item">
                                NOMBRE: {{ strtoupper($nameUser) }}
                                <a href="#" wire:click.prevent="removeFilter('nameUser')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($lastnameUser)
                            <li class="list-inline-item">
                                APELLIDO: {{ strtoupper($lastnameUser) }}
                                <a href="#" wire:click.prevent="removeFilter('lastnameUser')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($emailUser)
                            <li class="list-inline-item">
                                CORREO: {{ strtoupper($emailUser) }}
                                <a href="#" wire:click.prevent="removeFilter('emailUser')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($stateUser)
                            <li class="list-inline-item">
                                ESTADO: {{ strtoupper($states->where('id',$stateUser)->first()->name) }}
                                <a href="#" wire:click.prevent="removeFilter('stateUser')" class="text-danger">
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
                        <label for="nameUser">NOMBRE</label>
                        <input wire:model="nameUser" type="text" class="form-control" id="nameUser" placeholder="NOMBRE">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="lastnameUser">APELLIDO</label>
                        <input wire:model="lastnameUser" type="text" class="form-control" id="lastnameUser" placeholder="APELLIDO">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="emailUser">CORREO</label>
                        <input wire:model="emailUser" type="text" class="form-control" id="emailUser" placeholder="CORREO">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="stateUser">ESTADO</label>
                        <select wire:model="stateUser" class="form-control" id="stateUser">
                            <option value="">-- SELECCIONAR --</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ strtoupper($state->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">APLICAR FILTRO</button>
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
                    <th scope="col">APELLIDO</th>
                    <th scope="col">CORREO</th>
                    <th scope="col">ESTADO</th>
                    <th scope="col">ROL</th>
                    <th scope="col">ACCIONES</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $countUser = 1;
                @endphp
                @foreach($users as $user)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countUser}}</th>
                        <td>{{ strtoupper($user->name) }}</td>
                        <td>{{ strtoupper($user->lastname) }}</td>
                        <td>{{ strtoupper($user->email) }}</td>
                        <td>{{ strtoupper($user->state->name) }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                {{ strtoupper($role->name) }}
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
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
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
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
        </div>

    </div>
</div>
