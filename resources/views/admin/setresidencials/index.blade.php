@extends('layouts.app2')
@section('title', 'Lista de Conjuntos')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de conjuntos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista de conjuntos</li>
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
                                    @can('admin.setresidencials.create')
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#SetResidencials"><i class="fa fa-check"></i> Crear conjunto</button>
                                    @endcan
                                </div>
                                <div class="col-12 col-md-9 d-flex justify-content-end">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <form action="{{ route('admin.setresidencials.index') }}" method="GET">
                                            <div class="input-group input-group-sm buq-menu" >
                                                <input value="{{$search}}"   type="search" name="search" class="form-control float-right" placeholder="Buscar conjunto">
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
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Dirección</th>
                                        <th scope="col">Nit</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $countSetResidencials = 1;
                                    @endphp
                                    @foreach($setresidencials as $setresidencial)
                                        <tr class="text-center">
                                            <th scope="row" style="width: 50px;">{{$countSetResidencials}}</th>
                                            <td>
                                                <img width="60px" src="{{asset('storage/'.$setresidencial->imagen)}}" alt="">
                                            </td>
                                            <td>{{ strtoupper($setresidencial->name) }}</td>
                                            <td>{{ $setresidencial->address }}</td>
                                            <td>{{ $setresidencial->nit }}</td>
                                            <td>{{ $setresidencial->state->name }}</td>
                                            <td style="width: 100px;">
                                                <div class="btn-group">
                                                    @can('admin.setresidencials.edit')
                                                        <button type="button" data-toggle="modal" data-target="#modal-edit-setresidencials_{{$loop->iteration}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                                    @endcan
                                                    @can('admin.setresidencials.destroy')
                                                        <a style="margin-left: 5px" title="Eliminar" onclick="document.getElementById('eliminarSetResidencials_{{ $loop->iteration }}').submit()" class="btn btn-danger ">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @can('admin.setresidencials.destroy')
                                            <form action="{{route('admin.setresidencials.destroy',$setresidencial)}}"  method="POST" id="eliminarSetResidencials_{{ $loop->iteration }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endcan
                                        @php
                                            $countSetResidencials++;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(!empty($search) && !$setresidencials->isEmpty())
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('admin.setresidencials.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i> Borrar búsqueda</a>
                                    </div>
                                </div>
                            @endif
                            @if($setresidencials->isEmpty())
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center mt-4">No hay resultados para tu búsqueda.</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('admin.setresidencials.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i> Borrar búsqueda</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    {!! $setresidencials->links() !!}
                </div>
            </div>
        </div>
        @can('admin.setresidencials.create')
            <div class="modal fade" id="SetResidencials" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-check-circle"></i> Nuevo conjunto</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="formSetResidencials" action="{{ route('admin.setresidencials.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="imagen">Imagen: <span class="text-danger">*</span></label>
                                        <input type="file" name="imagen" required class="form-control form-control-border" id="imagen">
                                    </div>
                                    @error('imagen')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="name">Nombre: <span class="text-danger">*</span> </label>
                                        <input type="text" name="name" required class="form-control form-control-border" id="name" placeholder="Nombre del conjunto">
                                    </div>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="address">Dirección: <span class="text-danger">*</span></label>
                                        <input type="text" name="address" required class="form-control form-control-border" id="address" placeholder="Dirección del conjunto">
                                    </div>
                                    @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="nit">Nit:</label>
                                        <input type="text" name="nit" class="form-control form-control-border" id="nit" placeholder="NIT del conjunto">
                                    </div>
                                    @error('nit')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <div class="form-group">
                                        <label for="state_id">Estado del conjunto: <span class="text-danger mt-1">*</span></label>
                                        <select class="custom-select form-control-border" name="state_id" id="state_id">
                                            <option value="">--Seleccionar Estado--</option>
                                            @foreach($states as $state)
                                            <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Crear conjunto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

          

        @endcan
        @can('admin.setresidencials.edit')
            @foreach($setresidencials as $setresidencial)
                <div class="modal fade" id="modal-edit-setresidencials_{{$loop->iteration}}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Conjunto</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <!-- Agregamos un id único al formulario para cada iteración -->
                            <form id="formEditSetResidencial_{{$loop->iteration}}" action="{{route('admin.setresidencials.update',$setresidencial)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div style="max-height: 365px; overflow-y: scroll; overflow-x: hidden">
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>Campo requerido.</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="imagen"><span class="text-danger">*</span> Imagen:</label>
                                            <input type="file" name="imagen" value="{{$setresidencial->imagen}}" class="form-control form-control-border" id="imagen_{{$loop->iteration}}">
                                        </div>
                                        @error('imagen')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="name"><span class="text-danger">*</span> Nombre:</label>
                                            <input type="text" name="name" value="{{$setresidencial->name}}" required class="form-control form-control-border" id="name_{{$loop->iteration}}" placeholder="Nombre del conjunto">
                                        </div>
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="address"><span class="text-danger">*</span> Dirección:</label>
                                            <input type="text" name="address" value="{{$setresidencial->address}}" required class="form-control form-control-border" id="address_{{$loop->iteration}}" placeholder="Dirección del conjunto">
                                        </div>
                                        @error('address')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="nit">Nit:  </label>
                                            <input type="text" name="nit" value="{{$setresidencial->nit}}"  class="form-control form-control-border" id="nit_{{$loop->iteration}}" placeholder="NIT del conjunto">
                                        </div>
                                        @error('nit')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="state_id"><span class="text-danger mt-1">* </span> Estado del conjunto:</label>
                                            <select class="custom-select form-control-border" name="state_id" id="state_id_{{$loop->iteration}}">
                                                <option>--Seleccionar Estado--</option>
                                                @foreach($states as $state)
                                                <option value="{{$state->id}}" {{ $state->id == $setresidencial->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
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
                                    <!-- Modificamos el botón para que muestre el SweetAlert al hacer clic -->
                                    <button type="button" class="btn btn-warning" onclick="confirmEdit({{$loop->iteration}})"><i class="fa fa-edit"></i> Editar conjunto</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <script>
                function confirmEdit(id) {
                    // Obtener el nombre del conjunto
                    const nombreConjunto = document.getElementById(`name_${id}`).value;

                    Swal.fire({
                        title: `¿Estás seguro de editar el conjunto "${nombreConjunto}"?`,
                        text: "¡No podrás deshacer esta acción!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, editar',
                        cancelButtonText: 'No, cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si el usuario confirma, envía el formulario
                            document.getElementById(`formEditSetResidencial_${id}`).submit();
                        } else {
                            Swal.fire('Cancelado', 'No se realizó ninguna modificación.', 'error');
                        }
                    });
                }
            </script>

        @endcan
    </section>

    <script>
                document.getElementById('formSetResidencials').addEventListener('submit', function(event) {
                    event.preventDefault(); // Detiene el envío del formulario
                    
                    // Obtener el nombre del conjunto
                    const nombreConjunto = document.getElementById('name').value;

                    Swal.fire({
                        title: `¿Estás seguro de crear el conjunto "${nombreConjunto}"?`,
                        text: "¡No podrás revertir esta acción!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, crear',
                        cancelButtonText: 'No, cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si el usuario confirma, envía el formulario
                            this.submit();
                        } else {
                            // Si el usuario cancela, puedes cerrar el modal o hacer cualquier otra acción
                            Swal.fire('Cancelado', 'La información no fue registrada.', 'error');
                        }
                    });
                });
            </script>
@endsection
