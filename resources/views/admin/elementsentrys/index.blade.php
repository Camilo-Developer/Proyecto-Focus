@extends('layouts.app2')
@section('title', 'Lista de elementos')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de elementos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista de elementos</li>
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
                                    @can('admin.elements.create')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#elementsCreate"><i class="fa fa-check"></i> Crear Elemento</button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @livewire('admin.elements.elements-filter')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('admin.elements.create')
            <div class="modal fade" id="elementsCreate"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-check-circle"></i> Nuevo Elemento</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.elements.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                        <input type="text" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre del elemento">
                                    </div>
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="contractoremployee_id">Empleados Contratista: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" name="contractoremployee_id" id="contractoremployee_id">
                                            <option value="">--Seleccionar empleado contratista--</option>
                                            @foreach($contractoremployees as $contractoremployee)
                                                <option value="{{$contractoremployee->id}}" {{ old('contractoremployee_id') == $contractoremployee->id ? 'selected' : '' }}>{{$contractoremployee->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('contractoremployee_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear elemento</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        @can('admin.elements.edit')
            @foreach($elements as $element)
                <div class="modal fade" id="modalEditElements_{{$element->id}}"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Elemento</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{route('admin.elements.update',$element)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                            <input type="text" value="{{$element->name}}" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre del elemento">
                                        </div>
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror


                                        <div class="form-group">
                                            <label for="contractoremployee_id"><span class="text-danger mt-1">* </span>  Empleado del contratista:</label>
                                            <select class="custom-select form-control-border" name="contractoremployee_id" id="contractoremployee_id">
                                                <option >--Seleccionar Empleado Contratista--</option>
                                                @foreach($contractoremployees as $contractoremployee)
                                                    <option value="{{$contractoremployee->id}}" {{ $contractoremployee->id == $element->contractoremployee_id ? 'selected' : '' }} {{ old('contractoremployee_id') == $contractoremployee->id ? 'selected' : '' }}>{{$contractoremployee->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('contractoremployee_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                    <div>
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Editar Elementos</button>
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
