@extends('layouts.app2')
@section('title', 'LISTA DE TIPOS DE USUARIOS')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>LISTA DE TIPOS DE USUARIOS</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item active">LISTA DE TIPOS DE USUARIOS</li>
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
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    @can('admin.typeusers.create')
                                        <a href="{{route('admin.typeusers.create')}}" class="btn btn-primary btn-sm" ><i class="fa fa-check"></i> CREAR TIPO DE USUARIO</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @livewire('admin.type-users.type-users-filter')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
