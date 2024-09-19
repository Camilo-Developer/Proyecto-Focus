@extends('layouts.app2')
@section('title', 'Creación de las Aglomeraciones')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Creación de las aglomeraciones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Creación de las aglomeraciones</li>
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

                        <form action="{{route('admin.agglomerations.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                                    <div class="d-flex justify-content-end">
                                        <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                    </div>


                                    <div class="form-group">
                                        <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                        <input type="text" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre de la aglomeración">
                                    </div>
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="type_agglomeration">Tipo de aglomeración: <span class="text-danger">*</span></label>
                                        <input type="text" name="type_agglomeration" required class="form-control form-control-border" id="type_agglomeration" placeholder="Tipo de aglomeración">
                                    </div>
                                    @error('type_agglomeration')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror


                                    <div class="form-group">
                                        <label for="setresidencial_id">Conjunto de la aglomeración: 
                                            <span class="text-danger mt-1">* </span>
                                        </label>
                                        <select class="form-control" name="setresidencial_id" id="setresidencial_id">
                                            <option value="">--SELECCIONAR CONJUNTO--</option>
                                            @foreach($setresidencials as $setresidencial)
                                                <option value="{{ $setresidencial->id }}" {{ old('setresidencial_id') == $setresidencial->id ? 'selected' : '' }}>
                                                    {{ strtoupper($setresidencial->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('setresidencial_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror




                                    <div class="form-group">
                                        <label for="state_id">Estado de la aglomeración: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" name="state_id" id="state_id">
                                            <option value="">--Seleccionar Estado--</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                            <div class="mx-3">
                          
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear aglomeración</button>
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
            placeholder: "--SELECCIONAR CONJUNTO--",
            allowClear: true
        });
    });
</script>
    </section>



@endsection
