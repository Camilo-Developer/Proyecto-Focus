@extends('layouts.app2')
@section('title', 'Ingreso de elementos')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ingreso de elementos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Ingreso de elementos</li>
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
                                    @can('admin.elemententries.create')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#elemententriesCreate"><i class="fa fa-check"></i> Crear Ingreso de Elemento</button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @livewire('admin.element-entries.elemententries-filter')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('admin.elemententries.create')
            <div class="modal fade" id="elemententriesCreate"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-check-circle"></i> Nuevo ingreso de elemento</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.elemententries.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="admission_date">Ingreso del elemento: <span class="text-danger">*</span> </label>
                                        <input type="date" name="admission_date" required class="form-control form-control-border" id="admission_date">
                                    </div>
                                    @error('admission_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="departure_date">Salida del elemento: <span class="text-danger">*</span> </label>
                                        <input type="date" name="departure_date" required class="form-control form-control-border" id="departure_date">
                                    </div>
                                    @error('departure_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="note">Nota: <span class="text-danger">*</span> </label>
                                        <textarea name="note" class="form-control" id="note" cols="30" rows="10"></textarea>
                                    </div>
                                    @error('note')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror


                                    <div class="form-group">
                                        <label for="element_id">Elemento: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" name="element_id" id="element_id">
                                            <option value="">--Seleccionar Elemento--</option>
                                            @foreach($elements as $element)
                                                <option value="{{$element->id}}">{{$element->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('element_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear Ingreso del elemento</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        @can('admin.elemententries.edit')
            @foreach($elemententries as $elemententry)
                <div class="modal fade" id="modalEditelemententries_{{$elemententry->id}}"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Ingreso del elemento</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{route('admin.elemententries.update',$elemententry)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="admission_date">Ingreso del elemento: <span class="text-danger">*</span> </label>
                                            <input type="date" name="admission_date" value="{{$elemententry->admission_date}}" required class="form-control form-control-border" id="admission_date">
                                        </div>
                                        @error('admission_date')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="departure_date">Salida del elemento: <span class="text-danger">*</span> </label>
                                            <input type="date" name="departure_date" value="{{$elemententry->departure_date}}" required class="form-control form-control-border" id="departure_date">
                                        </div>
                                        @error('departure_date')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="note">Nota: <span class="text-danger">*</span> </label>
                                            <textarea name="note" class="form-control" id="note" cols="30" rows="10">{{$elemententry->note}}</textarea>
                                        </div>
                                        @error('note')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror


                                        <div class="form-group">
                                            <label for="element_id">Elemento: <span class="text-danger mt-1">* </span></label>
                                            <select class="custom-select form-control-border" name="element_id" id="element_id">
                                                <option value="">--Seleccionar Elemento--</option>
                                                @foreach($elements as $element)
                                                    <option value="{{$element->id}}" {{ $element->id == $elemententry->element_id ? 'selected' : '' }}>{{$element->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('element_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                    <div>
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Editar Ingreso del elemento</button>
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
