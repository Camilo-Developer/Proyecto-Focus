@extends('layouts.app2')
@section('title', 'Lista de Aglomeraciones')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de aglomeraciones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista de aglomeraciones</li>
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
                                    @can('admin.agglomerations.create')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#agglomerations"><i class="fa fa-check"></i> Crear aglomeración</button>
                                    @endcan
                                </div>
                                <div class="col-12 col-md-9 d-flex justify-content-end">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <form action="{{ route('admin.agglomerations.index') }}" method="GET">
                                            <div class="input-group input-group-sm buq-menu" >
                                                <input value="{{$search}}"   type="search" name="search" class="form-control float-right" placeholder="Buscar aglomeracion">
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
                                        <th scope="col">Tipo de aglomeración</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Conjunto</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $countAgglomerations = 1;
                                    @endphp
                                    @foreach($agglomerations as $agglomeration)
                                        <tr class="text-center">
                                            <th scope="row" style="width: 50px;">{{$countAgglomerations}}</th>
                                            <td>{{ $agglomeration->name }}</td>
                                            <td>{{ $agglomeration->type_agglomeration }}</td>
                                            <td>{{ $agglomeration->state->name }}</td>
                                            <td>{{ $agglomeration->setresidencial->name }}</td>
                                            <td style="width: 100px;">
                                                <div class="btn-group">
                                                    @can('admin.agglomerations.edit')
                                                        <button type="button" data-toggle="modal" data-target="#modal-edit-agglomerations_{{$loop->iteration}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                                    @endcan
                                                    @can('admin.agglomerations.destroy')
                                                        <a style="margin-left: 5px" title="Eliminar" onclick="document.getElementById('eliminarAgglomerations_{{ $loop->iteration }}').submit()" class="btn btn-danger ">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @can('admin.agglomerations.destroy')
                                            <form action="{{route('admin.agglomerations.destroy',$agglomeration)}}"  method="POST" id="eliminarAgglomerations_{{ $loop->iteration }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endcan
                                        @php
                                            $countAgglomerations++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(!empty($search) && !$agglomerations->isEmpty())
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('admin.agglomerations.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i> Borrar búsqueda</a>
                                    </div>
                                </div>
                            @endif
                            @if($agglomerations->isEmpty())
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center mt-4">No hay resultados para tu búsqueda.</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('admin.agglomerations.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i> Borrar búsqueda</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    {!! $agglomerations->links() !!}
                </div>
            </div>
        </div>
        @can('admin.agglomerations.create')
            <div class="modal fade" id="agglomerations"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-check-circle"></i> Nueva aglomeración</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.agglomerations.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
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
                                        <label for="setresidencial_id">Conjunto de la aglomeración: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" name="setresidencial_id" id="setresidencial_id">
                                            <option value="">--Seleccionar conjunto--</option>
                                            @foreach($setresidencials as $setresidencial)
                                                <option value="{{$setresidencial->id}}" {{ old('setresidencial_id') == $setresidencial->id ? 'selected' : '' }}>{{$setresidencial->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
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

                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear aglomeración</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        @can('admin.agglomerations.edit')
            @foreach($agglomerations as $agglomeration)
                <div class="modal fade" id="modal-edit-agglomerations_{{$loop->iteration}}"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar aglomeración</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{route('admin.agglomerations.update',$agglomeration)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                            <input type="text" value="{{$agglomeration->name}}" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre de la aglomeración">
                                        </div>
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="type_agglomeration">Tipo de aglomeración: <span class="text-danger">*</span></label>
                                            <input type="text" value="{{$agglomeration->type_agglomeration}}" name="type_agglomeration" required class="form-control form-control-border" id="type_agglomeration" placeholder="Tipo de aglomeración">
                                        </div>
                                        @error('type_agglomeration')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="setresidencial_id"><span class="text-danger mt-1">* </span>  Conjunto de la aglomeración:</label>
                                            <select class="custom-select form-control-border" name="setresidencial_id" id="setresidencial_id">
                                                <option >--Seleccionar conjunto--</option>
                                                @foreach($setresidencials as $setresidencial)
                                                    <option value="{{$setresidencial->id}}" {{ $setresidencial->id == $agglomeration->setresidencial_id ? 'selected' : '' }} {{ old('setresidencial_id') == $setresidencial->id ? 'selected' : '' }}>{{$setresidencial->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('setresidencial_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="state_id"><span class="text-danger mt-1">* </span>  Estado del conjunto:</label>
                                            <select class="custom-select form-control-border" name="state_id" id="state_id">
                                                <option >--Seleccionar Estado--</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" {{ $state->id == $agglomeration->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('state_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                    <div>
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Editar aglomeración</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endcan
    </section>
@endsection
