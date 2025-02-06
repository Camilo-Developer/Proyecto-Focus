@extends('layouts.app2')
@section('title', 'CREACIÓN DE INGRESOS')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>CREACIÓN DE INGRESOS</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.employeeincomes.index')}}">LISTA DE INGRESOS</a></li>
                        <li class="breadcrumb-item active">CREACIÓN DE INGRESOS</li>
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

                        <form action="{{route('admin.employeeincomes.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="d-flex justify-content-end">
                                <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                            </div>
                            <div class="form-group">
                                <label for="visitor_id">VISITANTE: <span class="text-danger mt-1">* </span></label>
                                <select class="custom-select form-control-border" require name="visitor_id" id="visitor_id">
                                    <option value="">--SELECCIONAR--</option>
                                    @foreach($visitors as $visitor)
                                        <option value="{{$visitor->id}}" {{ old('visitor_id') == $visitor->id ? 'selected' : '' }}>
                                            {{mb_strtoupper($visitor->document_number) . ' - ' .  mb_strtoupper($visitor->name) . ' - (' .  mb_strtoupper($visitor->typeuser->name) .')' . ' (' .  mb_strtoupper($visitor->setresidencial->name) .')'}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('visitor_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            
                            @php
                                use Carbon\Carbon;
                                $currentDateTime = Carbon::now()->format('Y-m-d H:i');
                            @endphp

                            <div class="form-group">
                                <label for="admission_date">FECHA INGRESO: <span class="text-danger">*</span> </label>
                                <input 
                                    type="text" 
                                    name="admission_date" 
                                    value="{{ $currentDateTime }}" 
                                    class="form-control form-control-border" 
                                    id="admission_date" 
                                    readonly
                                >
                            </div>
                            @error('admission_date')
                                <span class="text-danger">{{$message}}</span>
                            @enderror


                            @if(auth()->user()->hasRole('ADMINISTRADOR'))
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
                                <label for="nota">NOTA:  </label>
                                <br>
                                <textarea name="nota" id="nota" cols="30" rows="10"></textarea>
                            </div>
                            @error('nota')
                            <span class="text-danger">{{$message}}</span>
                            @enderror


                            <div class="form-group">
                                <label for="nota">ELEMENTOS:  </label>

                                <div class="row" id="elements-container">
                                </div>

                                <div class="col-12 mt-3 d-flex justify-content-center">
                                    <button type="button" id="add-element" class="btn btn-primary rounded-circle">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>

                                <template id="element-template">
                                    <div class="col-12 element-item mt-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="card">
                                                            <div class="card-body text-center">
                                                                <video autoplay class="camera-view w-100" style="display: none;"></video>
                                                                <canvas class="photo-canvas w-100" style="display: none;"></canvas>
                                                                <img class="captured-photo img-fluid" src="" alt="Foto tomada" style="display: none;">
                                                                <input type="hidden" name="photos[]" class="photo-data">
                                                            </div>
                                                            <div class="card-footer">
                                                                <div class="d-flex justify-content-center">
                                                                    <button type="button" class="btn btn-primary open-camera">ABRIR CÁMARA</button>
                                                                    <button type="button" class="btn btn-success take-photo d-none">TOMAR FOTO</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="element-select">ELEMENTO:</label>
                                                            <select class="custom-select form-control-border element-select" name="elements[]">
                                                                @foreach($elements as $element)
                                                                    <option value="{{ $element->id }}">{{ mb_strtoupper($element->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="notaElement">NOTA:</label>
                                                        <textarea name="notaElement[]" class="form-control nota-textarea" cols="30" rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-3 d-flex justify-content-center">
                                                    <button type="button" class="btn btn-danger rounded-circle remove-element">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>


                                <script>
                                    $(document).ready(function() {
                                        let elementCounter = 0;

                                        // Añadir nuevos elementos
                                        $('#add-element').click(function() {
                                            elementCounter++;
                                            const template = $($('#element-template').html());
                                            $('#elements-container').append(template);

                                            // Inicializar Select2 y Summernote
                                            $('.element-select:last').select2({
                                                placeholder: "--SELECCIONAR --",
                                                allowClear: true
                                            });
                                            $('.nota-textarea:last').summernote({
                                                placeholder: 'NOTA',
                                                tabsize: 2,
                                                height: 100
                                            });
                                        });

                                        // Evento delegado para abrir la cámara
                                        $('#elements-container').on('click', '.open-camera', function() {
                                            const parentCard = $(this).closest('.card');
                                            const video = parentCard.find('.camera-view')[0];
                                            const takePhotoBtn = parentCard.find('.take-photo');
                                            const openCameraBtn = $(this);

                                            // Solicitar acceso a la cámara
                                            navigator.mediaDevices.getUserMedia({ video: true })
                                                .then(function(stream) {
                                                    video.srcObject = stream;
                                                    video.style.display = "block";

                                                    // Mostrar el botón "Tomar Foto" y ocultar el botón "Abrir Cámara"
                                                    takePhotoBtn.removeClass('d-none');
                                                    openCameraBtn.addClass('d-none');
                                                })
                                                .catch(function(error) {
                                                    console.error("Error al abrir la cámara:", error);
                                                    alert("No se pudo acceder a la cámara. Por favor, verifica los permisos.");
                                                });
                                        });

                                        // Evento delegado para tomar una foto
                                        $('#elements-container').on('click', '.take-photo', function() {
                                            const parentCard = $(this).closest('.card');
                                            const video = parentCard.find('.camera-view')[0];
                                            const canvas = parentCard.find('.photo-canvas')[0];
                                            const img = parentCard.find('.captured-photo');
                                            const openCameraBtn = parentCard.find('.open-camera');
                                            const photoDataInput = parentCard.find('.photo-data');

                                            // Dibujar el fotograma en el canvas
                                            canvas.width = video.videoWidth;
                                            canvas.height = video.videoHeight;
                                            canvas.getContext('2d').drawImage(video, 0, 0);

                                            // Convertir la imagen a base64 y guardarla en el campo oculto
                                            const photoBase64 = canvas.toDataURL('image/png');
                                            photoDataInput.val(photoBase64);

                                            // Detener la cámara
                                            const stream = video.srcObject;
                                            const tracks = stream.getTracks();
                                            tracks.forEach(track => track.stop());

                                            // Mostrar la foto y ocultar el video
                                            img.attr('src', photoBase64).show();
                                            video.style.display = "none";
                                            $(this).addClass('d-none');
                                            openCameraBtn.removeClass('d-none');
                                        });

                                        // Eliminar un elemento
                                        $('#elements-container').on('click', '.remove-element', function() {
                                            $(this).closest('.element-item').remove();
                                        });
                                    });

                                </script>

                            </div>


                            <div class="mx-3">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-success btn-lg">CREAR INGRESO</button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <a href="{{route('admin.employeeincomes.index')}}" class="btn btn-block mt-4 bg-gradient-danger btn-lg">CANCELAR</a>
                                    </div>
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
                $('#visitor_id').select2({
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
            $('#nota').summernote({
                placeholder: 'NOTA',
                tabsize: 2,
                height: 100
            });
        </script>


       
    </section>


@endsection
