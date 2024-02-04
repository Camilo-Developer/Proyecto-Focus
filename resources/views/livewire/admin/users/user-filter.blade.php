<div>
    <div class="col-12">
        @if($nameUser || $lastnameUser || $emailUser || $stateUser)
            <div class="row">
                <div class="col-12">
                    <h5>
                        Filtros aplicados
                    </h5>
                    <ul class="list-inline">
                        @if ($nameUser)
                            <li class="list-inline-item">
                                Nombre: {{ $nameUser }}
                                <a href="#" wire:click.prevent="removeFilter('nameUser')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($lastnameUser)
                            <li class="list-inline-item">
                                Apellido: {{ $lastnameUser }}
                                <a href="#" wire:click.prevent="removeFilter('lastnameUser')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($emailUser)
                            <li class="list-inline-item">
                                Correo: {{ $emailUser }}
                                <a href="#" wire:click.prevent="removeFilter('emailUser')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($stateUser)
                            <li class="list-inline-item">
                                Estado: {{ $states->where('id',$stateUser)->first()->name }}
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

    <div class="col-12">
        <form wire:submit.prevent="applyFilters" class="filter-form" wire:ignore>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nameUser">Nombre</label>
                        <input wire:model="nameUser" type="text" class="form-control" id="nameUser" placeholder="Ingrese el nombre del usuario">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="lastnameUser">Apeliido</label>
                        <input wire:model="lastnameUser" type="text" class="form-control" id="lastnameUser" placeholder="Ingrese el apellido del usuario">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="emailUser">Correo</label>
                        <input wire:model="emailUser" type="text" class="form-control" id="emailUser" placeholder="Ingrese el correo del usuario">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="stateUser">Estados</label>
                        <select wire:model="stateUser" class="form-control" id="stateUser">
                            <option value="">Seleccionar Estado </option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
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
                    <th scope="col">Apellido</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $countUser = 1;
                @endphp
                @foreach($users as $user)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countUser}}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->state->name }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                {{ $role->name }}
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.users.edit')
                                    <button type="button" data-toggle="modal" data-target="#modalEditUser_{{$loop->iteration}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('admin.users.destroy')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $user->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar este usuario?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('admin.users.destroy', $user) }}">
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
                        $countUser++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
