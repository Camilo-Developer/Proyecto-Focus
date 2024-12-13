@extends('layouts.app2')
@section('title', 'CREACIÓN DE UNIDADES')
@section('content')
@can('admin.units.create')
          
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>CREACIÓN DE UNIDADES</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.units.index')}}">LISTADO DE UNIDADES</a></li>
                    <li class="breadcrumb-item active">CREACIÓN DE UNIDADES</li>
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
                                    <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                                </div>
                                <div class="form-group">
                                    <label for="name">NOMBRE: <span class="text-danger">*</span> </label>
                                    <input type="text" name="name" required class="form-control form-control-border" id="name" placeholder="NOMBRE DE LA UNIDAD">
                                </div>
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="agglomeration_id">AGLOMERACIONES: 
                                        <span class="text-danger mt-1">* </span>
                                    </label>
                                    <select class="form-control" name="agglomeration_id" id="agglomeration_id">
                                        <option value="">-- SELECCIONAR --</option>
                                        @foreach($agglomerations as $agglomeration)
                                            <option value="{{ $agglomeration->id }}" {{ old('agglomeration_id') == $agglomeration->id ? 'selected' : '' }}>
                                                {{ strtoupper($agglomeration->name) }}
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
                                        <option value="">-- SELECCIONAR --</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{strtoupper($state->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('state_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                                
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-success btn-lg">CREAR UNIDAD</button>
                                    </div>
                                    <div class="col-6">
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
    $(document).ready(function() {
        $('#agglomeration_id').select2({
            placeholder: "--SELECCIONAR--",  // Placeholder para el select
            allowClear: true  // Permite limpiar la selección
        });
    });
</script>

        @endcan

@endsection