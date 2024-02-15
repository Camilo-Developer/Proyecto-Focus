@extends('layouts.app2')
@section('title', 'Lista de Ingreso de visitantes')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Ingreso de visitantes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista de Ingreso de visitantes</li>
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
                                    @can('admin.visitorentries.create')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#visitorentriesCreate"><i class="fa fa-check"></i> Crear Ingreso visitantes</button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @livewire('admin.visitorentries.visitorentries-filter')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('admin.visitorentries.create')
            <div class="modal fade" id="visitorentriesCreate"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-check-circle"></i> Nuevo Ingreso de visitante</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.visitorentries.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="admission_date">Fecha de ingreso: <span class="text-danger">*</span> </label>
                                        <input type="date" name="admission_date" required class="form-control form-control-border" id="admission_date">
                                    </div>
                                    @error('admission_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="departure_date">Fecha de salida: </label>
                                        <input type="date" name="departure_date"  class="form-control form-control-border" id="departure_date">
                                    </div>
                                    @error('departure_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="visit_type">Tipo de visita: <span class="text-danger">*</span></label>
                                        <input type="text" name="visit_type" required class="form-control form-control-border" id="visit_type" placeholder="Tipo de visita">
                                    </div>
                                    @error('visit_type')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="note">Nota: </label>
                                        <textarea name="note" id="note" cols="30" rows="10"></textarea>
                                    </div>
                                    @error('note')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="state_id">Estado: <span class="text-danger mt-1">* </span></label>
                                        <select required class="custom-select form-control-border" name="state_id" id="state_id">
                                            <option value="">-- Seleccionar estado --</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}">{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="unit_id">Unidad: <span class="text-danger mt-1">* </span></label>
                                        <select required class="custom-select form-control-border" name="unit_id" id="unit_id">
                                            <option value="">-- Seleccionar conjuto --</option>
                                            @foreach($units as $unit)
                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('unit_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear Ingreso del visitante</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        @can('admin.visitorentries.edit')
            @foreach($visitorentries as $visitorentry)
                <div class="modal fade" id="modalEditVisitorentries_{{$visitorentry->id}}"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Ingreso del visitante</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{route('admin.visitorentries.update',$visitorentry)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="admission_date">Fecha de ingreso: <span class="text-danger">*</span> </label>
                                            <input type="date" value="{{$visitorentry->admission_date}}" name="admission_date" required class="form-control form-control-border" id="admission_date">
                                        </div>
                                        @error('admission_date')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="departure_date">Fecha de salida: <span class="text-danger">*</span></label>
                                            <input type="date" value="{{$visitorentry->departure_date}}" name="departure_date" required class="form-control form-control-border" id="departure_date">
                                        </div>
                                        @error('departure_date')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="visit_type">Tipo de visita: <span class="text-danger">*</span></label>
                                            <input type="text" name="visit_type" value="{{$visitorentry->visit_type}}" required class="form-control form-control-border" id="visit_type" placeholder="Tipo de visita">
                                        </div>
                                        @error('visit_type')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="note">Nota: </label>
                                            <textarea name="note" id="note" cols="30" rows="10">{{$visitorentry->note}}</textarea>
                                        </div>
                                        @error('note')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror


                                        <div class="form-group">
                                            <label for="state_id"><span class="text-danger mt-1">* </span>  Estado:</label>
                                            <select class="custom-select form-control-border" name="state_id" id="state_id">
                                                <option >--Seleccionar Estado --</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" {{ $state->id == $visitorentry->state_id ? 'selected' : '' }}>{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('state_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="unit_id"><span class="text-danger mt-1">* </span>  Unidad:</label>
                                            <select class="custom-select form-control-border" name="unit_id" id="unit_id">
                                                <option >--Seleccionar Estado --</option>
                                                @foreach($units as $unit)
                                                    <option value="{{$unit->id}}" {{ $unit->id == $visitorentry->unit_id ? 'selected' : '' }}>{{$unit->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('unit_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                    <div>
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Editar Ingreso del visitante</button>
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
