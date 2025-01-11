@extends('layouts.app2')
@section('title', 'EDICIÓN DE VEHICULOS')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>EDICIÓN DE VEHICULOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.vehicles.index')}}">LISTADO DE VEHICULOS</a></li>
                    <li class="breadcrumb-item active">EDICIÓN DE VEHICULOS</li>
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
                            <form action="{{route('admin.vehicles.update',$vehicle)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="d-flex justify-content-end">
                                    <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                                </div>
                                <div class="form-group">
                                    <label for="placa">PLACA: <span class="text-danger">*</span> </label>
                                    <input type="text" value="{{$vehicle->placa}}" name="placa" required class="form-control form-control-border" id="placa">
                                </div>
                                @error('placa')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="state_id"><span class="text-danger mt-1">* </span> ESTADO:</label>
                                    <select class="custom-select form-control-border" name="state_id" id="state_id">
                                        <option>--SELECCIONAR --</option>
                                        @foreach($states as $state)
                                        <option value="{{$state->id}}" {{ $state->id == $vehicle->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{mb_strtoupper($state->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('state_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label>UNIDADES:</label>
                                    <select id="units" name="units[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" data-state="{{ $unit->state_id }}"
                                                {{ in_array($unit->id, $units_vehicles) ? 'selected' : '' }}>
                                                {{ mb_strtoupper($unit->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('units')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div class="form-group">
                                    <label>VISITANTES:</label>
                                    <select id="visitors" name="visitors[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                                        @foreach($visitors as $visitor)
                                            <option value="{{ $visitor->id }}" data-state="{{ $visitor->state_id }}"
                                                {{ in_array($visitor->id, $visitors_vehicles) ? 'selected' : '' }}>
                                                {{ mb_strtoupper($visitor->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('visitors')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-warning btn-lg">EDITAR VEHICULO</button>
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
                $('#visitors').select2({
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
@endsection
