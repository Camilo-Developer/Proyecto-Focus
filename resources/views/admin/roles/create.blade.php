@extends('layouts.app2')
@section('title', 'Creación de roles')
@section('content')
    <!--Migas de pan-->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nuevo Rol</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Nuevo Rol</li>
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
                                <label for="name_rol">Nombre de su Rol:</label>
                                <input type="text" class="form-control form-control-border" id="name_rol" name="name" placeholder="Nombre de su Producto">
                            </div>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <h4>Listado de permisos actuales:</h4>
                            <label>Seleccione los permisos que le quiere dar a su rol:</label>
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
                            <button type="submit" class="btn btn-block bg-gradient-success btn-lg">Crear Producto</button>
                            <a href="{{route('admin.roles.index')}}" class="btn btn-block bg-gradient-danger btn-lg">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
