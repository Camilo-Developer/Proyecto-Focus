@extends('layouts.app2')
@section('title', 'Lista de Empleados por Contratista')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Empleados por Contratista</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista de Empleados por Contratista</li>
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
                                    @can('admin.contractoremployees.create')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#contractoremployeesCreate"><i class="fa fa-check"></i> Crear Empleado</button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @livewire('admin.contractor-employees.contractor-employees-filter')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('admin.contractoremployees.create')
            <div class="modal fade" id="contractoremployeesCreate"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-check-circle"></i> Nuevo Empleado</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.contractoremployees.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                        <input type="text" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre del empleado">
                                    </div>
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="state_id">Estados: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" name="state_id" id="state_id">
                                            <option value="">--Seleccionar estado--</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="contractor_id">Contratistas: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" name="contractor_id" id="contractor_id">
                                            <option value="">--Seleccionar setresidencial--</option>
                                            @foreach($contractors as $contractor)
                                                <option value="{{$contractor->id}}" {{ old('contractor_id') == $contractor->id ? 'selected' : '' }}>{{$contractor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('contractor_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear empleado</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        @can('admin.contractoremployees.edit')
            @foreach($contractoremployees as $contractoremployee)
                <div class="modal fade" id="modalEditContractorEmployees_{{$loop->iteration}}"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Empleado</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{route('admin.contractoremployees.update',$contractoremployee)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                            <input type="text" value="{{$contractoremployee->name}}" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre del empleado">
                                        </div>
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror


                                        <div class="form-group">
                                            <label for="state_id"><span class="text-danger mt-1">* </span>  Estado:</label>
                                            <select class="custom-select form-control-border" name="state_id" id="state_id">
                                                <option >--Seleccionar Estado--</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" {{ $state->id == $contractoremployee->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('state_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror


                                        <div class="form-group">
                                            <label for="contractor_id"><span class="text-danger mt-1">* </span>  Contratista:</label>
                                            <select class="custom-select form-control-border" name="contractor_id" id="contractor_id">
                                                <option >--Seleccionar conjunto--</option>
                                                @foreach($contractors as $contractor)
                                                    <option value="{{$contractor->id}}" {{ $contractor->id == $contractoremployee->contractor_id ? 'selected' : '' }} {{ old('contractor_id') == $contractor->id ? 'selected' : '' }}>{{$contractor->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('contractor_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                    <div>
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Editar Empleado</button>
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
