@extends('layouts.app2')
@section('title', 'EDICIÓN DE EMPRESAS')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>EDICIÓN DE EMPRESAS</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.companies.index')}}">LISTA DE EMPRESAS</a></li>
                        <li class="breadcrumb-item active">EDICIÓN DE EMPRESAS</li>
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

                        <form action="{{route('admin.companies.update',$company)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex justify-content-end">
                                <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                            </div>
                            
                            <div class="form-group">
                                <label for="name">NOMBRE: <span class="text-danger">*</span> </label>
                                <input type="text" value="{{mb_strtoupper($company->name)}}" name="name" required class="form-control form-control-border" id="name" placeholder="NOMBRE">
                            </div>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="mx-3">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-warning btn-lg">EDITAR EMPRESA</button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <a href="{{route('admin.companies.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
