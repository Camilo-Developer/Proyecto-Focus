@extends('layouts.app2')
@section('title', 'LISTA DE UNIDADES')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>LISTA DE UNIDADES</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item active">LISTA DE UNIDADES</li>
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
                                    @can('admin.units.create')
                                        <a href="{{route('admin.units.create')}}" class="btn btn-primary btn-sm" ><i class="fa fa-check"></i> CREAR UNIDAD</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @livewire('admin.units.units-filter')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('admin.units.edit')
            @foreach($units as $unit)
                <div class="modal fade" id="modalEditUnit_{{$loop->iteration}}"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Unidad</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{route('admin.units.update',$unit)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                            <input type="text" value="{{$unit->name}}" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre del empleado">
                                        </div>
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror


                                        <div class="form-group">
                                            <label for="state_id"><span class="text-danger mt-1">* </span>  Estado:</label>
                                            <select class="custom-select form-control-border" name="state_id" id="state_id">
                                                <option >--Seleccionar Estado--</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" {{ $state->id == $unit->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('state_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror


                                        <div class="form-group">
                                            <label for="agglomeration_id"><span class="text-danger mt-1">* </span>  Aglomeración:</label>
                                            <select class="custom-select form-control-border" name="agglomeration_id" id="agglomeration_id">
                                                <option >--Seleccionar Aglomeración--</option>
                                                @foreach($agglomerations as $agglomeration)
                                                    <option value="{{$agglomeration->id}}" {{ $agglomeration->id == $unit->agglomeration_id ? 'selected' : '' }} {{ old('agglomeration_id') == $agglomeration->id ? 'selected' : '' }}>{{$agglomeration->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('agglomeration_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                    <div>
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Editar Unidad</button>
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
