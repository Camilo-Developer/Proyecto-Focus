@extends('layouts.app2')
@section('title', 'CREACIÓN DE PORTERIAS')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>CREACIÓN DE PORTERIAS</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.goals.index')}}">LISTA DE PORTERIAS</a></li>
                        <li class="breadcrumb-item active">CREACIÓN DE PORTERIAS</li>
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

                        <form action="{{route('admin.goals.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="d-flex justify-content-end">
                                <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                            </div>
                            
                            <div class="form-group">
                                <label for="name">NOMBRE: <span class="text-danger">*</span> </label>
                                <input type="text" name="name" required class="form-control form-control-border" id="name" placeholder="NOMBRE">
                            </div>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="state_id">ESTADO: <span class="text-danger mt-1">* </span></label>
                                <select class="custom-select form-control-border" name="state_id" id="state_id">
                                    <option value="">--SELECCIONAR--</option>
                                    @foreach($states as $state)
                                        <option value="{{$state->id}}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{mb_strtoupper($state->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('state_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            @if(auth()->user()->hasRole('ADMINISTRADOR'))
                                <div class="form-group">
                                    <label for="setresidencial_id">CONJUNTO: <span class="text-danger mt-1">* </span></label>
                                    <select class="custom-select form-control-border" name="setresidencial_id" id="setresidencial_id">
                                        <option value="">--SELECCIONAR --</option>
                                        @foreach($setresidencials as $setresidencial)
                                            <option value="{{$setresidencial->id}}" {{ old('setresidencial_id') == $setresidencial->id ? 'selected' : '' }}>{{mb_strtoupper($setresidencial->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('setresidencial_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            @else
                                <div class="form-group">
                                    <label for="setresidencial_id">CONJUNTO:</label>
                                    @foreach($setresidencials as $setresidencial)
                                        <input type="text" disabled class="form-control form-control-border" id="setresidencial_id" value="{{ mb_strtoupper($setresidencial->name) }}">
                                        <input type="hidden" name="setresidencial_id"  value="{{ $setresidencial->id }}">
                                    @endforeach
                                </div>
                                @error('setresidencial_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            @endif

                            <div class="form-group">
                                <label for="users">PORTEROS:</label>
                                <select class="custom-select form-control-border" name="users[]" id="users" multiple>
                                    @foreach($users as $user)
                                        @php
                                            $roleName = $user->roles->pluck('name')->first() ?? 'Sin Rol';
                                        @endphp
                                        <option value="{{ $user->id }}" {{ in_array($user->id, old('users', [])) ? 'selected' : '' }}>
                                        {{ mb_strtoupper($user->name) }} {{ mb_strtoupper($user->lastname) }} ({{ mb_strtoupper($roleName) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('users')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror


                            <div class="mx-3">
                                <div class="row">
                                    <div class="col-12 col-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-success btn-lg">CREAR PORTERÍA</button>
                                    </div>
                                    <div class="col-12 col-6">
                                        <a href="{{route('admin.goals.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
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
                $('#setresidencial_id').select2({
                    placeholder: "--SELECCIONAR --",
                    allowClear: true
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#users').select2({
                    placeholder: "--SELECCIONAR --",
                    allowClear: true
                });
            });
        </script>
    </section>


@endsection
