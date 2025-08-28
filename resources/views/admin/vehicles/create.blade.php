@extends('layouts.app2')
@section('title', 'CREACIÓN DE VEHICULOS')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>CREACIÓN DE VEHICULOS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.vehicles.index')}}">LISTADO DE VEHICULOS</a></li>
                    <li class="breadcrumb-item active">CREACIÓN DE VEHICULOS</li>
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
                            <form action="{{route('admin.vehicles.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="d-flex justify-content-end">
                                    <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="name">FOTO DEL VEHICULO: <span class="text-danger">*</span> </label>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-photo">
                                                    TOMAR FOTO
                                                </button>
                                                <span class="mx-2 font-weight-bold">O</span>
                                                <input type="file" size="20" name="imagen_file" id="imagen_file" class="form-control form-control-border w-50"  accept="image/*">
                                            </div>
                                            <input type="hidden" name="imagen" id="imagen">


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
                                    <input type="text" name="placa" required class="form-control form-control-border" id="placa">
                                </div>
                                @error('placa')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                @if(auth()->user()->can('admin.permission.administrator') || auth()->user()->can('admin.permission.subadministrator'))
                                    <div class="form-group">
                                        <label for="state_id">ESTADO: <span class="text-danger mt-1">* </span></label>
                                        <select class="custom-select form-control-border" required name="state_id" id="state_id">
                                            <option value="">-- SELECCIONAR --</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{mb_strtoupper($state->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                @elseif(auth()->user()->can('admin.permission.goalie'))
                                    <div class="form-group">
                                        <label for="state_id">ESTADO: <span class="text-danger mt-1">* </span></label>
                                        <input type="text" disabled class="form-control form-control-border" id="state_id" value="ACTIVO">
                                        <input type="hidden" name="state_id" value="1">
                                    </div>
                                    @error('state_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                @endif


                                @if(auth()->user()->can('admin.permission.administrator'))
                                    <div class="form-group">
                                        <label for="setresidencial_id">CONJUNTO: <span class="text-danger">*</span></label>
                                        <select class="custom-select form-control-border" name="setresidencial_id" id="setresidencial_id">
                                            <option value="">--SELECCIONAR --</option>
                                            @foreach($setresidencials as $setresidencial)
                                                <option value="{{$setresidencial->id}}" {{ old('setresidencial_id') == $setresidencial->id ? 'selected' : '' }}>{{mb_strtoupper($setresidencial->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('setresidencial_id')
                                    <span class="text-danger">{{$message}}</span>
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
                                    <label for="units">UNIDADES: 
                                    </label>
                                    <select class="form-control" name="units[]" id="units" multiple>
                                        <option value="">-- SELECCIONAR --</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('units') == $unit->id ? 'selected' : '' }}>
                                                {{ mb_strtoupper($unit->name) . ' - (' . mb_strtoupper($unit->agglomeration->setresidencial->name) . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('units')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="visitors">VISITANTES: 
                                    </label>
                                    <select class="form-control" name="visitors[]" id="visitors" multiple>
                                        <option value="">-- SELECCIONAR --</option>
                                        @foreach($visitors as $visitor)
                                            <option value="{{ $visitor->id }}" {{ old('visitors') == $visitor->id ? 'selected' : '' }}>
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
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-success btn-lg">CREAR VEHICULO</button>
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
                    placeholder: "--SELECCIONAR--",  // Placeholder para el select
                    allowClear: true  // Permite limpiar la selección
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#setresidencial_id').select2({
                    placeholder: "--SELECCIONAR--",  // Placeholder para el select
                    allowClear: true  // Permite limpiar la selección
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#visitors').select2({
                    placeholder: "--SELECCIONAR--",  // Placeholder para el select
                    allowClear: true  // Permite limpiar la selección
                });
            });
        </script>

        <script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const previewImage = document.getElementById('previewImage');
    const imagenInput = document.getElementById('imagen');
    let stream = null;
    let useFrontCamera = true; // por defecto usa la cámara frontal

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

    $('#modal-photo').on('shown.bs.modal', startCamera);

    $('#modal-photo').on('hidden.bs.modal', () => {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        video.srcObject = null;
    });

    document.getElementById('reversePhoto').addEventListener('click', () => {
        useFrontCamera = !useFrontCamera;
        startCamera();
    });

    document.getElementById('savePhoto').addEventListener('click', () => {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataURL = canvas.toDataURL('image/png');
        imagenInput.value = dataURL;
        previewImage.src = dataURL;
        previewImage.style.display = 'block';
    });
</script>
@endsection
