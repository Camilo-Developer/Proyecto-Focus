@extends('layouts.app2')
@section('title', 'Creación de Unidades')
@section('content')
@can('admin.units.create')
          
<section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Creación de Unidades</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Creación de Unidades</li>
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
                            <form action="{{route('admin.units.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                            <input type="text" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre de la unidad">
                                        </div>
                                        @error('name')
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
                                            <label for="agglomeration_id">Aglomeraciones: 
                                                <span class="text-danger mt-1">* </span>
                                            </label>
                                            <select class="form-control" name="agglomeration_id" id="agglomeration_id">
                                                <option value="">--Seleccionar aglomeración--</option>
                                                @foreach($agglomerations as $agglomeration)
                                                    <option value="{{ $agglomeration->id }}" {{ old('agglomeration_id') == $agglomeration->id ? 'selected' : '' }}>
                                                        {{ $agglomeration->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('agglomeration_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror


                                </div>
                                <div class="mx-3">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear unidad</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
    $(document).ready(function() {
        $('#agglomeration_id').select2({
            placeholder: "--Seleccionar aglomeración--",  // Placeholder para el select
            allowClear: true  // Permite limpiar la selección
        });
    });
</script>

        @endcan

@endsection
