@extends('layouts.app2')
@section('title', 'CREACIÓN DE VEHICULOS')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>CREACIÓN DE VEHICULOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.vehicles.index')}}">LISTADO DE VEHICULOS</a></li>
                    <li class="breadcrumb-item active">CREACIÓN DE VEHICULOS</li>
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
                            <form action="{{route('admin.vehicles.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="d-flex justify-content-end">
                                    <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                                </div>
                                <div class="form-group">
                                    <label for="placa">PLACA: <span class="text-danger">*</span> </label>
                                    <input type="text" name="placa" required class="form-control form-control-border" id="placa">
                                </div>
                                @error('placa')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                @if(auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('SUB_ADMINISTRADOR'))
                                    <div class="form-group">
                                        <label for="state_id">ESTADO: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" required name="state_id" id="state_id">
                                            <option value="">-- SELECCIONAR --</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{mb_strtoupper($state->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                @elseif(auth()->user()->hasRole('PORTERO'))
                                    <div class="form-group">
                                        <label for="state_id">ESTADO: <span class="text-danger mt-1">* </span></label>
                                        <input type="text" disabled class="form-control form-control-border" id="state_id" value="ACTIVO">
                                        <input type="hidden" name="state_id" value="1">
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                @endif


                                @if(auth()->user()->hasRole('ADMINISTRADOR'))
                                    <div class="form-group">
                                        <label for="setresidencial_id">CONJUNTO: <span class="text-danger">*</span></label>
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
                                        <label for="setresidencial_id">CONJUNTO: <span class="text-danger">*</span></label>
                                            <input type="text" disabled class="form-control form-control-border" id="setresidencial_id" value="{{ mb_strtoupper($setresidencial->name) }}">
                                            <input type="hidden" name="setresidencial_id"  value="{{ $setresidencial->id }}">
                                    </div>
                                    @error('setresidencial_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @endif

                                <div class="form-group">
                                    <label for="units">UNIDADES: 
                                    </label>
                                    <select class="form-control" name="units[]" id="units" multiple>
                                        <option value="">-- SELECCIONAR --</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('units') == $unit->id ? 'selected' : '' }}>
                                                {{ mb_strtoupper($unit->name) . ' - (' . mb_strtoupper($unit->agglomeration->setresidencial->name) . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('units')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="visitors">VISITANTES: 
                                    </label>
                                    <select class="form-control" name="visitors[]" id="visitors" multiple>
                                        <option value="">-- SELECCIONAR --</option>
                                        @foreach($visitors as $visitor)
                                            <option value="{{ $visitor->id }}" {{ old('visitors') == $visitor->id ? 'selected' : '' }}>
                                            {{mb_strtoupper($visitor->document_number) . ' - ' .  mb_strtoupper($visitor->name) . ' - (' .  mb_strtoupper($visitor->typeuser->name) .')' . ' (' .  mb_strtoupper($visitor->setresidencial->name) .')'}}

                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('visitors')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-success btn-lg">CREAR VEHICULO</button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <a href="{{route('admin.vehicles.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
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
                $('#units').select2({
                    placeholder: "--SELECCIONAR--",  // Placeholder para el select
                    allowClear: true  // Permite limpiar la selección
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#setresidencial_id').select2({
                    placeholder: "--SELECCIONAR--",  // Placeholder para el select
                    allowClear: true  // Permite limpiar la selección
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#visitors').select2({
                    placeholder: "--SELECCIONAR--",  // Placeholder para el select
                    allowClear: true  // Permite limpiar la selección
                });
            });
        </script>
@endsection
