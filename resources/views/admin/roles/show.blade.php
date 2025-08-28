@extends('layouts.app2')
@section('title', 'DETALLE DEL ROL')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.roles.index')}}">LISTADO DE ROLES</a></li>
                        <li class="breadcrumb-item active">DETALLE DEL ROL</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    <h1>DETALLE DEL ROL: {{mb_strtoupper($role->name)}}</h1>
                    <div class="col-12">
                        <div class=" row">
                            <label>LISTADO DE PERMISOS ASIGNADOS A ESTE ROL:</label>
                            <div class="col-12">
                                <ol>
                                    @foreach($role->permissions as $permission)
                                        <li><label>{{$permission->description}}</label></li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
