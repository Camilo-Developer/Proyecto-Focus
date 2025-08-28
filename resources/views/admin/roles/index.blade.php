@extends('layouts.app2')
@section('title', 'LISTADO DE ROLES')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>LISTADO DE ROLES</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item active">LISTADO DE ROLES</li>
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
                                <a class="btn btn-primary btn-sm" href="{{route('admin.roles.create')}}" title="CREAR ROL"><i class="fa fa-check"></i> CREAR ROL</a>
                            @endcan
                        </div>
                        <div class="card-body table-responsive p-3">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>NOMBRE</th>
                                    <th scope="col">CREACIÓN</th>
                                    <th scope="col">EDICIÓN</th>
                                    <th>ACCIÓN</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $role)
                                    <tr class="text-center">
                                        <td>{{$role->id}}</td>
                                        <td>{{mb_strtoupper($role->name)}}</td>
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
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
