@extends('layouts.app2')
@section('title', 'Litado de Roles')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Listado de Roles</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Listado de Roles</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @can('admin.roles.create')
                                <a href="{{route('admin.roles.create')}}" title="Crear Rol" class="new-mas"><i class="fas fa-plus"></i></a>
                            @endcan
                        </div>
                        <div class="card-body table-responsive p-3">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Nombre del Rol</th>
                                    <th scope="col">Creación</th>
                                    <th scope="col">Edición</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $role)
                                    <tr class="text-center">
                                        <td>{{$role->id}}</td>
                                        <td>{{$role->name}}</td>
                                        <td>{{ $role->created_at->format('Y-m-d')  }}</td>
                                        <td>{{$role->updated_at->format('Y-m-d')}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                @can('admin.roles.destroy')
                                                    <form method="post" action="{{route('admin.roles.destroy', $role)}}" id="eliminarrol_{{ $loop->iteration }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a title="Eliminar" onclick="document.getElementById('eliminarrol_{{ $loop->iteration }}').submit()" class="  btn btn-danger btn-company-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                @endcan
                                                @can('admin.roles.edit')
                                                    <a title="Editar" href="{{route('admin.roles.edit',$role)}}"
                                                       class="me-2 btn btn-warning btn-company-danger">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('admin.roles.show')
                                                    <a href="{{route('admin.roles.show',$role->id)}}"
                                                       class=" btn btn-success"><i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
