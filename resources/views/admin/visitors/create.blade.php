@extends('layouts.app2')
@section('title', 'CREACIÓN DE VISITANTES')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>CREACIÓN DE VISITANTES</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.visitors.index')}}">LISTA DE VISITANTES</a></li>
                        <li class="breadcrumb-item active">CREACIÓN DE VISITANTES</li>
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

                        <form action="{{route('admin.visitors.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="d-flex justify-content-end">
                                <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                            </div>

                            <div class="form-group">
                                <label for="imagen">IMAGEN: <span class="text-danger mt-1">* </span></label>
                                <input type="file" name="imagen" required class="form-control form-control-border" id="imagen">
                            </div>
                            @error('imagen')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            
                            <div class="form-group">
                                <label for="name">NOMBRE: <span class="text-danger">*</span> </label>
                                <input type="text" name="name" required class="form-control form-control-border" id="name" placeholder="NOMBRE">
                            </div>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="phone">TELÉFONO: <span class="text-danger">*</span> </label>
                                <input type="number" name="phone" required class="form-control form-control-border" id="phone" placeholder="TELÉFONO">
                            </div>
                            @error('phone')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="address">DIRECCIÓN: <span class="text-danger">*</span> </label>
                                <input type="text" name="address" required class="form-control form-control-border" id="address" placeholder="DIRECCIÓN">
                            </div>
                            @error('address')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="document_number">NÚMERO DE DOCUMENTO: <span class="text-danger">*</span> </label>
                                <input type="number" name="document_number" required class="form-control form-control-border" id="document_number" placeholder="NÚMERO DE DOCUMENTO">
                            </div>
                            @error('document_number')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="confirmation">CONFIRMACIÓN: <span class="text-danger mt-1">* </span></label>
                                <select class="custom-select form-control-border" name="confirmation" id="confirmation">
                                    <option value="">--SELECCIONAR--</option>
                                    <option value="1">SI</option>
                                    <option value="2">NO</option>
                                </select>
                            </div>
                            @error('confirmation')
                            <span class="text-danger">{{$message}}</span>
                            @enderror


                            <div class="form-group">
                                <label for="state_id">ESTADO: <span class="text-danger mt-1">* </span></label>
                                <select class="custom-select form-control-border" name="state_id" id="state_id">
                                    <option value="">--SELECCIONAR--</option>
                                    @foreach($states as $state)
                                        <option value="{{$state->id}}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{strtoupper($state->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('state_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="type_user_id">TIPO DE USUARIO: <span class="text-danger mt-1">* </span></label>
                                <select class="custom-select form-control-border" name="type_user_id" id="type_user_id">
                                    <option value="">--SELECCIONAR --</option>
                                    @foreach($typeusers as $typeuser)
                                        <option value="{{$typeuser->id}}" {{ old('type_user_id') == $typeuser->id ? 'selected' : '' }}>{{strtoupper($typeuser->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('type_user_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="company_id">EMPRESA:</label>
                                <select class="custom-select form-control-border" name="company_id" id="company_id">
                                    <option value="">--SELECCIONAR --</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}" {{ old('company_id') == $company->id ? 'selected' : '' }}>{{strtoupper($company->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('company_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="mx-3">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-success btn-lg">CREAR VISITANTE</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.visitors.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
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
                $('#type_user_id').select2({
                    placeholder: "--SELECCIONAR --",
                    allowClear: true
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#company_id').select2({
                    placeholder: "--SELECCIONAR --",
                    allowClear: true
                });
            });
        </script>
    </section>


@endsection
