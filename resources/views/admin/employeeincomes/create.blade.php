@extends('layouts.app2')
@section('title', 'CREACIÓN DE INGRESOS')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>CREACIÓN DE INGRESOS</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.employeeincomes.index')}}">LISTA DE INGRESOS</a></li>
                        <li class="breadcrumb-item active">CREACIÓN DE INGRESOS</li>
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

                        <form action="{{route('admin.employeeincomes.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="d-flex justify-content-end">
                                <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                            </div>
                            <div class="form-group">
                                <label for="visitor_id">VISITANTE: <span class="text-danger mt-1">* </span></label>
                                <select class="custom-select form-control-border" require name="visitor_id" id="visitor_id">
                                    <option value="">--SELECCIONAR--</option>
                                    @foreach($visitors as $visitor)
                                        <option value="{{$visitor->id}}" {{ old('visitor_id') == $visitor->id ? 'selected' : '' }}>{{mb_strtoupper($visitor->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('visitor_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            
                            <div class="form-group">
                                <label for="admission_date">FECHA INGRESO: <span class="text-danger">*</span> </label>
                                <input type="date" name="admission_date" required class="form-control form-control-border" id="admission_date">
                            </div>
                            @error('admission_date')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="departure_date">FECHA SALIDA:  </label>
                                <input type="date" name="departure_date"  class="form-control form-control-border" id="departure_date">
                            </div>
                            @error('departure_date')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="nota">Nota:  </label>
                                <br>
                                <textarea name="nota" id="nota" cols="30" rows="10"></textarea>
                            </div>
                            @error('nota')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="mx-3">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-success btn-lg">CREAR INGRESO</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.employeeincomes.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
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
                $('#visitor_id').select2({
                    placeholder: "--SELECCIONAR --",
                    allowClear: true
                });
            });
        </script>
        <script>
            $('#nota').summernote({
                placeholder: 'NOTA',
                tabsize: 2,
                height: 100
            });
        </script>
    </section>


@endsection
