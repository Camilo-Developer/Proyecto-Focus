@extends('layouts.app2')
@section('title', 'INICIO')
@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">PANEL ADMINISTRATIVO</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">PANEL ADMINISTRATIVO</li>
        </ol>
        </div>
    </div>
    </div>
</div>
<style>
    .bg-infods {
        background-color: #262525!important;
        color: #ffffff;
    }
    .bg-infods .icon {
        color: #ffffff;
    }

    .bg-infoEs {
        background-color: #F9D639!important;
        color: #000000;
    }
    .bg-infoEs .icon {
        color: #000000;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-infods">
                    <div class="inner">
                        <h3>{{$countUsers ?? '0'}}</h3>
                        <p>USUARIOS</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <a href="{{route('admin.users.index')}}" class="small-box-footer">VER USUARIOS <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-infoEs">
                    <div class="inner">
                        <h3>{{$countSetresidencials ?? '0'}}</h3>
                        <p>CONJUNTOS</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="{{route('admin.setresidencials.index')}}" class="small-box-footer" style="color: #000000;">VER CONJUNTOS <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-infods">
                    <div class="inner">
                        <h3>{{$countVehicles ?? '0'}}</h3>
                        <p>VEHICULOS</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <a href="{{route('admin.vehicles.index')}}" class="small-box-footer">VER VEHICULOS <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h1 class="m-0">DESCARGAR REPORTE DE INGRESOS</h1>
            </div>
            <div class="col-12 mt-3">
                <form action="">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label>FECHA INICIO:</label>
                                <input type="date" class="form-control datetimepicker-input" data-target="#reservationdate">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label>FECHA FIN:</label>
                                    <input type="date" class="form-control datetimepicker-input" data-target="#reservationdate">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group mt-2">
                                <br>
                                <button type="submit" class="btn btn-success">DESCARGAR</button>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    </div>
</section>

@endsection
