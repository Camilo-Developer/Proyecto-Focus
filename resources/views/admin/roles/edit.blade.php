@extends('layouts.app2')
@section('title', 'EDICIÓN DEL ROL')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>EDICIÓN DEL ROL</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.roles.index')}}">LISTADO DE ROLES</a></li>
                        <li class="breadcrumb-item active">EDICIÓN DEL ROL</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    <div class="col-12">
                        <form action="{{route('admin.roles.update',$role)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nombre-role"><span class="text-danger">*</span> NOMBRE DEL ROL:</label>
                                <input type="text" class="form-control form-control-border" id="nombre-role" name="name" value="{{$role->name}}">
                            </div>
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <h4><span class="text-danger">*</span> LISTADO DE PERMISOS:</h4>
                            <label><span class="text-danger">*</span> SELECCIONE LOS PERMISOS QUE LE OTORGARÁ A SU ROL:</label>
                            @foreach($permissions as $permission)
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permissions[]" type="checkbox" value="{{$permission->id}}" @if(in_array($permission->id, $permisos)) checked @endif id="{{$permission->description}}">
                                        <label class="form-check-label" for="{{$permission->description}}">
                                            {{$permission->description}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            @error('permissions')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <div class="row mt-4">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-block bg-gradient-warning btn-lg">EDITAR ROL</button>
                                </div>
                                <div class="col-6">
                                    <a href="{{route('admin.roles.index')}}" class="btn btn-block bg-gradient-danger btn-lg">CANCELAR</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
