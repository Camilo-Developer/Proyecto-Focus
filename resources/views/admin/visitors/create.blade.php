@extends('layouts.app2')
@section('title', 'CREACIÓN DE VISITANTES')
@section('content')
<style>
                    .card-warningds.card-outline {
                        border-top: 3px solid #F9D639!important;
                    }
                </style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>CREACIÓN DE VISITANTES</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.visitors.index')}}">LISTA DE VISITANTES</a></li>
                        <li class="breadcrumb-item active">CREACIÓN DE VISITANTES</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid" >
            <div class="row">
                <div class="col-12 col-md-9">
                    <div class="card card-default color-palette-box">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{route('admin.visitors.store')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <div class="d-flex justify-content-end">
                                            <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                                        </div>


                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="name">FOTO DEL VISITANTE: <span class="text-danger">*</span> </label>
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-photo">
                                                        TOMAR FOTO
                                                    </button>
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
                                            <label for="name">NOMBRE: <span class="text-danger">*</span> </label>
                                            <input type="text" name="name" required class="form-control form-control-border" id="name" placeholder="NOMBRE COMPLETO">
                                        </div>
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="phone">TELÉFONO:</label>
                                            <input type="number" name="phone"  class="form-control form-control-border" id="phone" placeholder="TELÉFONO">
                                        </div>
                                        @error('phone')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="address">DIRECCIÓN: </label>
                                            <input  type="text" name="address"  class="form-control form-control-border" id="address" placeholder="DIRECCIÓN">
                                        </div>
                                        @error('address')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="document_number">NÚMERO DE DOCUMENTO: <span class="text-danger">*</span> </label>
                                            <input type="number" name="document_number" required class="form-control form-control-border" id="document_number" placeholder="NÚMERO DE DOCUMENTO">
                                        </div>
                                        @error('document_number')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        @if(auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('SUB_ADMINISTRADOR'))
                                            <div class="form-group">
                                                <label for="confirmation">CONFIRMACIÓN: <span class="text-danger mt-1">* </span></label>
                                                <select required class="custom-select form-control-border" name="confirmation" id="confirmation">
                                                    <option value="">--SELECCIONAR--</option>
                                                    <option value="1">SI</option>
                                                    <option value="2">NO</option>
                                                </select>
                                            </div>
                                            @error('confirmation')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        @elseif(auth()->user()->hasRole('PORTERO'))
                                            <div class="form-group">
                                                <label for="confirmation">CONFIRMACIÓN: <span class="text-danger mt-1">* </span></label>
                                                <select disabled  class="custom-select form-control-border" id="confirmation">
                                                    <option value="2" selected>NO</option>
                                                </select>
                                                <input type="hidden" name="confirmation" value="2">
                                            </div>
                                            @error('confirmation')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        @endif

                                        @if(auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('SUB_ADMINISTRADOR'))
                                            <div class="form-group">
                                                <label for="state_id">ESTADO: <span class="text-danger mt-1">* </span></label>
                                                <select required class="custom-select form-control-border" name="state_id" id="state_id">
                                                    <option value="">--SELECCIONAR--</option>
                                                    @foreach($states as $state)
                                                        <option value="{{$state->id}}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{mb_strtoupper($state->name)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('state_id')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        @elseif(auth()->user()->hasRole('PORTERO'))
                                            <div class="form-group">
                                                <label for="state_id">ESTADO: <span class="text-danger mt-1">* </span></label>
                                                <input type="text" disabled class="form-control form-control-border" id="state_id" value="ACTIVO">
                                                <input type="hidden" name="state_id" value="1">
                                            </div>
                                            @error('state_id')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        @endif


                                        <div class="form-group">
                                            <label for="type_user_id">TIPO DE USUARIO: <span class="text-danger mt-1">* </span></label>
                                            <select required class="custom-select form-control-border" name="type_user_id" id="type_user_id">
                                                <option value="">--SELECCIONAR --</option>
                                                @foreach($typeusers as $typeuser)
                                                    <option value="{{$typeuser->id}}" {{ old('type_user_id') == $typeuser->id ? 'selected' : '' }}>{{mb_strtoupper($typeuser->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('type_user_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        @if(auth()->user()->hasRole('ADMINISTRADOR'))
                                            <div class="form-group">
                                                <label for="setresidencial_id">CONJUNTO: <span class="text-danger">*</span></label>
                                                <select required class="custom-select form-control-border" name="setresidencial_id" id="setresidencial_id">
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
                                            <label for="units">UNIDADES:</label>
                                            <select class="custom-select form-control-border" name="units[]" multiple id="units">
                                                <option value="">--SELECCIONAR --</option>
                                                @foreach($units as $unit)
                                                    <option value="{{$unit->id}}" {{ old('units') == $unit->id ? 'selected' : '' }}>{{mb_strtoupper($unit->name) . ' - (' . mb_strtoupper($unit->agglomeration->setresidencial->name) . ')'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('units')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="form-group">
                                            <label for="company_id">EMPRESA:</label>
                                            <select class="custom-select form-control-border" name="company_id" id="company_id">
                                                <option value="">--SELECCIONAR --</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}" {{ old('company_id') == $company->id ? 'selected' : '' }}>{{mb_strtoupper($company->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('company_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                       

                                        <div class="form-group">
                                            <label for="vehicles">VEHICULOS:</label>
                                            <select class="custom-select form-control-border" name="vehicles[]" multiple id="vehicles">
                                                <option value="">--SELECCIONAR --</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{$vehicle->id}}" {{ old('vehicles') == $vehicle->id ? 'selected' : '' }}>{{mb_strtoupper($vehicle->placa) . ' - (' . mb_strtoupper($vehicle->setresidencial->name) . ')'}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('vehicles')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                        <div class="mx-3">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <button type="submit" class="btn btn-block mt-4 bg-gradient-success btn-lg">CREAR VISITANTE</button>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <a href="{{route('admin.visitors.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card card-warningds card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img id="previewImage" class="profile-user-img img-fluid img-circle" src="{{url('Imagenes2/user-default.jpg')}}" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center" id="previewName">NOMBRE</h3>
                            <hr>

                            <strong><i class="fas fa-phone-alt mr-1"></i> TELÉFONO</strong>
                            <p class="text-muted" id="previewPhone">TELÉFONO</p>
                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> DIRECCIÓN</strong>
                            <p class="text-muted" id="previewAddress">DIRECCIÓN</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#type_user_id').select2({
                placeholder: "--SELECCIONAR --",
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#setresidencial_id').select2({
                placeholder: "--SELECCIONAR --",
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#company_id').select2({
                placeholder: "--SELECCIONAR --",
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#units').select2({
                placeholder: "--SELECCIONAR --",
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#vehicles').select2({
                placeholder: "--SELECCIONAR --",
                allowClear: true
            });
        });
    </script>
    <script>
        document.getElementById('name').addEventListener('input', function () {
            document.getElementById('previewName').textContent = this.value || 'NOMBRE';
        });

        document.getElementById('phone').addEventListener('input', function () {
            document.getElementById('previewPhone').textContent = this.value || 'TELÉFONO';
        });

        document.getElementById('address').addEventListener('input', function () {
            document.getElementById('previewAddress').textContent = this.value || 'DIRECCIÓN';
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
