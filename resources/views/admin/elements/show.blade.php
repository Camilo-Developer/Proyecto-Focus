@extends('layouts.app2')
@section('title', 'DETALLE DEL ELEMENTO')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>DETALLE DEL ELEMENTO</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.elements.index')}}">LISTADO DE ELEMENTOS</a></li>
                        
                        <li class="breadcrumb-item active">DETALLE DEL ELEMENTO</li>
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
                            <div class="card" style="width: 20rem;">
                                <div class="card-body">
                                    <p class="card-text"><span class="text-bold">NOMBRE:</span> {{strtoupper($element->name)}}</p>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
@endsection
