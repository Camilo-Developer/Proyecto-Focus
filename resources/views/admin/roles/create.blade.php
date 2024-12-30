@extends('layouts.app2')
@section('title', 'CREACIÓN DEL ROL')
@section('content')
    <!--Migas de pan-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>CREACIÓN DEL ROL</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.roles.index')}}">LISTADO DE ROLES</a></li>
                        <li class="breadcrumb-item active">CREACIÓN DEL ROL</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!--Contenido- Formulario-->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    <div class="col-12">
                        <form action="{{route('admin.roles.store')}}" method="post">
                            @csrf
                            @method('Post')
                            <div class="form-group">
                                <label for="name_rol"><span class="text-danger">*</span> NOMBRE DEL ROL:</label>
                                <input type="text" class="form-control form-control-border" id="name_rol" name="name" placeholder="NOMBRE DEL ROL">
                            </div>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <h4><span class="text-danger">*</span> LISTADO DE PERMISOS:</h4>
                            <label><span class="text-danger">*</span> SELECCIONE LOS PERMISOS QUE LE OTORGARÁ A SU ROL:</label>
                            @foreach($permissions as $permission)
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permissions[]" type="checkbox" value="{{$permission->id}}" id="{{$permission->description}}">
                                        <label class="form-check-label" for="{{$permission->description}}">
                                            {{$permission->description}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            @error('permissions')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <button type="submit" class="btn btn-block mt-4 bg-gradient-success btn-lg">CREAR ROL</button>
                                </div>
                                <div class="col-12 col-md-6">
                                    <a href="{{route('admin.roles.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
