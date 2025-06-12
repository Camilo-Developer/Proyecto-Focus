@extends('layouts.app2')
@section('title', 'EDICIÓN DEL CONJUNTO')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>EDICIÓN DEL CONJUNTO</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.setresidencials.index')}}">LISTADO DE CONJUNTOS</a></li>
                        <li class="breadcrumb-item active">EDICIÓN DEL CONJUNTO</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    <div class="col-12">
                        <form id="formEditSetResidencial" action="{{route('admin.setresidencials.update',$setresidencial)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                                <div class="d-flex justify-content-end">
                                    <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                                </div>
                                <div class="form-group">
                                    <label for="imagen">IMAGEN:</label>
                                    <input type="file"  name="imagen" value="{{$setresidencial->imagen}}" class="form-control form-control-border" id="imagen">
                                    <small class="form-text text-muted">DEJA ESTE CAMPO VACÍO SI NO DESEA CAMBIAR LA IMAGEN.</small>
                                </div>
                                @error('imagen')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="name">NOMBRE: <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{mb_strtoupper($setresidencial->name)}}" required class="form-control form-control-border" id="name" placeholder="NOMBRE DEL CONJUNTO">
                                </div>
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="address">DIRECCIÓN: <span class="text-danger">*</span></label>
                                    <input type="text" name="address" value="{{mb_strtoupper($setresidencial->address)}}" required class="form-control form-control-border" id="address" placeholder="DIRECCIÓN DEL CONJUNTO">
                                </div>
                                @error('address')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="state_id">ESTADO: <span class="text-danger mt-1">*</span></label>
                                    <select required class="custom-select form-control-border" name="state_id" id="state_id">
                                        <option value="">--SELECCIONAR ESTADO--</option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ $state->id == $setresidencial->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ mb_strtoupper($state->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('state_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="nit">NIT:  </label>
                                    <input type="text" name="nit" value="{{$setresidencial->nit}}"  class="form-control form-control-border" id="nit" placeholder="NIT DEL CONJUNTO">
                                </div>
                                @error('nit')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label>ADMINISTRADORES:</label>
                                    <select id="users" name="users[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                                        @foreach($users as $user)
                                        @php
                                            $roleName = $user->roles->pluck('name')->first() ?? 'Sin Rol';
                                        @endphp
                                            <option value="{{ $user->id }}" data-state="{{ $user->state_id }}" 
                                                {{ in_array($user->id, $users_user) ? 'selected' : '' }}>
                                                {{ mb_strtoupper($user->name) . ' ' .  mb_strtoupper($user->lastname) . ' ( ' . mb_strtoupper($roleName) . ' )'}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('users')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror


                                
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <button type="button" class="btn btn-block mt-4 bg-gradient-warning btn-lg" onclick="confirmEdit()"> EDITAR CONJUNTO</button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <a href="{{route('admin.setresidencials.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#users').select2({
                    placeholder: "-- SELECCIONAR ADMINISTRADOR --",
                    allowClear: true,
                    templateResult: formatOption,
                    templateSelection: formatSelection
                });

                // Función para el diseño de las opciones en el desplegable
                function formatOption(option) {
                    if (!option.id) return option.text; // Opción por defecto "-- SELECCIONAR --"
                    
                    const stateId = $(option.element).data('state'); // Obtener el estado
                    const isActive = stateId === 1;

                    const circle = isActive
                        ? `<span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: green; margin-right: 5px;"></span>`
                        : `<span style="color: red; margin-right: 5px;">✖</span>`; // "X" roja para usuarios inactivos

                    return $(`<span>${circle}${option.text}</span>`);
                }

                // Función para el diseño del texto seleccionado
                function formatSelection(option) {
                    if (!option.id) return option.text; // Texto simple para la selección
                    return option.text;
                }
            });
        </script>
        <script>
            function confirmEdit() {
                const nombreConjunto = document.getElementById(`name`).value;
                Swal.fire({
                    title: `¿ESTÁS SEGURO DE EDITAR EL CONJUTO "${nombreConjunto}"?`,
                    text: "¡NO PODRÁS DESHACER ESTA ACCIÓN!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'SÍ, EDITAR',
                    cancelButtonText: 'NO, CANCELAR'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`formEditSetResidencial`).submit();
                    } else {
                        Swal.fire('CANCELADO', 'NO SE REALIZÓ NINGUNA MODIFICACIÓN.', 'error');
                    }
                });
            }
        </script>
    </section>
@endsection
