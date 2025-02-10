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
    .btn-warning-2{
        background: #F9D639;
        color: #000000;
    }
    .btn-warning-2:hover{
        background: #ffd518;
        color: #000000;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            
            @if(auth()->user()->hasRole('ADMINISTRADOR'))
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
            @elseif(auth()->user()->hasRole('SUB_ADMINISTRADOR'))
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
                            <h3>{{$countGoals ?? '0'}}</h3>
                            <p>PORTERIAS</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <a href="{{route('admin.goals.index')}}" class="small-box-footer" style="color: #000000;">VER PORTERIAS <i class="fas fa-arrow-circle-right"></i></a>
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
            @elseif(auth()->user()->hasRole('PORTERO'))
                <div class="col-12 mb-3">
                    <button type="button" class="btn btn-warning-2" data-toggle="modal" data-target="#changeGoal">
                        <i class="nav-icon fas fa-vihara"></i> CAMBIAR DE PORTERÍA
                    </button>

                    <div class="modal fade" id="changeGoal" tabindex="-1" role="dialog" aria-labelledby="changeGoalLabel" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changeGoalLabel">CAMBIAR DE PORTERÍA</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('changeGoal') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <label for="goalSelect">SELECCIONE UNA PORTERÍA:</label>
                                        <select class="form-control" id="goalSelect" name="goal_id">
                                            @foreach ($goals as $goal)
                                                <option value="{{ $goal->id }}" 
                                                    @if(session('current_goal') == $goal->id) selected @endif>
                                                    {{ mb_strtoupper($goal->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">CERRAR</button>
                                        <button type="submit" class="btn btn-warning-2">CAMBIAR</button>
                                    </div>
                                </form>

                            </div>
                        </div>
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

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-infoEs">
                        <div class="inner">
                            <h3>{{$countVisitors ?? '0'}}</h3>
                            <p>VISITANTES</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <a href="{{route('admin.visitors.index')}}" class="small-box-footer" style="color: #000000;">VER VISITANTES <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        @if(!session()->has('goalModalShown'))
                            $('#changeGoal').modal('show');
                        @endif
                    });

                </script>
                <div class="col-12">
                    @if(session('current_goal'))
                        <p>PORTERÍA ACTUAL: <strong>{{ mb_strtoupper($goals->firstWhere('id', session('current_goal'))->name) ?? 'N/A' }}</strong></p>
                    @endif
                </div>
                
            @endif
           
        </div>
    </div>
    @if( auth()->user()->hasRole('ADMINISTRADOR') || auth()->user()->hasRole('SUB_ADMINISTRADOR'))
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h1 class="m-0">DESCARGAR REPORTE DE INGRESOS</h1>
                    </div>
                    <div class="col-12 mt-3">
                    <form action="{{ route('dashboard.exportIncomes') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label>FECHA INICIO:</label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label>FECHA FIN:</label>
                                    <input type="date" name="end_date" class="form-control" required>
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
    @endif

</section>

@endsection
