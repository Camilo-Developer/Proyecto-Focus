@extends('layouts.app2')
@section('title', 'Lista de Estados')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Estados</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista de Estados</li>
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
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    @can('admin.states.create')
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-check"></i> Crear Estado</button>
                                    @endcan
                                </div>
                                <div class="col-12 col-md-9 d-flex justify-content-end">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <form action="{{ route('admin.states.index') }}" method="GET">
                                            <div class="input-group input-group-sm buq-menu" >
                                                <input value="{{$search}}"   type="search" name="search" class="form-control float-right" placeholder="Buscar Estado">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Creación</th>
                                        <th scope="col">Edición</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($states as $state)
                                        <tr class="text-center">
                                            <th scope="row" style="width: 50px;">{{$state->id}}</th>
                                            <td>{{$state->name}}</td>
                                            <td>{{ $state->created_at->format('Y-m-d')  }}</td>
                                            <td>{{$state->updated_at->format('Y-m-d')}}</td>
                                            <td style="width: 100px;">
                                                <div class="btn-group">
                                                    @can('admin.states.edit')
                                                    <button type="button" data-toggle="modal" data-target="#modal-edit-estado_{{$loop->iteration}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                                    @endcan
                                                    @can('admin.states.destroy')
                                                        <a style="margin-left: 5px" title="Eliminar" onclick="document.getElementById('eliminarEstado_{{ $loop->iteration }}').submit()" class="btn btn-danger ">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @can('admin.states.destroy')
                                            <form action="{{route('admin.states.destroy',$state)}}"  method="POST" id="eliminarEstado_{{ $loop->iteration }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endcan
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(!empty($search) && !$states->isEmpty())
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('admin.states.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i> Borrar búsqueda</a>
                                    </div>
                                </div>
                            @endif
                            @if($states->isEmpty())
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center mt-4">No hay resultados para tu búsqueda.</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('admin.states.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i> Borrar búsqueda</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    {!! $states->links() !!}
                </div>
            </div>
        </div>
        @can('admin.states.create')
            <div class="modal fade" id="modal-default"  aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-check-circle"></i> Nuevo Estado</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{route('admin.states.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                <div class="d-flex justify-content-end">
                                    <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                </div>
                                <div class="form-group">
                                    <label for="title"><span class="text-danger">*</span> Nombre:</label>
                                    <input type="text" name="name" required class="form-control form-control-border" id="title" placeholder="Título">
                                </div>
                                <div class="form-group">
                                    <label><span class="text-danger mt-1">* </span> Tipo de estado</label>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input id="activo" class="form-check-input" type="radio" value="1" name="type_state" >
                                                <label for="activo" class="form-check-label" >Activo</label>
                                            </div>
                                            <div class="form-check">
                                                <input id="no_activo" class="form-check-input" type="radio" value="2" name="type_state" >
                                                <label for="no_activo" class="form-check-label">Desactivo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endcan
        @can('admin.states.edit')
            @foreach($states as $state)
            <div class="modal fade" id="modal-edit-estado_{{$loop->iteration}}"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Estado</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.states.update',$state)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="title"><span class="text-danger">*</span> Nombre:</label>
                                        <input type="text" name="name" value="{{$state->name}}" required class="form-control form-control-border" id="title" placeholder="Título">
                                    </div>
                                    <div class="form-group">
                                        <label><span class="text-danger mt-1">* </span> Tipo de estado</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-check">
                                                    <input id="activo" class="form-check-input" type="radio" value="1" name="type_state" @if($state->type_state == 1) checked @endif>
                                                    <label for="activo" class="form-check-label" >Activo</label>
                                                </div>
                                                <div class="form-check">
                                                    <input id="no_activo" class="form-check-input" type="radio" value="2" name="type_state" @if($state->type_state == 2) checked @endif>
                                                    <label for="no_activo" class="form-check-label">Desactivo</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                <div>
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Editar</button>

                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        @endforeach
        @endcan

    </section>
@endsection
