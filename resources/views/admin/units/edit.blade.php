@extends('layouts.app2')
@section('title', 'EDICIÓN DE UNIDADES')
@section('content')
@can('admin.units.create')
          
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>EDICIÓN DE UNIDADES</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.units.index')}}">LISTADO DE UNIDADES</a></li>
                    <li class="breadcrumb-item active">EDICIÓN DE UNIDADES</li>
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
                            <form action="{{route('admin.units.update',$unit)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="d-flex justify-content-end">
                                    <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                                </div>
                                <div class="form-group">
                                    <label for="name">NOMBRE: <span class="text-danger">*</span> </label>
                                    <input type="text" name="name" value="{{mb_strtoupper($unit->name)}}" required class="form-control form-control-border" id="name" placeholder="NOMBRE DE LA UNIDAD">
                                </div>
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="agglomeration_id">AGLOMERACIONES: 
                                        <span class="text-danger mt-1">*</span>
                                    </label>
                                    <select class="form-control" name="agglomeration_id" id="agglomeration_id">
                                        <option value="">-- SELECCIONAR AGLOMERACIÓN --</option>
                                        @foreach($agglomerations as $agglomeration)
                                            <option value="{{ $agglomeration->id }}" 
                                                data-state="{{ $agglomeration->state_id }}"
                                                {{ $agglomeration->id == $unit->agglomeration_id ? 'selected' : '' }} 
                                                {{ old('agglomeration_id') == $agglomeration->id ? 'selected' : '' }}>
                                                {{ mb_strtoupper($agglomeration->name) . ' - (' . mb_strtoupper($agglomeration->setresidencial->name) . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('agglomeration_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="state_id">ESTADO: <span class="text-danger mt-1">* </span></label>
                                    <select class="custom-select form-control-border" name="state_id" id="state_id">
                                        <option value="">-- SELECCIONAR ESTADO --</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" {{ $state->id == $unit->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{mb_strtoupper($state->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('state_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror


                                <div class="form-group">
                                    <label for="visitors">VISITANTES:</label>
                                    <select id="visitors" name="visitors[]" multiple class="form-control select2" style="width: 100%;">
                                        @foreach($visitors as $visitor)
                                            <option value="{{ $visitor->id }}" data-state="{{ $visitor->state_id }}"
                                                {{ in_array($visitor->id, $visitors_user) ? 'selected' : '' }}>
                                                {{ mb_strtoupper($visitor->document_number) . ' - (' . mb_strtoupper($visitor->name) . ')' . ' - (' . mb_strtoupper($visitor->typeuser->name) . ')' . ' - (' . mb_strtoupper($visitor->setresidencial->name) . ')'}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('visitors')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                               

                                <div class="form-group">
                                    <label for="vehicles">VEHICULOS:</label>
                                    <select id="vehicles" name="vehicles[]" multiple class="form-control select2" style="width: 100%;">
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" data-state="{{ $vehicle->state_id }}"
                                                {{ in_array($vehicle->id, $vehicles_user) ? 'selected' : '' }}>
                                                {{ mb_strtoupper($vehicle->placa)  . ' - (' . mb_strtoupper($vehicle->setresidencial->name) . ')'}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('vehicles')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-warning btn-lg">EDITAR UNIDAD</button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <a href="{{route('admin.units.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#agglomeration_id').select2({
                    placeholder: "-- SELECCIONAR AGLOMERACIÓN --",
                    allowClear: true,
                    templateResult: formatOption,
                    templateSelection: formatSelection
                });

                // Formatear las opciones del select
                function formatOption(option) {
                    if (!option.id) return option.text; // Para el placeholder

                    const stateId = $(option.element).data('state'); // Obtener el estado
                    const isActive = stateId == 1;

                    const circle = isActive
                        ? `<span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: green; margin-right: 5px;"></span>`
                        : `<span style="color: red; margin-right: 5px;">✖</span>`;

                    return $(`<span>${circle}${option.text}</span>`);
                }

                // Formatear la selección del select
                function formatSelection(option) {
                    if (!option.id) return option.text; // Para el texto seleccionado
                    return option.text;
                }
            });
        </script>


        <script>
            $(document).ready(function () {
                $('#visitors').select2({
                    placeholder: "-- SELECCIONAR --",
                    allowClear: true,
                    templateResult: formatOption,
                    templateSelection: formatSelection
                });

                // Formatear las opciones del select
                function formatOption(option) {
                    if (!option.id) return option.text; // Para el placeholder

                    const stateId = $(option.element).data('state'); // Obtener el estado
                    const isActive = stateId == 1;

                    const circle = isActive
                        ? `<span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: green; margin-right: 5px;"></span>`
                        : `<span style="color: red; margin-right: 5px;">✖</span>`;

                    return $(`<span>${circle}${option.text}</span>`);
                }

                // Formatear la selección del select
                function formatSelection(option) {
                    if (!option.id) return option.text; // Para el texto seleccionado
                    return option.text;
                }
            });
        </script>

        <script>
            $(document).ready(function () {
                $('#vehicles').select2({
                    placeholder: "-- SELECCIONAR --",
                    allowClear: true,
                    templateResult: formatOption,
                    templateSelection: formatSelection
                });

                // Formatear las opciones del select
                function formatOption(option) {
                    if (!option.id) return option.text; // Para el placeholder

                    const stateId = $(option.element).data('state'); // Obtener el estado
                    const isActive = stateId == 1;

                    const circle = isActive
                        ? `<span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: green; margin-right: 5px;"></span>`
                        : `<span style="color: red; margin-right: 5px;">✖</span>`;

                    return $(`<span>${circle}${option.text}</span>`);
                }

                // Formatear la selección del select
                function formatSelection(option) {
                    if (!option.id) return option.text; // Para el texto seleccionado
                    return option.text;
                }
            });
        </script>
        @endcan

@endsection
