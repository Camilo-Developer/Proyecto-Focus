@extends('layouts.app2')
@section('title', 'Ingreso de empleados')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ingreso de empleados</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Ingreso de empleados</li>
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
                                    @can('admin.employeeincomes.create')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#employeeincomesCreate"><i class="fa fa-check"></i> Crear Ingreso de Empleados</button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @livewire('admin.employee-incomes.employeeincomes-filter')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('admin.employeeincomes.create')
            <div class="modal fade" id="employeeincomesCreate"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-check-circle"></i> Nuevo Ingreso de Empleados</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.employeeincomes.store')}}" method="post" enctype="multipart/form-data">
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
                                        <label for="contractoremployee_id">Empleados del contratista: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" name="contractoremployee_id" id="contractoremployee_id">
                                            <option value="">--Seleccionar Empleados del contratista--</option>
                                            @foreach($contractoremployees as $contractoremployee)
                                                <option value="{{$contractoremployee->id}}">{{$contractoremployee->name}}</option>
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
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear Ingreso del empleado</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        @can('admin.employeeincomes.edit')
            @foreach($employeeincomes as $employeeincome)
                <div class="modal fade" id="modalEditemployeeincomes_{{$employeeincome->id}}"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Ingreso del empleado</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{route('admin.employeeincomes.update',$employeeincome)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="admission_date">Ingreso del elemento: <span class="text-danger">*</span> </label>
                                            <input type="date" name="admission_date" value="{{$employeeincome->admission_date}}" required class="form-control form-control-border" id="admission_date">
                                        </div>
                                        @error('admission_date')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="departure_date">Salida del elemento: <span class="text-danger">*</span> </label>
                                            <input type="date" name="departure_date" value="{{$employeeincome->departure_date}}" required class="form-control form-control-border" id="departure_date">
                                        </div>
                                        @error('departure_date')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="contractoremployee_id">Empleados del contratista: <span class="text-danger mt-1">* </span></label>
                                            <select class="custom-select form-control-border" name="contractoremployee_id" id="contractoremployee_id">
                                                <option value="">--Seleccionar Empleados del contratista--</option>
                                                @foreach($contractoremployees as $contractoremployee)
                                                    <option value="{{$contractoremployee->id}}" {{ $contractoremployee->id == $employeeincome->contractoremployee_id ? 'selected' : '' }}>{{$contractoremployee->name}}</option>
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
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Editar Ingreso del empleado</button>
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
