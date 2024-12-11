@extends('layouts.app2')
@section('title', 'DETALLE DE LA UNIDAD')
@section('content')
          
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>DETALLE DE LA UNIDAD</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.units.index')}}">LISTADO DE UNIDADES</a></li>
                    <li class="breadcrumb-item active">DETALLE DE LA UNIDAD</li>
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
                        <p><span class="text-bold">NOMBRE:</span> {{strtoupper($unit->name)}}</p>
                        <p><span class="text-bold">ESTADO:</span> {{strtoupper($unit->state->name)}}</p>
                        <p><span class="text-bold">AGLOMERACIÓN:</span> {{strtoupper($unit->agglomeration->name)}}</p>
                        <p><span class="text-bold">CONJUNTO:</span> {{strtoupper($unit->agglomeration->setresidencial->name)}}</p>
                        <p><span class="text-bold">RESPONSABLE DEL CONJUNTO:</span> {{strtoupper($unit->agglomeration->setresidencial->user->name)}} {{strtoupper($unit->agglomeration->setresidencial->user->lastname)}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
