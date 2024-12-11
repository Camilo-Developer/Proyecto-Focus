@extends('layouts.app2')
@section('title', 'CREACIÓN DEL USUARIO')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>CREACIÓN DEL USUARIO</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">LISTA DEL USUARIO</a></li>
                        <li class="breadcrumb-item active">CREACIÓN DEL USUARIO</li>
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

                            <form action="{{route('admin.users.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="d-flex justify-content-end">
                                    <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                                </div>
                                <div class="form-group">
                                        <label for="name"><span class="text-danger mt-1">* </span> NOMBRES:</label>
                                        <input type="text" class="form-control form-control-border" id="name" name="name" >
                                    </div>
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="lastname"><span class="text-danger mt-1">* </span> APELLIDOS:</label>
                                        <input type="text" class="form-control form-control-border" id="lastname" name="lastname" >
                                    </div>
                                    @error('lastname')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="type_document"><span class="text-danger mt-1">* </span>TIPO DE DOCUMENTO:</label>
                                        <select class="form-control form-control-border text-uppercase" id="type_document" name="type_document" required>
                                            <option value="" selected disabled>SELECCIONE</option>
                                            <option value="CC">CÉDULA DE CIUDADANÍA (CC)</option>
                                            <option value="CE">CÉDULA DE EXTRANJERÍA (CE)</option>
                                            <option value="TI">TARJETA DE IDENTIDAD (TI)</option>
                                            <option value="RC">REGISTRO CIVIL (RC)</option>
                                            <option value="PA">PASAPORTE (PA)</option>
                                            <option value="PEP">PERMISO ESPECIAL DE PERMANENCIA (PEP)</option>
                                            <option value="NIT">NÚMERO DE IDENTIFICACIÓN TRIBUTARIA (NIT)</option>
                                            <option value="DNI">DOCUMENTO NACIONAL DE IDENTIDAD (DNI)</option>
                                        </select>
                                    </div>
                                    @error('type_document')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror



                                    <div class="form-group">
                                        <label for="document_number"><span class="text-danger mt-1">* </span> NÚMERO DE DOCUMENTO:</label>
                                        <input type="number" class="form-control form-control-border" id="document_number" name="document_number" >
                                    </div>
                                    @error('document_number')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror



                                    <div class="form-group">
                                        <label for="email"><span class="text-danger mt-1">* </span> CORREO ELECTRÓNICO:</label>
                                        <input type="email" class="form-control form-control-border" id="email" name="email" >
                                    </div>
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror


                                    <div class="form-group">
                                        <label for="password">CONTRASEÑA:</label>
                                        <input type="password" class="form-control form-control-border" id="password" name="password" placeholder="CONTRASEÑA">
                                    </div>
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                            <label for="state_id">ESTADOS: <span class="text-danger mt-1">* </span></label>
                                            <select class="custom-select form-control-border" name="state_id" id="state_id">
                                                <option value="">-- SELECCIONAR --</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('state_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="roles"><span class="text-danger mt-1">* </span> ROL:</label>
                                            <select class="custom-select form-control-border" name="roles[]" id="roles" multiple>
                                                <option value="" disabled>-- SELECCIONAR --</option>
                                                @foreach($roles as $role)
                                                    <option value="{{$role->id}}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('roles')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror


                                        <div class="form-group">
                                            <label for="goals">PORTERÍAS:</label>
                                            <select class="custom-select form-control-border" name="goals[]" id="goals" multiple>
                                                @foreach($goals as $goal)
                                                    <option value="{{ $goal->id }}" {{ in_array($goal->id, old('goals', [])) ? 'selected' : '' }}>
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
                                            <button type="submit" class="btn btn-block mt-4 bg-gradient-success btn-lg">CREAR USUARIO</button>
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
