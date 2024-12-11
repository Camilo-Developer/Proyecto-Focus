<div class="row col-12">
    <div class="col-12">
        @if($dateInitEmployeeIncomes || $dateFinishEmployeeIncomes)
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
                <div class="col-md-12">
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
                    <th scope="col">INGRESOS</th>
                    <th scope="col">SALIDA</th>
                    <th scope="col">VISITANTE</th>
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
                        <td>{{ $employeeincome->admission_date }}</td>
                        <td>{{ $employeeincome->departure_date }}</td>
                        <td>{{ $employeeincome->visitor->name }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.employeeincomes.edit')
                                    <button type="button" data-toggle="modal" data-target="#modalEditemployeeincomes_{{$employeeincome->id}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('admin.employeeincomes.destroy')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $employeeincome->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $employeeincome->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar este ingreso del empleado?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('admin.employeeincomes.destroy', $employeeincome) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
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

    </div>
</div>
