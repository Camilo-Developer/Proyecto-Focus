@extends('layouts.app2')
@section('title', 'Lista de Usuarios')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Usuarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista de Usuarios</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid" >
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    @can('admin.users.create')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#usersCreate"><i class="fa fa-check"></i> Crear Usuario</button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @livewire('admin.users.user-filter')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('admin.users.create')
            <div class="modal fade" id="usersCreate"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-check-circle"></i> Nueva Usuario</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.users.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                        <input type="text" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre del Usuario">
                                    </div>
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="lastname">Apellido: <span class="text-danger">*</span> </label>
                                        <input type="text" name="lastname" required class="form-control form-control-border" id="lastname" placeholder="Apellido del usuario">
                                    </div>
                                    @error('lastname')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="type_document">Tipo de documento: <span class="text-danger">*</span> </label>
                                        <input type="text" name="type_document" required class="form-control form-control-border" id="type_document" placeholder="Tipo de documento del usuario">
                                    </div>
                                    @error('type_document')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="document_number">Número de documento: <span class="text-danger">*</span> </label>
                                        <input type="number" name="document_number" required class="form-control form-control-border" id="document_number" placeholder="Número de documento del usuario">
                                    </div>
                                    @error('document_number')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="note">Nota: <span class="text-danger">*</span> </label>
                                        <input type="text" name="note" required class="form-control form-control-border" id="note" placeholder="nota del usuario">
                                    </div>
                                    @error('note')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="email">Correo eléctronico: <span class="text-danger">*</span> </label>
                                        <input type="email" name="email" required class="form-control form-control-border" id="email" placeholder="Correo eléctronico del usuario">
                                    </div>
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="password">Contraseña: <span class="text-danger">*</span> </label>
                                        <input type="password" name="password" required class="form-control form-control-border" id="password" placeholder="Contraseña del usuario">
                                    </div>
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="state_id">Estados: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" name="state_id" id="state_id">
                                            <option value="">--Seleccionar estado--</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="roles"><span class="text-danger mt-1">* </span> Rol del usuario:</label>
                                        <select class="custom-select form-control-border" name="roles[]" id="roles" multiple>
                                            <option value="" disabled>--Seleccionar Rol--</option>
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('roles')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear usuario</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        @can('admin.users.edit')
            @foreach($users as $user)
                <div class="modal fade" id="modalEditUser_{{$loop->iteration}}"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Usuario</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{route('admin.users.update',$user)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="name"><span class="text-danger mt-1">* </span> Nombres:</label>
                                            <input type="text" class="form-control form-control-border" id="name" name="name" value="{{$user->name}}">
                                        </div>
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="lastname"><span class="text-danger mt-1">* </span> Apellidos:</label>
                                            <input type="text" class="form-control form-control-border" id="lastname" name="lastname" value="{{$user->lastname}}">
                                        </div>
                                        @error('lastname')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="type_document"><span class="text-danger mt-1">* </span> Tipo de documento:</label>
                                            <input type="text" class="form-control form-control-border" id="type_document" name="type_document" value="{{$user->type_document}}">
                                        </div>
                                        @error('type_document')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="document_number"><span class="text-danger mt-1">* </span> Número de documento:</label>
                                            <input type="number" class="form-control form-control-border" id="document_number" name="document_number" value="{{$user->document_number}}">
                                        </div>
                                        @error('document_number')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="note"><span class="text-danger mt-1">* </span> Nota :</label>
                                            <input type="text" class="form-control form-control-border" id="note" name="note" value="{{$user->note}}">
                                        </div>
                                        @error('note')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror


                                        <div class="form-group">
                                            <label for="email"><span class="text-danger mt-1">* </span> Correo eléctronico :</label>
                                            <input type="email" class="form-control form-control-border" id="email" name="email" value="{{$user->email}}">
                                        </div>
                                        @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror


                                        <div class="form-group">
                                            <label for="password">Contraseña del usuario:</label>
                                            <input type="password" class="form-control form-control-border" id="password" name="password" placeholder="Nueva Contraseña del Usuario">
                                        </div>
                                        @error('password')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="state_id"><span class="text-danger mt-1">* </span>  Estado del usuario:</label>
                                            <select class="custom-select form-control-border" name="state_id" id="state_id">
                                                <option >--Seleccionar Estado--</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" {{ $state->id == $user->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('state_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label><span class="text-danger mt-1">* </span>  Rol del usuario:</label>
                                            @foreach($roles as $role)
                                                <div>
                                                    <div class="form-check">

                                                        <input class="form-check-input" name="roles[]" type="checkbox" value="{{$role->id}}" @if(in_array($role->id,$user->roles->pluck('id')->toArray())) checked @endif id="{{$role->name}}">
                                                        <label class="form-check-label" for="{{$role->name}}">
                                                            {{$role->name}}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('roles')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                    <div>
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Editar Usuario</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endcan
    </section>
@endsection
