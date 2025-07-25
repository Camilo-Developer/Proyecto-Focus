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
                                <label for="type_income">TIPO INGRESO: <span class="text-danger mt-1">* </span></label>
                                <select class="custom-select form-control-border" required name="type_income" id="type_income">
                                    <option value="">--SELECCIONAR--</option>
                                    <option value="1" {{ $employeeincome->type_income == 1 ? 'selected' : '' }}>PEATONAL</option>
                                    <option value="2" {{ $employeeincome->type_income == 2 ? 'selected' : '' }}>VEHICULAR</option>
                                </select>
                            </div>
                            @error('type_income')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                            <div class="form-group">
                                <label id="visitor_label">VISITANTES: <span class="text-danger">*</span></label>
                                <select id="visitor_id" name="visitor_id" class="form-control select2" style="width: 100%;">
                                    <option value="">--SELECCIONAR--</option>
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
                               <label id="vehicle_label">VEHICULO: <span class="text-danger">*</span></label>
                                <select id="vehicle_id" name="vehicle_id" class="form-control select2" style="width: 100%;">
                                    <option value="">--SELECCIONAR--</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" data-state="{{ $vehicle->state_id }}"
                                            {{ $vehicle->id == $employeeincome->vehicle_id ? 'selected' : '' }} {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}
                                        >
                                        {{mb_strtoupper($vehicle->placa) .  ' (' .  mb_strtoupper($vehicle->setresidencial->name) .')'}}

                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('vehicle_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <div class="form-group">
                                <label for="agglomeration_id">AGLOMERACIONES: <span class="text-danger mt-1">* </span></label>
                                <select class="custom-select form-control-border" name="agglomeration_id" id="agglomeration_id">
                                    @foreach($agglomerations as $agglomeration)
                                        <option value="{{ $agglomeration->id }}" data-state="{{ $agglomeration->state_id ?? 0 }}"
                                            {{ $agglomeration->id == $employeeincome->agglomeration_id ? 'selected' : '' }}>
                                            {{ mb_strtoupper($agglomeration->name) . ' - (' . mb_strtoupper($agglomeration->setresidencial->name) . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('agglomeration_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <div class="form-group">
                                <label for="unit_id">UNIDADES: <span class="text-danger mt-1">* </span></label>
                                <select class="custom-select form-control-border" name="unit_id" id="unit_id">
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" data-state="{{ $unit->state_id ?? 0 }}"
                                            {{ $unit->id == $employeeincome->unit_id ? 'selected' : '' }}>
                                            {{ mb_strtoupper($unit->name) . ' - (' . mb_strtoupper($unit->agglomeration->name ?? 'SIN AGLOMERACIÓN') . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('unit_id')
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

                            @if(auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('SUB_ADMINISTRADOR'))

                                <div class="form-group">
                                    <label for="user_id">PORTERO: </label>
                                    <select class="custom-select form-control-border" require name="user_id" id="user_id">
                                    <option value="">-- SELECCIONAR --</option>
                                            @foreach($users as $user)
                                                <option data-state="{{ $user->state_id }}" value="{{$user->id}}" {{ $user->id == $employeeincome->user_id ? 'selected' : '' }} {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ mb_strtoupper($user->name) . ' ' . mb_strtoupper($user->lastname) }}
                                                    @if($user->setresidencials->isNotEmpty()) 
                                                        - ({{ mb_strtoupper($user->setresidencials->first()->name) }})
                                                    @else
                                                        - (SIN CONJUNTO)
                                                    @endif
                                                </option>
                                            @endforeach

                                    </select>
                                </div>
                                @error('user_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                <div class="form-group">
                                    <label for="goal_id">PORTERÍA ENTRADA: </label>
                                    <select class="custom-select form-control-border" require name="goal_id" id="goal_id">
                                    <option value="">-- SELECCIONAR --</option>
                                        @foreach($goals as $goal)
                                            <option data-state="{{ $goal->state_id }}" value="{{$goal->id}}" {{ $goal->id == $employeeincome->goal_id ? 'selected' : '' }} {{ old('goal_id') == $goal->id ? 'selected' : '' }}>
                                                {{mb_strtoupper($goal->name) . ' - (' . mb_strtoupper($goal->setresidencial->name) . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('goal_id')
                                <span class="text-danger">{{$message}}</span>
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
                                                                    <video autoplay playsinline muted class="camera-view w-100" style="display: none;"></video>
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
                                                                    <button type="button" class="btn btn-warning flip-camera d-none">VOLTEAR CÁMARA</button>
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
                                                                <video autoplay playsinline muted class="camera-view w-100" style="display: none;"></video>
                                                                <canvas class="photo-canvas w-100" style="display: none;"></canvas>
                                                                <img class="captured-photo img-fluid" src="" alt="Foto tomada" style="display: none;">
                                                                <input type="hidden" name="photos[]" class="photo-data">
                                                            </div>
                                                            <div class="card-footer">
                                                                <div class="d-flex justify-content-center">
                                                                    <button type="button" class="btn btn-primary open-camera">ABRIR CÁMARA</button>
                                                                    <button type="button" class="btn btn-success take-photo d-none">TOMAR FOTO</button>
                                                                    <button type="button" class="btn btn-warning flip-camera d-none">VOLTEAR CÁMARA</button>
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
        const cameraConstraints = { video: { facingMode: "environment" } };

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
            const flipCameraBtn = parentCard.find('.flip-camera');
            const capturedPhoto = parentCard.find('.captured-photo');

            // Inicializamos facingMode si no está
            if (!parentCard.data('facingMode')) {
                parentCard.data('facingMode', 'environment');
            }

            const facingMode = parentCard.data('facingMode');

            capturedPhoto.hide();
            navigator.mediaDevices.getUserMedia({ video: { facingMode: facingMode } })
                .then(function (stream) {
                    video.srcObject = stream;
                    video.play();
                    video.style.display = "block";

                    takePhotoBtn.removeClass('d-none');
                    cancelCameraBtn.removeClass('d-none');
                    flipCameraBtn.removeClass('d-none');
                    parentCard.find('.open-camera').addClass('d-none');
                }.bind(this))
                .catch(function (error) {
                    console.error("Error al abrir la cámara:", error);
                    alert("No se pudo acceder a la cámara. Por favor, verifica los permisos.");
                });
        });

        $('#elements-container').on('click', '.take-photo', function () {
            const parentCard = $(this).closest('.card');
            const video = parentCard.find('.camera-view')[0];
            const canvas = parentCard.find('.photo-canvas')[0];
            const img = parentCard.find('.captured-photo');
            const photoDataInput = parentCard.find('.photo-data');
            const cancelCameraBtn = parentCard.find('.cancel-camera');
            const flipCameraBtn = parentCard.find('.flip-camera');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            const photoBase64 = canvas.toDataURL('image/png');
            photoDataInput.val(photoBase64);

            const stream = video.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());

            img.attr('src', photoBase64).show();
            video.style.display = "none";
            $(this).addClass('d-none');
            cancelCameraBtn.addClass('d-none');
            flipCameraBtn.addClass('d-none');
            parentCard.find('.open-camera').removeClass('d-none');
        });

        $('#elements-container').on('click', '.cancel-camera', function () {
            const parentCard = $(this).closest('.card');
            const video = parentCard.find('.camera-view')[0];
            const img = parentCard.find('.captured-photo');
            const originalPhoto = parentCard.find('.original-photo').val();
            const flipCameraBtn = parentCard.find('.flip-camera');

            const stream = video.srcObject;
            if (stream) {
                const tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
            }

            img.attr('src', originalPhoto).show();
            video.style.display = "none";
            parentCard.find('.take-photo').addClass('d-none');
            $(this).addClass('d-none');
            flipCameraBtn.addClass('d-none');
            parentCard.find('.open-camera').removeClass('d-none');
        });

        $('#elements-container').on('click', '.flip-camera', function () {
            const parentCard = $(this).closest('.card');
            const video = parentCard.find('.camera-view')[0];
            const facingMode = parentCard.data('facingMode') === 'environment' ? 'user' : 'environment';

            const currentStream = video.srcObject;
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
            }

            parentCard.data('facingMode', facingMode);
            navigator.mediaDevices.getUserMedia({ video: { facingMode: facingMode } })
                .then(function (stream) {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function (error) {
                    console.error("Error al cambiar la cámara:", error);
                    alert("No se pudo cambiar la cámara.");
                });
        });

        $('#elements-container').on('click', '.remove-element', function () {
            $(this).closest('.element-item').remove();
        });

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
                $('#vehicle_id').select2({
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
    $(document).ready(function () {
        function toggleRequiredFields() {
            const typeIncome = $('#type_income').val();

            if (typeIncome == '1') { // PEATONAL
                $('#visitor_id').attr('required', true);
                $('#vehicle_id').removeAttr('required');

                $('#visitor_label span').show();
                $('#vehicle_label span').hide();
            } else if (typeIncome == '2') { // VEHICULAR
                $('#vehicle_id').attr('required', true);
                $('#visitor_id').removeAttr('required');

                $('#vehicle_label span').show();
                $('#visitor_label span').hide();
            } else {
                // Ninguno seleccionado
                $('#visitor_id, #vehicle_id').removeAttr('required');
                $('#visitor_label span, #vehicle_label span').hide();
            }
        }

        // Ejecutar al cargar
        toggleRequiredFields();

        // Ejecutar al cambiar
        $('#type_income').on('change', function () {
            toggleRequiredFields();
        });
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

<script>
            $(document).ready(function() {
                $('#user_id').select2({
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
                $('#goal_id').select2({
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
    function formatOption(option) {
        if (!option.id) return option.text; // Para la opción por defecto "-- SELECCIONAR --"

        const stateId = $(option.element).data('state');
        const isActive = stateId == 1; // Suponiendo que 1 es activo

        const icon = isActive
            ? `<span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: green; margin-right: 5px;"></span>`
            : `<span style="color: red; margin-right: 5px;">✖</span>`;

        return $(`<span>${icon}${option.text}</span>`);
    }

    $('#agglomeration_id').select2({
        placeholder: "--SELECCIONAR--",
        allowClear: true,
        templateResult: formatOption,
        templateSelection: function(option) {
            return option.text;
        }
    });

    $('#unit_id').select2({
        placeholder: "--SELECCIONAR--",
        allowClear: true,
        templateResult: formatOption,
        templateSelection: function(option) {
            return option.text;
        }
    });

    let selectedUnitId = "{{ $employeeincome->unit_id ?? '' }}"; // Si es null, lo deja vacío

    // Cargar unidades dinámicamente al cambiar la aglomeración
    $('#agglomeration_id').on('change', function() {
        let agglomerationId = $(this).val();
        let unitSelect = $('#unit_id');

        // Restablecer el select con "--SELECCIONAR--"
        unitSelect.empty().append('<option value="">--SELECCIONAR--</option>');

        if (agglomerationId) {
            $.ajax({
                url: `/admin/units-by-agglomeration/${agglomerationId}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    response.forEach(unit => {
                        let unitName = unit.name.toUpperCase();
                        let agglomerationName = unit.agglomeration ? unit.agglomeration.name.toUpperCase() : "SIN AGLOMERACIÓN";
                        let selected = unit.id == selectedUnitId ? 'selected' : '';
                        let stateAttr = unit.state_id ?? 0;

                        unitSelect.append(`<option value="${unit.id}" data-state="${stateAttr}" ${selected}>${unitName} - (${agglomerationName})</option>`);
                    });

                    // Reaplicar Select2 para que tome los cambios en las opciones
                    unitSelect.select2({
                        templateResult: formatOption,
                        templateSelection: function(option) {
                            return option.text;
                        }
                    });

                    // Si no hay unidad seleccionada, dejarlo en "--SELECCIONAR--"
                    if (!selectedUnitId) {
                        unitSelect.val("").trigger("change");
                    }
                },
                error: function() {
                    alert('Ocurrió un error al cargar las unidades.');
                }
            });
        } else {
            // Si no hay aglomeración seleccionada, resetear unidad
            unitSelect.val("").trigger("change");
        }
    });

    // Cargar unidades automáticamente si ya hay una aglomeración seleccionada
    if ($('#agglomeration_id').val()) {
        $('#agglomeration_id').trigger('change');
    }
});


</script>

       
    </section>


@endsection
