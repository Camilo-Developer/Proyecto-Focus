@extends('layouts.app2')
@section('title', 'EDICIÓN DEL USUARIO')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>EDICIÓN DEL USUARIO</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">LISTA DEL USUARIO</a></li>
                        <li class="breadcrumb-item active">EDICIÓN DEL USUARIO</li>
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
                    <div class="col-12">

                        <form action="{{route('admin.users.update',$user)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex justify-content-end">
                                <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                            </div>

                            <div class="form-group">
                                <label for="name"><span class="text-danger mt-1">* </span> NOMBRES:</label>
                                <input type="text" class="form-control form-control-border" id="name" name="name" value="{{$user->name}}">
                            </div>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="lastname"><span class="text-danger mt-1">* </span> APELLIDOS:</label>
                                <input type="text" class="form-control form-control-border" id="lastname" name="lastname" value="{{$user->lastname}}">
                            </div>
                            @error('lastname')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="type_document"><span class="text-danger mt-1">* </span>TIPO DE DOCUMENTO:</label>
                                <select class="form-control form-control-border" id="type_document" name="type_document" required>
                                    <option value="" disabled {{ empty($user->type_document) ? 'selected' : '' }}>SELECCIONE EL TIPO DE DOCUMENTO</option>
                                    <option value="CC" {{ $user->type_document == 'CC' ? 'selected' : '' }}>CÉDULA DE CIUDADANÍA (CC)</option>
                                    <option value="CE" {{ $user->type_document == 'CE' ? 'selected' : '' }}>CÉDULA DE EXTRANJERÍA (CE)</option>
                                    <option value="TI" {{ $user->type_document == 'TI' ? 'selected' : '' }}>TARJETA DE IDENTIDAD (TI)</option>
                                    <option value="RC" {{ $user->type_document == 'RC' ? 'selected' : '' }}>REGISTRO CIVIL (RC)</option>
                                    <option value="PA" {{ $user->type_document == 'PA' ? 'selected' : '' }}>PASAPORTE (PA)</option>
                                    <option value="PEP" {{ $user->type_document == 'PEP' ? 'selected' : '' }}>PERMISO ESPECIAL DE PERMANENCIA (PEP)</option>
                                    <option value="NIT" {{ $user->type_document == 'NIT' ? 'selected' : '' }}>NÚMERO DE IDENTIFICACIÓN TRIBUTARIA (NIT)</option>
                                    <option value="DNI" {{ $user->type_document == 'DNI' ? 'selected' : '' }}>DOCUMENTO NACIONAL DE IDENTIDAD (DNI)</option>
                                </select>
                            </div>
                            @error('type_document')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="document_number"><span class="text-danger mt-1">* </span> NÚMERO DE DOCUMENTO:</label>
                                <input type="number" class="form-control form-control-border" id="document_number" name="document_number" value="{{$user->document_number}}">
                            </div>
                            @error('document_number')
                            <span class="text-danger">{{$message}}</span>
                            @enderror


                            <div class="form-group">
                                <label for="email"><span class="text-danger mt-1">* </span> CORREO ELECTRÓNICO:</label>
                                <input type="email" class="form-control form-control-border" id="email" name="email" value="{{$user->email}}">
                            </div>
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="password">CONTRASEÑA:</label>
                                <input type="password" class="form-control form-control-border" id="password" name="password" placeholder="NUEVA CONTRASEÑA DEL USUARIO">
                                <small class="form-text text-muted">DEJA ESTE CAMPO VACÍO SI NO DESEA CAMBIAR LA CONTRASEÑA.</small>

                            </div>
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="state_id"><span class="text-danger mt-1">* </span> ESTADO:</label>
                                <select class="custom-select form-control-border" name="state_id" id="state_id">
                                    <option>--SELECCIONAR ESTADO--</option>
                                    @foreach($states as $state)
                                    <option value="{{$state->id}}" {{ $state->id == $user->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('state_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label><span class="text-danger mt-1">* </span> ROL :</label>
                                <select id="roles" name="roles[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                                    <option value="" disabled>-- SELECCIONAR --</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" 
                                            @if(in_array($role->id, $user->roles->pluck('id')->toArray())) 
                                                selected 
                                            @endif>
                                            {{$role->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('roles')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label>PORTERIAS:</label>
                                <select id="goals" name="goals[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                                    <option value="" disabled>-- SELECCIONAR --</option>
                                    @foreach($goals as $goal)
                                        <option value="{{ $goal->id }}" 
                                            {{ in_array($goal->id, $goals_user) ? 'selected' : '' }}>
                                            {{ $goal->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('goals')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror



                            <div class="mx-3">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-warning btn-lg">EDITAR USUARIO</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.users.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#type_document').select2({
                    placeholder: "-- SELECCIONAR --",
                    allowClear: true
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#roles').select2({
                    placeholder: "-- SELECCIONAR --",
                    allowClear: true
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#goals').select2({
                    placeholder: "-- SELECCIONAR --",
                    allowClear: true
                });
            });
        </script>
    </section>


@endsection
