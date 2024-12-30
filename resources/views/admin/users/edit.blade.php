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
                                <input type="text" class="form-control form-control-border" id="name" name="name" value="{{mb_strtoupper($user->name)}}">
                            </div>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="lastname"><span class="text-danger mt-1">* </span> APELLIDOS:</label>
                                <input type="text" class="form-control form-control-border" id="lastname" name="lastname" value="{{mb_strtoupper($user->lastname)}}">
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
                                <input type="email" class="form-control form-control-border" id="email" name="email" value="{{mb_strtoupper($user->email)}}">
                            </div>
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="password">CONTRASEÑA:</label>
                                <input type="password" class="form-control form-control-border" id="password" name="password" placeholder="NUEVA CONTRASEÑA DEL USUARIO">
                                <small class="form-text text-muted">DEJE ESTE CAMPO VACÍO SI NO DESEA CAMBIAR LA CONTRASEÑA.</small>

                            </div>
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="state_id"><span class="text-danger mt-1">* </span> ESTADO:</label>
                                <select class="custom-select form-control-border" name="state_id" id="state_id">
                                    <option>--SELECCIONAR ESTADO--</option>
                                    @foreach($states as $state)
                                    <option value="{{$state->id}}" {{ $state->id == $user->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{mb_strtoupper($state->name)}}</option>
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
                                            {{mb_strtoupper($role->name)}}
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
                                    @foreach($goals as $goal)
                                        <option value="{{ $goal->id }}" data-state="{{ $goal->state_id }}"
                                            {{ in_array($goal->id, $goals_user) ? 'selected' : '' }}>
                                            {{ mb_strtoupper($goal->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('goals')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror


                            @if(auth()->user()->hasRole('ADMINISTRADOR'))

                                <div class="form-group">
                                    <label for="setresidencials">CONJUNTOS:</label>
                                    <select id="setresidencials" name="setresidencials[]" class="form-control select2" style="width: 100%;">
                                        <option value="" disabled {{ empty($setresidencials_user) ? 'selected' : '' }}>-- SELECCIONAR --</option>
                                        @foreach($setresidencials as $setresidencial)
                                            <option value="{{ $setresidencial->id }}" data-state="{{ $setresidencial->state_id }}"
                                                {{ in_array($setresidencial->id, $setresidencials_user) ? 'selected' : '' }}>
                                                {{ mb_strtoupper($setresidencial->name) }}
                                                @php
                                                    $usersWithRole = $setresidencial->users->filter(fn($user) => $user->hasRole(2));
                                                @endphp
                                                @if($usersWithRole->isNotEmpty())
                                                    - {{ $usersWithRole->map(fn($user) => '( ' . mb_strtoupper($user->name) . ' ' . mb_strtoupper($user->lastname ?? '') . ' )')->join(', ') }}
                                                @else
                                                    - SIN USUARIOS
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('setresidencials')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            @else
                                <div class="form-group">
                                    <label for="setresidencials">CONJUNTO:</label>
                                    @foreach($setresidencials as $setresidencial)
                                        <input type="text" disabled class="form-control form-control-border" id="setresidencials" value="{{ mb_strtoupper($setresidencial->name) }}">
                                        <input type="hidden" name="setresidencials[]"  value="{{ $setresidencial->id }}">
                                    @endforeach
                                </div>
                                @error('setresidencials')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            @endif

                            <div class="mx-3">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-warning btn-lg">EDITAR USUARIO</button>
                                    </div>
                                    <div class="col-12 col-md-6">
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
                    allowClear: true,
                    templateResult: formatOption,
                    templateSelection: formatSelection
                });

                function formatOption(option) {
                    if (!option.id) return option.text; // Para la opción por defecto "-- SELECCIONAR --"
                    const stateId = $(option.element).data('state');
                    const isActive = stateId === 1;

                    const circle = isActive
                        ? `<span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: green; margin-right: 5px;"></span>`
                        : `<span style="color: red; margin-right: 5px;">✖</span>`;

                    return $(`<span>${circle}${option.text}</span>`);
                }

                function formatSelection(option) {
                    if (!option.id) return option.text; // Para mantener el texto seleccionado limpio
                    return option.text;
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#setresidencials').select2({
                    placeholder: "-- SELECCIONAR --",
                    allowClear: true,
                    templateResult: formatOption,
                    templateSelection: formatSelection
                });

                // Función para el diseño de opciones en el desplegable
                function formatOption(option) {
                    if (!option.id) return option.text; // Opción por defecto "-- SELECCIONAR --"
                    
                    const stateId = $(option.element).data('state'); // Obtener el estado
                    const isActive = stateId === 1;

                    const circle = isActive
                        ? `<span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: green; margin-right: 5px;"></span>`
                        : `<span style="color: red; margin-right: 5px;">✖</span>`;

                    return $(`<span>${circle}${option.text}</span>`);
                }

                // Función para el diseño del texto seleccionado
                function formatSelection(option) {
                    if (!option.id) return option.text; // Texto simple para la selección
                    return option.text;
                }
            });
        </script>
    </section>


@endsection
