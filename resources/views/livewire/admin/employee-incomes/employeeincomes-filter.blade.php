<div class="row col-12">
    <div class="col-12">
        @if($dateInitEmployeeIncomes || $dateFinishEmployeeIncomes )
            <div class="row">
                <div class="col-12">
                    <h5>
                        FILTROS APLICADOS
                    </h5>
                    <ul class="list-inline">
                        @if ($dateInitEmployeeIncomes)
                            <li class="list-inline-item">
                                FECHA INGRESO: {{ $dateInitEmployeeIncomes }}
                                <a href="#" wire:click.prevent="removeFilter('dateInitEmployeeIncomes')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($dateFinishEmployeeIncomes)
                            <li class="list-inline-item">
                                FECHA SALIDA: {{ $dateFinishEmployeeIncomes }}
                                <a href="#" wire:click.prevent="removeFilter('dateFinishEmployeeIncomes')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        @endif
    </div>
    <div class="col-12">
        <form wire:submit.prevent="applyFilters" class="filter-form" wire:ignore>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateInitEmployeeIncomes">FECHA INGRESO</label>
                        <input wire:model="dateInitEmployeeIncomes" type="date" class="form-control" id="dateInitEmployeeIncomes">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateFinishEmployeeIncomes">FECHA SALIDA</label>
                        <input wire:model="dateFinishEmployeeIncomes" type="date" class="form-control" id="dateFinishEmployeeIncomes">
                    </div>
                </div>

               

                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-primary">APLICAR FILTROS</button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">CONJUNTO</th>
                    <th scope="col">AGLOMERACIÓN</th>
                    <th scope="col">UNIDAD</th>
                    <th scope="col">TIPO INGRESOS</th>
                    <th scope="col">INGRESOS</th>
                    <th scope="col">SALIDA</th>
                    <th scope="col">ACCIONES</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $countEmployeeIncomes = 1;
                @endphp
                @foreach($employeeincomes as $employeeincome)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countEmployeeIncomes}}</th>
                        {{-- 
                        
                            <td>
                            <span style="display: inline-flex; align-items: center; gap: 5px;">
                                {{ mb_strtoupper($employeeincome->visitor->name ?? 'SIN ASIGNAR') }}
                                @if($employeeincome->visitor && $employeeincome->visitor->state_id == 1) 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: green;"></div>
                                @else 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: red;"></div>
                                @endif
                            </span>
                        </td>
                         <td>
                            <span style="display: inline-flex; align-items: center; gap: 5px;">
                                {{ mb_strtoupper($employeeincome->visitor->typeuser->name ?? 'SIN ASIGNAR') }}
                            </span>
                        </td>
                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 5px;">
                                {{ mb_strtoupper($employeeincome->vehicle->placa ?? 'SIN ASIGNAR') }}
                                @if($employeeincome->vehicle && $employeeincome->vehicle->state_id == 1) 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: green;"></div>
                                @else 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: red;"></div>
                                @endif
                            </span>
                        </td>
                            
                        --}}

                         <td><span style="display: inline-flex; align-items: center; gap: 5px;">
                                {{ mb_strtoupper($employeeincome->setresidencial->name ?? 'SIN ASIGNAR') }}
                                @if($employeeincome->setresidencial && $employeeincome->setresidencial->state_id == 1) 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: green;"></div>
                                @else 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: red;"></div>
                                @endif
                            </span>
                        </td>

                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 5px;">
                                {{ mb_strtoupper($employeeincome->agglomeration->name ?? 'SIN ASIGNAR') }}
                                @if($employeeincome->agglomeration && $employeeincome->agglomeration->state_id == 1) 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: green;"></div>
                                @else 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: red;"></div>
                                @endif
                            </span>
                        </td>

                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 5px;">
                                {{ mb_strtoupper($employeeincome->unit->name ?? 'SIN ASIGNAR') }}
                                @if($employeeincome->unit && $employeeincome->unit->state_id == 1) 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: green;"></div>
                                @else 
                                    <div style="width: 10px; height: 10px; border-radius: 100%; background-color: red;"></div>
                                @endif
                            </span>
                        </td>

                        <td>
                            @if($employeeincome->type_income == 1)
                                PEATONAL
                            @else
                                VEHICULAR
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($employeeincome->admission_date)->translatedFormat('d M Y h:i A') }}</td>
                        <td>
                            @php
                                $exitentry = $employeeincome->exitentries->first();
                            @endphp

                            @if ($exitentry)
                                {{ \Carbon\Carbon::parse($exitentry->departure_date)->translatedFormat('d M Y h:i A') }}
                            @else
                                SIN SALIDA
                            @endif

                        </td>

                        <td style="width: 100px;">
                            <div class="btn-group">
                                    <a href="{{route('admin.employeeincomes.createExit',$employeeincome)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>

                                @can('admin.employeeincomes.destroy')
                                    <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#confirmDeleteModal_{{ $employeeincome->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <div class="modal fade" id="confirmDeleteModal_{{ $employeeincome->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">CONFIRMAR ELIMINACIÓN</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿ÉSTAS SEGURO DE ELIMINAR ESTE INGRESO?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                                    <form method="post" action="{{ route('admin.employeeincomes.destroy', $employeeincome) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan

                                @can('admin.employeeincomes.show')
                                    <a href="{{route('admin.employeeincomes.show',$employeeincome)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                @endcan

                               {{-- 
                                @if (!$exitentry || $exitentry->departure_date == null)
                                    <a title="SALIDA RÁPIDA" class="btn dateFinisConfir" data-id="{{ $employeeincome->id }}">
                                        <i class="fa fa-sign-out-alt"></i>
                                    </a>
                                @endif
                                
                                --}}
                            </div>
                        </td>
                    </tr>
                    @php
                        $countEmployeeIncomes++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>
        {{$employeeincomes->links()}}
    </div>


<script>
    document.addEventListener('DOMContentLoaded', function(){
        $('#visitorsEmployeeIncomes3').select2();
        $('#visitorsEmployeeIncomes3').on('change', function(e) {
            var EmployeeIncomesID = $('#visitorsEmployeeIncomes3').select2("val");
            @this.set('visitorsEmployeeIncomes',EmployeeIncomesID);
        });
    });
</script>
</div>
<script>
    $(document).ready(function () {
        $('.dateFinisConfir').on('click', function () {
            var visitorId = $(this).data('id'); // Obtener el ID del visitante correctamente

            $.ajax({
                url: 'employeeincomes/datefinisconfir/' + visitorId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}' 
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Confirmado!',
                            text: response.message,
                            showConfirmButton: true,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al confirmar el visitante.',
                            showConfirmButton: true
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al realizar la solicitud.',
                        showConfirmButton: true
                    });
                }
            });
        });
    });
</script>