@extends('layouts.app2')
@section('title', 'LISTA DE EMPRESAS')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>LISTA DE EMPRESAS</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">INICIO</a></li>
                        <li class="breadcrumb-item active">LISTA DE EMPRESAS</li>
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
                                    @can('admin.companies.create')
                                        <a href="{{route('admin.companies.create')}}" class="btn btn-primary btn-sm" ><i class="fa fa-check"></i> CREAR EMPRESA</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                @livewire('admin.companies.companies-filter')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
