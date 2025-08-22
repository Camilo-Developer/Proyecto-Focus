@extends('layouts.app2')
@section('title', 'CREACIÓN DE SALIDA')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h3>CREACIÓN DE SALIDA</h3>
                </div>
                <div class="col-sm-7">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.employeeincomes.index')}}">LISTA DE INGRESOS</a></li>
                        <li class="breadcrumb-item active">CREACIÓN DE SALIDA</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid" >
            <div class="row">
                <div class="col-12 col-md-4">
                    @if($identi == 'p')

                        <div class="card card-warning card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="{{asset('storage/'.$employeeincome->visitor->imagen)}}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{mb_strtoupper($employeeincome->visitor->name)}}</h3>

                                <p class="text-muted text-center">{{mb_strtoupper($employeeincome->visitor->typeuser->name)}}</p>

                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small">
                                        <span class="fa-li"><i class="fas fa-lg fa-map"></i></span> <b>DIRECCIÓN:</b> {{ mb_strtoupper($employeeincome->visitor->address) }}
                                    </li>
                                    <li class="small">
                                        <span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> <b>TELÉFONO:</b> {{ mb_strtoupper($employeeincome->visitor->phone) }}
                                    </li>
                                    <li class="small">
                                        <span class="fa-li"><i class="fas fa-lg fa-address-card"></i></span> <b>NÚMERO DE DOCUMENTO:</b> {{ mb_strtoupper($employeeincome->visitor->document_number) }}
                                    </li>
                                    <li class="small">
                                        <span class="fa-li"><i class="fas fa-lg fa-check-square"></i></span> <b>CONFIRMACIÓN:</b> @if($employeeincome->visitor->confirmation == 1) SI @elseif($employeeincome->visitor->confirmation == 2) NO @endif
                                    </li>
                                    <li class="small">
                                        <span class="fa-li"><i class="fas fa-lg fa-ban"></i></span> <b>ESTADO:</b> {{ mb_strtoupper($employeeincome->visitor->state->name) }}
                                    </li>
                                    <li class="small">
                                        <span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <b>CONJUNTO:</b> {{ mb_strtoupper($employeeincome->visitor->setresidencial->name) }}
                                    </li>
                                    <li class="small">
                                        <span class="fa-li"><i class="fas fa-lg fa-map-marker-alt"></i></span> <b>UNIDADES:
                                        </b> 
                                        @if($employeeincome->visitor->units->isNotEmpty())    
                                            @foreach($employeeincome->visitor->units as $unit)
                                                {{mb_strtoupper($unit->name)}}
                                            @endforeach
                                        @else
                                            SIN UNIDADES
                                        @endif
                                    </li>
                                    <li class="small">
                                        <span class="fa-li"><i class="fas fa-lg fa-truck"></i></span>
                                        <b>EMPRESA:</b> {{ mb_strtoupper($employeeincome->visitor->company?->name ?? 'SIN EMPRESA') }}
                                    </li>
                                </ul>

                                <a href="{{route('admin.visitors.show',$employeeincome->visitor_id)}}" class="btn btn-dark btn-block mt-3"><b>VER MÁS</b></a>
                            </div>
                        </div>
                    @else
                        <div class="card card-warning card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{asset('storage/'. $employeeincome->vehicle->imagen)}}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{mb_strtoupper($employeeincome->vehicle->placa)}}</h3>

                             <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small">
                                    <span class="fa-li"><i class="fas fa-lg fa-ban"></i></span> <b>ESTADO:</b> {{ mb_strtoupper($employeeincome->vehicle->state->name) }}
                                </li>
                                <li class="small">
                                    <span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <b>CONJUNTO:</b> {{ mb_strtoupper($employeeincome->vehicle->setresidencial->name) }}
                                </li>
                            </ul>
                            
                            <a href="{{route('admin.vehicles.show',$employeeincome->vehicle_id)}}" class="btn btn-dark btn-block mt-3"><b>VER MÁS</b></a>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-12 col-md-8">
                    <div class="card card-dark card-outline">
                        <div class="card-body box-profile">
                            <div class="row">
                                @if($identi == 'p')
                                    <div class="col-12">
                                        <h2 class="lead"><b>VEHICULOS RELACIONADOS</b></h2>
                                    </div>

                                    @if($employeeincome->visitor->vehicles->isNotEmpty())        
                                        @foreach($employeeincome->visitor->vehicles as $index => $vehicle)
                                            <div class="col-12 col-md-4">
                                                <div class="card" >
                                                    <img 
                                                        src="{{ asset('storage/' . $vehicle->imagen) }}" 
                                                        class="card-img-top" 
                                                        alt="VEHICULO"
                                                        style="cursor: zoom-in;"
                                                        onclick="expandImage('{{ asset('storage/' . $vehicle->imagen) }}')"
                                                    />
                                                    <div class="card-body">
                                                        <p class="card-text text-center">
                                                            <b>{{ mb_strtoupper($vehicle->placa) }}</b>
                                                        </p>
                                                        <p class="card-text"><b>ESTADO:</b> {{ mb_strtoupper($vehicle->state->name) }}</p>
                                                        @if(!$exitEntry)
                                                        <div class="d-flex justify-content-center">
                                                            <button 
                                                                type="button"
                                                                class="btn {{ $index % 2 === 0 ? 'btn-warning' : 'btn-dark' }} select-vehicle-btn" 
                                                                data-vehicle-id="{{ $vehicle->id }}"
                                                                disabled
                                                            >
                                                                {{ $idVehicle == $vehicle->id ? 'DESMARCAR' : 'SELECCIONAR' }}
                                                            </button>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                    <div class="col-12 d-flex justify-content-center">
                                        SIN VEHICULOS
                                    </div>
                                    @endif

                                @else
                                    <div class="col-12">
                                        <h2 class="lead"><b>VISITANTES RELACIONADOS</b></h2>
                                    </div>
                                     @if($employeeincome->vehicle->visitors->isNotEmpty())        
                                        @foreach($employeeincome->vehicle->visitors as $index => $visitor)
                                            <div class="col-12 col-md-4">
                                                <div class="card" >
                                                    <img 
                                                        src="{{ asset('storage/' . $visitor->imagen) }}" 
                                                        class="card-img-top" 
                                                        alt="VISITANTE"
                                                        style="cursor: zoom-in;"
                                                        onclick="expandImage('{{ asset('storage/' . $visitor->imagen) }}')"
                                                    />
                                                    <div class="card-body">
                                                        <p class="card-text text-center">
                                                            <b>{{ mb_strtoupper($visitor->name) }}</b>
                                                        </p>
                                                        <p class="card-text"><b>ESTADO:</b> {{ mb_strtoupper($visitor->state->name) }}</p>
                                                        <div class="d-flex justify-content-center">
                                                          
                                                            <button 
                                                                type="button"
                                                                class="btn {{ $index % 2 === 0 ? 'btn-warning' : 'btn-dark' }} select-vehicle-btn" 
                                                                data-vehicle-id="{{ $visitor->id }}"
                                                                disabled
                                                            >
                                                                {{ $idVisitor == $visitor->id ? 'DESMARCAR' : 'SELECCIONAR' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 d-flex justify-content-center">
                                            SIN VISITANTES
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <h3>DATOS DEL ÚLTIMO INGRESO</h3>
                </div>

                <div class="col-12">
                    <div class="card card-dark card-outline">
                        <div class="card-body box-profile">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <p><b>TIPO INGRESO:</b>
                                        <br>
                                        @if($employeeincome->type_income == 1)
                                            PEATONAL
                                        @else
                                            VEHICULAR
                                        @endif
                                    </p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <p><b>FECHA INGRESO:</b><br>
                                    {{\Carbon\Carbon::parse($employeeincome->admission_date)->translatedFormat('d M Y h:i A')}}
                                    </p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <p><b>PORTERÍA ENTRADA:</b><br>
                                    {{mb_strtoupper($employeeincome->goal->name ?? 'SIN PORTERÍA')}}
                                    </p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <p><b>PORTERO ENTRADA:</b><br>
                                        {{mb_strtoupper($employeeincome->user->name ?? 'SIN NOMBRE') . mb_strtoupper($employeeincome->user->lastname ?? '')}}
                                    </p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <p><b>CONJUNTO:</b>
                                        <br>
                                        {{mb_strtoupper($employeeincome->setresidencial->name ?? 'SIN CONJUNTO')}}
                                    </p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <p><b>AGLOMERACIÓN:</b>
                                        <br>
                                        {{mb_strtoupper($employeeincome->agglomeration->name ?? 'SIN AGLOMEREACIÓN')}}
                                    </p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <p><b>UNIDAD:</b><br>
                                        {{mb_strtoupper($employeeincome->unit->name ?? 'SIN UNIDAD')}}
                                    </p>
                                </div>
                                
                                
                                @if($identi == 'p')
                                    <div class="col-12 col-md-3">
                                        <p>
                                            <b>INGRESO VEHICULO:</b> <br> 
                                            {{mb_strtoupper($employeeincome->vehicle->placa ?? 'NO')}}
                                        </p>
                                    </div>
                                @else
                                    <div class="col-12 col-md-3">
                                        <p>
                                            <b>VISITANTE:</b><br>
                                            {{mb_strtoupper($employeeincome->visitor->name ?? 'SIN VISITANTE')}}
                                        </p>
                                    </div>
                                @endif
                                <div class="col-12 mt-2" style="background: #d4d4d4!important;border-radius: 5px;">
                                    <p class="mt-1"><b>NOTA:</b></p>
                                    {!! $employeeincome->nota ?? 'SIN NOTA' !!}
                                </div>
                                <div class="col-12">
                                    <p class="mt-1"><b>ELEMENTOS:</b></p>
                                    <div class="row">
                                        @forelse($employeeincome->elements as $element)
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12 col-md-3 d-flex align-items-center">
                                                                <img src="{{ asset('storage/' . $element->pivot->imagen) }}" alt="Imagen elemento"
                                                                    style="width: 100%; height: auto; object-fit: contain; display: block;">
                                                            </div>
                                                            <div class="col-12 col-md-9">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <p><b>ELEMENTO:</b></p>
                                                                        <span>{{ mb_strtoupper($element->name ?? 'SIN ELEMENTO') }}</span>
                                                                    </div>
                                                                    <div class="col-12 mt-2" style="background: #d4d4d4!important; border-radius: 5px;">
                                                                        <p class="mt-1"><b>NOTA:</b></p>
                                                                        {!! $element->pivot->nota ?? 'SIN NOTA' !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <span class="text-uppercase">SIN ELEMENTO</span>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                        </div>
                    </div>
                        @can('admin.employeeincomes.edit')
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <a href="{{route('admin.employeeincomes.edit',$employeeincome)}}" class="btn btn-warning"><i class="fa fa-edit"></i> EDITAR INGRESO</a>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="col-12">
                    <h3>DATOS DE LA SALIDA</h3>
                </div>

                <div class="col-12">
                    <div class="card card-warning card-outline">
                        @php
                            use Carbon\Carbon;
                            $currentDateTime = Carbon::now()->format('Y-m-d H:i');
                        @endphp
                        @if($exitEntry)
                            <div class="card-body box-profile">
                                <div class="row">
                                        <div class="col-12 col-md-4">
                                            <p><b>TIPO SALIDA:</b>
                                                <br>
                                                @if($exitEntry->type_income == 1)
                                                    PEATONAL
                                                @else
                                                    VEHICULAR
                                                @endif
                                            </p>
                                        </div>
                                    <div class="col-12 col-md-4">
                                        <p><b>FECHA SALIDA:</b><br>
                                            {{\Carbon\Carbon::parse($exitEntry->departure_date)->translatedFormat('d M Y h:i A')}}
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <p><b>PORTERÍA SALIDA:</b><br>
                                            {{mb_strtoupper($exitEntry->goal->name ?? 'SIN PORTERÍA')}}
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <p><b>PORTERO SALIDA:</b><br>
                                            {{mb_strtoupper($exitEntry->user->name ?? 'SIN PORTERO') . ' ' . mb_strtoupper($exitEntry->user->lastname ?? '')}}
                                        </p>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <p><b>SALIDA VEHICULO:</b><br>
                                            {{mb_strtoupper($exitEntry->vehicle->placa ?? 'NO')}}
                                        </p>
                                    </div>
                                    
                                    <div class="col-12 mt-2" style="background: #d4d4d4!important;border-radius: 5px;">
                                        <p class="mt-1"><b>NOTA:</b></p>
                                        {!! $exitEntry->nota ?? 'SIN NOTA' !!}
                                    </div>

                                    <div class="col-12">
                                        <p class="mt-1"><b>ELEMENTOS:</b></p>
                                        <div class="row">
                                            @forelse($exitEntry->elements as $elementEntry)
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12 col-md-3 d-flex align-items-center">
                                                                    <img src="{{ asset('storage/' . $elementEntry->pivot->imagen) }}" alt="Imagen elemento"
                                                                    style="width: 100%; height: auto; object-fit: contain; display: block;">
                                                                </div>

                                                                <div class="col-12 col-md-9">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <p><b>ELEMENTO:</b></p>
                                                                            <span>{{ mb_strtoupper($elementEntry->name ?? 'SIN ELEMENTO') }}</span>
                                                                        </div>
                                                                        <div class="col-12 mt-2" style="background: #d4d4d4!important; border-radius: 5px;">
                                                                            <p class="mt-1"><b>NOTA:</b></p>
                                                                            {!! $elementEntry->pivot->nota ?? 'SIN NOTA' !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <span class="text-uppercase">SIN ELEMENTO</span>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form action="{{route('admin.employeeincomes.createExit.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="card-body box-profile">
                                    <input type="hidden" name="employeeincome_id" value="{{$employeeincome->id}}">
                                    <input type="hidden" name="visitor_id" value="{{$idVisitor}}">
                                    <input type="hidden" id="vehicle_id" name="vehicle_id" value="{{$idVehicle}}">
                                    <input type="hidden" id="type_income" name="type_income" value="{{ $idVehicle != null ? 2 : 1 }}">
                                

                                    <div class="form-group">
                                        <label for="departure_date">FECHA SALIDA: <span class="text-danger">*</span> </label>
                                        <input 
                                            type="text" 
                                            name="departure_date" 
                                            value="{{ $currentDateTime }}" 
                                            class="form-control form-control-border" 
                                            id="departure_date" 
                                            readonly
                                        >
                                    </div>
                                    @error('departure_date')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror

                                    @if(auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('SUB_ADMINISTRADOR'))

                                        <div class="form-group">
                                            <label for="user_id">PORTERO: </label>
                                            <select class="custom-select form-control-border"  name="user_id" id="user_id">
                                                <option value="">--SELECCIONAR--</option>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                                            <label for="goal_id">PORTERÍA SALIDA: </label>
                                            <select class="custom-select form-control-border"  name="goal_id" id="goal_id">
                                                <option value="">--SELECCIONAR--</option>
                                                @foreach($goals as $goal)
                                                    <option value="{{$goal->id}}" {{ old('goal_id') == $goal->id ? 'selected' : '' }}>
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
                                                                    <video autoplay playsinline muted class="camera-view w-100" style="display: none;"></video>
                                                                    <canvas class="photo-canvas w-100" style="display: none;"></canvas>
                                                                    <img class="captured-photo img-fluid" src="" alt="Foto tomada" style="display: none;">
                                                                    <input type="hidden" name="photos[]" class="photo-data">
                                                                </div>
                                                                <div class="card-footer">
                                                                    <div class="d-flex justify-content-center">
                                                                        <button type="button" class="btn btn-primary open-camera">ABRIR CÁMARA</button>
                                                                        <button type="button" class="btn btn-warning mx-2 reverse-camera d-none">VOLTEAR CÁMARA</button>
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
                                        let facingMode = 'user'; // 'user' = frontal, 'environment' = trasera

                                        $(document).ready(function () {
                                            let elementCounter = 0;

                                            // Añadir nuevo elemento
                                            $('#add-element').click(function () {
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

                                            // Abrir cámara
                                            $('#elements-container').on('click', '.open-camera', function () {
                                                const parentCard = $(this).closest('.card');
                                                const video = parentCard.find('.camera-view')[0];
                                                const takePhotoBtn = parentCard.find('.take-photo');
                                                const openCameraBtn = $(this);
                                                const reverseCameraBtn = parentCard.find('.reverse-camera');
                                                const img = parentCard.find('.captured-photo');
                                                const canvas = parentCard.find('.photo-canvas')[0];
                                                const photoDataInput = parentCard.find('.photo-data');

                                                // Limpiar vista anterior
                                                img.hide();
                                                canvas.style.display = "none";
                                                photoDataInput.val('');

                                                // Abrir la cámara
                                                navigator.mediaDevices.getUserMedia({ video: { facingMode: facingMode } })
                                                    .then(function (stream) {
                                                        video.srcObject = stream;
                                                        video.play();
                                                        video.style.display = "block";

                                                        takePhotoBtn.removeClass('d-none');
                                                        reverseCameraBtn.removeClass('d-none');
                                                        openCameraBtn.addClass('d-none');
                                                    })
                                                    .catch(function (error) {
                                                        console.error("Error al abrir la cámara:", error);
                                                        alert("No se pudo acceder a la cámara. Verifica los permisos.");
                                                    });
                                            });

                                            // Voltear cámara
                                            $('#elements-container').on('click', '.reverse-camera', function () {
                                                const parentCard = $(this).closest('.card');
                                                const video = parentCard.find('.camera-view')[0];
                                                const stream = video.srcObject;

                                                // Detener cámara actual
                                                if (stream) {
                                                    stream.getTracks().forEach(track => track.stop());
                                                }

                                                // Cambiar orientación
                                                facingMode = (facingMode === 'user') ? 'environment' : 'user';

                                                // Reabrir cámara
                                                navigator.mediaDevices.getUserMedia({ video: { facingMode: facingMode } })
                                                    .then(function (newStream) {
                                                        video.srcObject = newStream;
                                                        video.play();
                                                    })
                                                    .catch(function (error) {
                                                        console.error("No se pudo cambiar de cámara:", error);
                                                        alert("Error al intentar cambiar de cámara.");
                                                    });
                                            });

                                            // Tomar foto
                                            $('#elements-container').on('click', '.take-photo', function () {
                                                const parentCard = $(this).closest('.card');
                                                const video = parentCard.find('.camera-view')[0];
                                                const canvas = parentCard.find('.photo-canvas')[0];
                                                const img = parentCard.find('.captured-photo');
                                                const openCameraBtn = parentCard.find('.open-camera');
                                                const reverseCameraBtn = parentCard.find('.reverse-camera');
                                                const photoDataInput = parentCard.find('.photo-data');

                                                // Ajustar tamaño del canvas
                                                canvas.width = video.videoWidth;
                                                canvas.height = video.videoHeight;

                                                // Dibujar imagen del video
                                                canvas.getContext('2d').drawImage(video, 0, 0);

                                                // Obtener base64 de la imagen
                                                const photoBase64 = canvas.toDataURL('image/png');
                                                photoDataInput.val(photoBase64);

                                                // Detener cámara
                                                const stream = video.srcObject;
                                                if (stream) {
                                                    stream.getTracks().forEach(track => track.stop());
                                                }

                                                // Ocultar video y botones
                                                video.style.display = "none";
                                                canvas.style.display = "none";
                                                $(this).addClass('d-none');
                                                reverseCameraBtn.addClass('d-none');
                                                openCameraBtn.removeClass('d-none');

                                                // Mostrar imagen
                                                img.attr('src', photoBase64).show();
                                            });

                                            // Eliminar un elemento y detener cámara si está activa
                                            $('#elements-container').on('click', '.remove-element', function () {
                                                const parentCard = $(this).closest('.card');
                                                const video = parentCard.find('.camera-view')[0];
                                                const stream = video.srcObject;

                                                if (stream) {
                                                    stream.getTracks().forEach(track => track.stop());
                                                }

                                                $(this).closest('.element-item').remove();
                                            });
                                        });
                                    </script>

                                </div>

                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-dark"><i class="fa fa-check"></i> GUARDAR SALIDA</button>
                                </div>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
            
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>

    <script>
            $(document).ready(function() {
                $('#user_id').select2({
                    placeholder: "--SELECCIONAR --",
                    allowClear: true
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#goal_id').select2({
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
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.select-vehicle-btn');
        const inputVehicle = document.getElementById('vehicle_id');
        const inputType = document.getElementById('type_income');

        buttons.forEach(btn => {
            btn.addEventListener('click', function () {
                const selectedId = btn.getAttribute('data-vehicle-id');
                const currentId = inputVehicle.value;

                if (selectedId === currentId) {
                    // DESMARCAR
                    inputVehicle.value = '';
                    inputType.value = 1;

                    // Restaurar todos los botones
                    buttons.forEach(b => {
                        b.disabled = false;
                        b.textContent = 'SELECCIONAR';
                        b.classList.remove('btn-success');
                    });
                } else {
                    // MARCAR este y deshabilitar los otros
                    inputVehicle.value = selectedId;
                    inputType.value = 2;

                    buttons.forEach(b => {
                        const bId = b.getAttribute('data-vehicle-id');
                        if (bId !== selectedId) {
                            b.disabled = true;
                            b.textContent = 'SELECCIONAR';
                            b.classList.remove('btn-success');
                        } else {
                            b.disabled = false;
                            b.textContent = 'DESMARCAR';
                            b.classList.add('btn-success');
                        }
                    });
                }
            });
        });

        // Preselección si llega desde URL
        const preselected = inputVehicle.value;
        if (preselected) {
            buttons.forEach(b => {
                const bId = b.getAttribute('data-vehicle-id');
                if (bId === preselected) {
                    b.textContent = 'DESMARCAR';
                    b.classList.add('btn-success');
                } else {
                    b.disabled = true;
                }
            });
        }
    });
</script>
@endpush

