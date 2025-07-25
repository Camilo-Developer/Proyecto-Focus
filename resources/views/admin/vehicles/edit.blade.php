@extends('layouts.app2')
@section('title', 'EDICIÓN DE VEHICULOS')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>EDICIÓN DE VEHICULOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.vehicles.index')}}">LISTADO DE VEHICULOS</a></li>
                    <li class="breadcrumb-item active">EDICIÓN DE VEHICULOS</li>
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
                            <form action="{{route('admin.vehicles.update',$vehicle)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="d-flex justify-content-end">
                                    <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                                </div>


                                 <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="name">FOTO DEL VEHICULO: <span class="text-danger">*</span> </label>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-photo">
                                                TOMAR FOTO
                                            </button>
                                            <input type="hidden" name="imagen" value="{{ $vehicle->imagen }}" id="imagen">

                                            <!-- Modal para la cámara -->
                                            <div class="modal fade" id="modal-photo" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tomar Foto</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <video id="video" autoplay playsinline class="w-100" style="max-height: 300px;"></video>
                                                                    <canvas id="canvas" style="display: none;"></canvas>
                                                                </div>
                                                                <div class="col-12">
                                                                    <button type="button" id="reversePhoto" class="btn btn-warning" ><i class="fas fa-retweet"></i> </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" id="savePhoto" class="btn btn-success" data-dismiss="modal"><i class="fas fa-camera"></i> Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('imagen')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="placa">PLACA: <span class="text-danger">*</span> </label>
                                    <input type="text" value="{{mb_strtoupper($vehicle->placa)}}" name="placa" required class="form-control form-control-border" id="placa">
                                </div>
                                @error('placa')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                @if(auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('SUB_ADMINISTRADOR'))
                                    <div class="form-group">
                                        <label for="state_id"><span class="text-danger mt-1">* </span> ESTADO:</label>
                                        <select class="custom-select form-control-border" name="state_id" id="state_id">
                                            <option>--SELECCIONAR --</option>
                                            @foreach($states as $state)
                                            <option value="{{$state->id}}" {{ $state->id == $vehicle->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{mb_strtoupper($state->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                @elseif(auth()->user()->hasRole('PORTERO'))
                                    <div class="form-group">
                                        <label for="state_id"><span class="text-danger mt-1">* </span> ESTADO:</label>
                                        <select disabled class="custom-select form-control-border"  id="state_id">
                                            <option>--SELECCIONAR --</option>
                                            @foreach($states as $state)
                                            <option value="{{$state->id}}" {{ $state->id == $vehicle->state_id ? 'selected' : '' }} {{ old('state_id') == $state->id ? 'selected' : '' }}>{{mb_strtoupper($state->name)}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="state_id" value="{{$vehicle->state_id}}">
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                @endif


                                @if(auth()->user()->hasRole('ADMINISTRADOR'))
                                    <div class="form-group">
                                        <label>CONJUNTO: <span class="text-danger">*</span></label>
                                        <select id="setresidencial_id" name="setresidencial_id" class="form-control select2" style="width: 100%;">
                                            @foreach($setresidencials as $setresidencial)
                                                <option value="{{ $setresidencial->id }}" data-state="{{ $setresidencial->state_id }}"
                                                    {{ $setresidencial->id == $vehicle->setresidencial_id ? 'selected' : '' }} {{ old('setresidencial_id') == $setresidencial->id ? 'selected' : '' }}
                                                >
                                                {{mb_strtoupper($setresidencial->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('setresidencial_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                @else
                                    <div class="form-group">
                                        <label for="setresidencial_id">CONJUNTO: <span class="text-danger">*</span></label>
                                            <input type="text" disabled class="form-control form-control-border" id="setresidencial_id" value="{{ mb_strtoupper($setresidencial->name) }}">
                                            <input type="hidden" name="setresidencial_id"  value="{{ $setresidencial->id }}">
                                    </div>
                                    @error('setresidencial_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @endif

                                <div class="form-group">
                                    <label>UNIDADES:</label>
                                    <select id="units" name="units[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" data-state="{{ $unit->state_id }}"
                                                {{ in_array($unit->id, $units_vehicles) ? 'selected' : '' }}>
                                                {{ mb_strtoupper($unit->name) . ' - (' . mb_strtoupper($unit->agglomeration->setresidencial->name) . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('units')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div class="form-group">
                                    <label>VISITANTES:</label>
                                    <select id="visitors" name="visitors[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                                        @foreach($visitors as $visitor)
                                            <option value="{{ $visitor->id }}" data-state="{{ $visitor->state_id }}"
                                                {{ in_array($visitor->id, $visitors_vehicles) ? 'selected' : '' }}>
                                                {{mb_strtoupper($visitor->document_number) . ' - ' .  mb_strtoupper($visitor->name) . ' - (' .  mb_strtoupper($visitor->typeuser->name) .')' . ' (' .  mb_strtoupper($visitor->setresidencial->name) .')'}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('visitors')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-warning btn-lg">EDITAR VEHICULO</button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <a href="{{route('admin.vehicles.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#units').select2({
                    allowClear: true,
                    templateResult: formatOption,
                    templateSelection: formatSelection
                });

                function formatOption(option) {
                    if (!option.id) return option.text; // Para la opción por defecto "-- SELECCIONAR --"
                    const stateId = $(option.element).data('state');
                    const isActive = stateId === 1;

                    const circle = isActive
                        ? `<span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: green; margin-right: 5px;"></span>`
                        : `<span style="color: red; margin-right: 5px;">✖</span>`;

                    return $(`<span>${circle}${option.text}</span>`);
                }

                function formatSelection(option) {
                    if (!option.id) return option.text; // Para mantener el texto seleccionado limpio
                    return option.text;
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#visitors').select2({
                    allowClear: true,
                    templateResult: formatOption,
                    templateSelection: formatSelection
                });

                function formatOption(option) {
                    if (!option.id) return option.text; // Para la opción por defecto "-- SELECCIONAR --"
                    const stateId = $(option.element).data('state');
                    const isActive = stateId === 1;

                    const circle = isActive
                        ? `<span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: green; margin-right: 5px;"></span>`
                        : `<span style="color: red; margin-right: 5px;">✖</span>`;

                    return $(`<span>${circle}${option.text}</span>`);
                }

                function formatSelection(option) {
                    if (!option.id) return option.text; // Para mantener el texto seleccionado limpio
                    return option.text;
                }
            });
        </script>

        <script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const previewImage = document.getElementById('previewImage');
    const imagenInput = document.getElementById('imagen');
    let stream = null;
    let useFrontCamera = true; // true: frontal, false: trasera

    async function startCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }

        const constraints = {
            video: {
                facingMode: useFrontCamera ? 'user' : 'environment'
            }
        };

        try {
            stream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = stream;
        } catch (error) {
            alert('No se pudo acceder a la cámara: ' + error.message);
        }
    }

    // Abrir la cámara al mostrar el modal
    $('#modal-photo').on('shown.bs.modal', startCamera);

    // Detener la cámara al cerrar el modal
    $('#modal-photo').on('hidden.bs.modal', () => {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        video.srcObject = null;
    });

    // Botón para alternar entre cámaras
    document.getElementById('reversePhoto').addEventListener('click', () => {
        useFrontCamera = !useFrontCamera;
        startCamera();
    });

    // Capturar y guardar la foto
    document.getElementById('savePhoto').addEventListener('click', () => {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataURL = canvas.toDataURL('image/png');
        imagenInput.value = dataURL;
        previewImage.src = dataURL;
    });

    // Validar si hay imagen antes de enviar
    document.querySelector('form').addEventListener('submit', (event) => {
        if (!imagenInput.value || (!imagenInput.value.startsWith('data:image/') && !imagenInput.value.startsWith('visitors/'))) {
            event.preventDefault();
            alert('Por favor, asegúrate de que haya una foto antes de enviar el formulario.');
        }
    });
</script>
@endsection
