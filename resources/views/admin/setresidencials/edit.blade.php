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
                                    <input type="file" name="imagen" value="{{$setresidencial->imagen}}" class="form-control form-control-border" id="imagen">
                                    <small class="form-text text-muted">DEJA ESTE CAMPO VACÍO SI NO DESEA CAMBIAR LA IMAGEN.</small>
                                </div>
                                @error('imagen')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="name"><span class="text-danger">*</span> NOMBRE:</label>
                                    <input type="text" name="name" value="{{strtoupper($setresidencial->name)}}" required class="form-control form-control-border" id="name" placeholder="NOMBRE DEL CONJUNTO">
                                </div>
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="address"><span class="text-danger">*</span> DIRECCIÓN:</label>
                                    <input type="text" name="address" value="{{strtoupper($setresidencial->address)}}" required class="form-control form-control-border" id="address" placeholder="DIRECCIÓN DEL CONJUNTO">
                                </div>
                                @error('address')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="nit">NIT:  </label>
                                    <input type="text" name="nit" value="{{$setresidencial->nit}}"  class="form-control form-control-border" id="nit" placeholder="NIT DEL CONJUNTO">
                                </div>
                                @error('nit')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="user_id">USUARIO RESPONSABLE:</label>
                                    <select class="custom-select form-control-border" name="user_id" id="user_id">
                                        <option value="">--SELECCIONAR USUARIO--</option>
                                        @foreach($users as $user)
                                        @php
                                            $roleName = $user->roles->pluck('name')->first() ?? 'Sin Rol';
                                        @endphp
                                        <option value="{{ $user->id }}" {{ $user->id == $setresidencial->user_id ? 'selected' : '' }} {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ strtoupper($user->name) }} {{ strtoupper($user->lastname) }} ({{ strtoupper($roleName) }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('user_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror


                                <div class="form-group">
                                    <label for="state_id">ESTADO DEL CONJUNTO: <span class="text-danger mt-1">*</span></label>
                                    <select class="custom-select form-control-border" name="state_id" id="state_id">
                                        <option value="">--SELECCIONAR ESTADO--</option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ $state->id == $setresidencial->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ strtoupper($state->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('state_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-block mt-4 bg-gradient-warning btn-lg" onclick="confirmEdit()"> EDITAR CONJUNTO</button>
                                    </div>
                                    <div class="col-6">
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
                $('#user_id').select2({
                    placeholder: "--SELECCIONAR USUARIO--",
                    allowClear: true
                });
            });
        </script>
        <script>
                function confirmEdit() {
                    const nombreConjunto = document.getElementById(`name`).value;
                    Swal.fire({
                        title: `¿Estás seguro de editar el conjunto "${nombreConjunto}"?`,
                        text: "¡No podrás deshacer esta acción!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, editar',
                        cancelButtonText: 'No, cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`formEditSetResidencial`).submit();
                        } else {
                            Swal.fire('Cancelado', 'No se realizó ninguna modificación.', 'error');
                        }
                    });
                }
            </script>
    </section>
@endsection
