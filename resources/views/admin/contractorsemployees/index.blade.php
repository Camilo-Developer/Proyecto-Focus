@extends('layouts.app2')
@section('title', 'Lista de Contratos Empleados')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Contratos Empleados</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista de Contratos de Empleados</li>
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
                                    @can('admin.contractorsemployee.create')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#contratorsemployeesCreate"><i class="fa fa-check"></i> Crear contrato</button>
                                    @endcan
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
                                        <th scope="col">Estado</th>
                                        <th scope="col">Contrato</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $countContratorsEmployee = 1;
                                    @endphp
                                    @foreach($contractorsemployees as $contractoremployee)
                                        <tr class="text-center">
                                            <th scope="row" style="width: 50px;">{{$countContratorsemployee}}</th>
                                            <td>{{ $contractoremployee->name }}</td>
                                            <td>{{ $contractoremployee->state_id }}</td>
                                            <td>{{ $contractoremployee->contractor_id }}</td>
                                            <td style="width: 100px;">
                                                <div class="btn-group">
                                                    @can('admin.contractorsemployees.edit')
                                                        <button type="button" data-toggle="modal" data-target="#modal-edit-contractorsemployees_{{$loop->iteration}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                                    @endcan
                                                    @can('admin.contractors.destroy')
                                                        <a style="margin-left: 5px" title="Eliminar" onclick="document.getElementById('eliminarContractors_{{ $loop->iteration }}').submit()" class="btn btn-danger ">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @can('admin.contractors.destroy')
                                            <form action="{{route('admin.contractors.destroy',$contractor)}}"  method="POST" id="eliminar Contractors_{{ $loop->iteration }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endcan
                                        @php
                                            $countContrators++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    {!! $contractors->links() !!}
                </div>
            </div>
        </div>
        @can('admin.contractors.create')
            <div class="modal fade" id="contratorsCreate"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-check-circle"></i> Nuevo Contrato</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="{{route('admin.contractors.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div style="max-height: 365px; ov--erflow-y: scroll; overflow-x: hidden">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                        <input type="text" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre del contrato">
                                    </div>
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="phone">Telefono: <span class="text-danger">*</span> </label>
                                        <input type="number" name="phone" required class="form-control form-control-border" id="phone" placeholder="Numero de telefono del contrato">
                                    </div>
                                    @error('phone')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="nit">Nit del contrato: <span class="text-danger">*</span></label>
                                        <input type="number" name="nit" required class="form-control form-control-border" id="nit" placeholder="Nit del contrato">
                                    </div>
                                    @error('nit')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="address">Dirección del contrato: <span class="text-danger">*</span></label>
                                        <input type="text" name="address" required class="form-control form-control-border" id="address" placeholder="Dirección de contrato">
                                    </div>
                                    @error('address')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="state_id">Estado del contrato: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" name="state_id" id="state_id">
                                            <option value="">--Seleccionar Contrato--</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="setresidencial_id">Setresidencial: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" name="setresidencial_id" id="setresidencial_id">
                                            <option value="">--Seleccionar setresidencial--</option>
                                            @foreach($setresidencials as $setresidencial)
                                                <option value="{{$setresidencial->id}}" {{ old('setresidencial_id') == $setresidencial->id ? 'selected' : '' }}>{{$setresidencial->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('setresidencial_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                  

                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear contrato</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        @can('admin.contractors.edit')
            @foreach($contractors as $contractor)
                <div class="modal fade" id="modal-edit-contractors_{{$loop->iteration}}"  aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar contrato</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{route('admin.contractors.update',$contractors)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                            <input type="text" value="{{$contractor->name}}" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre del contrato">
                                        </div>
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="phone">Telefono Contrato: <span class="text-danger">*</span></label>
                                            <input type="number" value="{{$contractor->phone}}" name="phone" required class="form-control form-control-border" id="phone" placeholder="Telefono del contrato">
                                        </div>
                                        @error('phone')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="nit">Nit del contrato: <span class="text-danger">*</span></label>
                                            <input type="number" value="{{$contractor->nit}}" name="nit" required class="form-control form-control-border" id="nit" placeholder="Nit del contrato">
                                        </div>
                                        @error('nit')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="address">Address: <span class="text-danger">*</span></label>
                                            <input type="number" value="{{$contractor->address}}" name="address" required class="form-control form-control-border" id="address" placeholder="address del contrato">
                                        </div>
                                        @error('address')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        
                                        <div class="form-group">
                                            <label for="state_id"><span class="text-danger mt-1">* </span>  Estado del conjunto:</label>
                                            <select class="custom-select form-control-border" name="state_id" id="state_id">
                                                <option >--Seleccionar Estado--</option>
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}" {{ $state->id == $contractor->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('state_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror


                                        <div class="form-group">
                                            <label for="setresidencial_id"><span class="text-danger mt-1">* </span>  setresidential:</label>
                                            <select class="custom-select form-control-border" name="setresidencial_id" id="setresidencial_id">
                                                <option >--Seleccionar conjunto--</option>
                                                @foreach($setresidencials as $setresidencial)
                                                    <option value="{{$setresidencial->id}}" {{ $setresidencial->id == $contractor->setresidencial_id ? 'selected' : '' }} {{ old('setresidencial_id') == $setresidencial->id ? 'selected' : '' }}>{{$setresidencial->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('setresidencial_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                    <div>
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Editar Contrato</button>
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