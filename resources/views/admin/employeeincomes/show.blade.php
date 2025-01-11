@extends('layouts.app2')
@section('title', 'DETALLE DEL INGRESO')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>DETALLE DEL INGRESO</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.employeeincomes.index')}}">LISTA DE INGRESOS</a></li>
                        <li class="breadcrumb-item active">DETALLE DEL INGRESO</li>
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
                    <div class="col-12">

                            <div class="form-group">
                                <label>VISITANTES: <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    value="{{ mb_strtoupper($employeeincome->visitor->name) . ' - ' . '( ' . mb_strtoupper($employeeincome->visitor->state->name) . ' )' }}" 
                                    class="form-control form-control-border" 
                                    readonly
                                >
                            </div>
                            @error('visitor_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            
                           

                            <div class="form-group">
                                <label for="admission_date">FECHA INGRESO: <span class="text-danger">*</span> </label>
                                <input 
                                    type="text" 
                                    name="admission_date" 
                                    value="{{ $employeeincome->admission_date }}" 
                                    class="form-control form-control-border" 
                                    id="admission_date" 
                                    readonly
                                >
                            </div>
                            @error('admission_date')
                                <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label for="departure_date">FECHA SALIDA: </label>
                                <input 
                                    type="text" 
                                    name="departure_date" 
                                    value="{{ $employeeincome->departure_date ?? 'SIN FECHA DE SALIDA' }}" 
                                    class="form-control form-control-border" 
                                    id="departure_date" 
                                    readonly
                                >
                            </div>
                            @error('departure_date')
                                <span class="text-danger">{{$message}}</span>
                            @enderror


                            

                            <div class="form-group">
                                <label for="nota">NOTA:  </label>
                                <br>
                                    {!! mb_strtoupper($employeeincome->nota) !!}
                            </div>
                            @error('nota')
                            <span class="text-danger">{{$message}}</span>
                            @enderror


                            <div class="form-group">
                                <label for="nota">ELEMENTOS:  </label>

                                <div class="row" id="elements-container">
                                    @foreach($employeeElements as $element)
                                        <div class="col-12 element-item mt-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="card">
                                                                <div class="card-body text-center">
                                                                    <img class="captured-photo img-fluid" src="{{ asset('storage/' . $element->pivot->imagen) }}" alt="Foto del elemento">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="element-select">ELEMENTO:</label>
                                                                <select disabled class="custom-select form-control-border element-select">
                                                                    @foreach($elements as $availableElement)
                                                                        <option value="{{ $availableElement->id }}" {{ $availableElement->id == $element->id ? 'selected' : '' }}>
                                                                            {{ mb_strtoupper($availableElement->name) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="notaElement">NOTA:</label>
                                                            {!! mb_strtoupper($element->pivot->nota) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#visitor_id').select2({
                    allowClear: true,
                    templateResult: formatOption,
                    templateSelection: formatSelection
                });
            });
        </script>
    </section>


@endsection
