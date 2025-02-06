@extends('layouts.app2')
@section('title', 'EDICIÓN DE INGRESOS')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>EDICIÓN DE INGRESOS</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.employeeincomes.index')}}">LISTA DE INGRESOS</a></li>
                        <li class="breadcrumb-item active">EDICIÓN DE INGRESOS</li>
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

                        <form action="{{route('admin.employeeincomes.update',$employeeincome)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex justify-content-end">
                                <span class="text-danger mt-1">* </span><span>CAMPOS REQUERIDOS.</span>
                            </div>

                            <div class="form-group">
                                <label>VISITANTES: <span class="text-danger">*</span></label>
                                <select id="visitor_id" name="visitor_id" class="form-control select2" style="width: 100%;">
                                    @foreach($visitors as $visitor)
                                        <option value="{{ $visitor->id }}" data-state="{{ $visitor->state_id }}"
                                            {{ $visitor->id == $employeeincome->visitor_id ? 'selected' : '' }} {{ old('visitor_id') == $visitor->id ? 'selected' : '' }}
                                        >
                                        {{mb_strtoupper($visitor->document_number) . ' - ' .  mb_strtoupper($visitor->name) . ' - (' .  mb_strtoupper($visitor->typeuser->name) .')' . ' (' .  mb_strtoupper($visitor->setresidencial->name) .')'}}

                                        </option>
                                    @endforeach
                                </select>
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


                            @if(auth()->user()->hasRole('ADMINISTRADOR'))
                                <div class="form-group">
                                    <label>CONJUNTO: <span class="text-danger">*</span></label>
                                    <select id="setresidencial_id" name="setresidencial_id" class="form-control select2" style="width: 100%;">
                                        @foreach($setresidencials as $setresidencial)
                                            <option value="{{ $setresidencial->id }}" data-state="{{ $setresidencial->state_id }}"
                                                {{ $setresidencial->id == $employeeincome->setresidencial_id ? 'selected' : '' }} {{ old('setresidencial_id') == $setresidencial->id ? 'selected' : '' }}
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
                                <label for="nota">NOTA:  </label>
                                <br>
                                <textarea name="nota" id="nota" cols="30" rows="10">
                                    {{$employeeincome->nota}}
                                </textarea>
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
                                                                    <video autoplay class="camera-view w-100" style="display: none;"></video>
                                                                    <canvas class="photo-canvas w-100" style="display: none;"></canvas>
                                                                    <img class="captured-photo img-fluid" src="{{ asset('storage/' . $element->pivot->imagen) }}" alt="Foto del elemento">
                                                                    <input type="hidden" name="photos[]" value="{{ $element->pivot->imagen }}" class="photo-data">
                                                                    <input type="hidden" class="original-photo" value="{{ asset('storage/' . $element->pivot->imagen) }}">
                                                                    <input type="hidden" name="emploElements[]" value="{{ $element->pivot->id }}">
                                                                </div>
                                                                <div class="card-footer d-flex justify-content-between">
                                                                    <button type="button" class="btn btn-primary open-camera">ABRIR CÁMARA</button>
                                                                    <button type="button" class="btn btn-success take-photo d-none">TOMAR FOTO</button>
                                                                    <button type="button" class="btn btn-danger cancel-camera d-none">CANCELAR</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="element-select">ELEMENTO:</label>
                                                                <select class="custom-select form-control-border element-select" name="elements[]">
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
                                                            <textarea name="notaElement[]" class="form-control nota-textarea" cols="30" rows="4">{{ $element->pivot->nota }}</textarea>
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
                                    @endforeach
                                </div>

                                <div class="col-12 mt-3 d-flex justify-content-center">
                                    <button type="button" id="add-element" class="btn btn-primary rounded-circle">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>

                                <!-- esto esta funcionando correctamente -->
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
                                    $(document).ready(function () {
                                        let elementCounter = 0;

                                        $('#add-element').click(function () {
                                            elementCounter++;
                                            const template = $($('#element-template').html());
                                            $('#elements-container').append(template);

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

                                        $('#elements-container').on('click', '.open-camera', function () {
                                            const parentCard = $(this).closest('.card');
                                            const video = parentCard.find('.camera-view')[0];
                                            const takePhotoBtn = parentCard.find('.take-photo');
                                            const cancelCameraBtn = parentCard.find('.cancel-camera');
                                            const capturedPhoto = parentCard.find('.captured-photo');

                                            // Ocultar la foto de la DB y solicitar acceso a la cámara
                                            capturedPhoto.hide();
                                            navigator.mediaDevices.getUserMedia({ video: true })
                                                .then(function (stream) {
                                                    video.srcObject = stream;
                                                    video.style.display = "block";

                                                    // Mostrar los botones "Tomar Foto" y "Cancelar", ocultar "Abrir Cámara"
                                                    takePhotoBtn.removeClass('d-none');
                                                    cancelCameraBtn.removeClass('d-none');
                                                    $(this).addClass('d-none');
                                                }.bind(this)) // Asegurar que el contexto de "this" sea el botón "Abrir Cámara"
                                                .catch(function (error) {
                                                    console.error("Error al abrir la cámara:", error);
                                                    alert("No se pudo acceder a la cámara. Por favor, verifica los permisos.");
                                                });
                                        });

                                        // Evento delegado para tomar una foto
                                        $('#elements-container').on('click', '.take-photo', function () {
                                            const parentCard = $(this).closest('.card');
                                            const video = parentCard.find('.camera-view')[0];
                                            const canvas = parentCard.find('.photo-canvas')[0];
                                            const img = parentCard.find('.captured-photo');
                                            const photoDataInput = parentCard.find('.photo-data');
                                            const cancelCameraBtn = parentCard.find('.cancel-camera');

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

                                            // Mostrar la foto tomada y ocultar el video y los botones
                                            img.attr('src', photoBase64).show();
                                            video.style.display = "none";
                                            $(this).addClass('d-none');
                                            cancelCameraBtn.addClass('d-none');
                                            parentCard.find('.open-camera').removeClass('d-none');
                                        });

                                        // Evento delegado para cancelar la cámara
                                        $('#elements-container').on('click', '.cancel-camera', function () {
                                            const parentCard = $(this).closest('.card');
                                            const video = parentCard.find('.camera-view')[0];
                                            const img = parentCard.find('.captured-photo');
                                            const originalPhoto = parentCard.find('.original-photo').val();

                                            // Detener la cámara
                                            const stream = video.srcObject;
                                            if (stream) {
                                                const tracks = stream.getTracks();
                                                tracks.forEach(track => track.stop());
                                            }

                                            // Mostrar la foto de la DB y ocultar el video y los botones
                                            img.attr('src', originalPhoto).show();
                                            video.style.display = "none";
                                            parentCard.find('.take-photo').addClass('d-none');
                                            $(this).addClass('d-none');
                                            parentCard.find('.open-camera').removeClass('d-none');
                                        });

                                        // Eliminar un elemento
                                        $('#elements-container').on('click', '.remove-element', function () {
                                            $(this).closest('.element-item').remove();
                                        });

                                        // Inicializar Select2 y Summernote para los elementos ya existentes
                                        $('.element-select').select2({
                                            placeholder: "--SELECCIONAR --",
                                            allowClear: true
                                        });
                                        $('.nota-textarea').summernote({
                                            placeholder: 'NOTA',
                                            tabsize: 2,
                                            height: 100
                                        });
                                    });
                                </script>




                            </div>


                            <div class="mx-3">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-block mt-4 bg-gradient-warning btn-lg">EDITAR INGRESO</button>
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
                $('#setresidencial_id').select2({
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
            $('#nota').summernote({
                placeholder: 'NOTA',
                tabsize: 2,
                height: 100
            });
        </script>


       
    </section>


@endsection
