<div>
    <div class="col-12">
        @if($admissiondateVisitors || $departuredateVisitors || $unitVisitors ||$stateVisitors)
            <div class="row">
                <div class="col-12">
                    <h5>
                        Filtros aplicados
                    </h5>
                    <ul class="list-inline">
                        @if ($admissiondateVisitors)
                            <li class="list-inline-item">
                                Ingreso: {{ $admissiondateVisitors }}
                                <a href="#" wire:click.prevent="removeFilter('admissiondateVisitors')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($departuredateVisitors)
                            <li class="list-inline-item">
                                Salida: {{ $departuredateVisitors }}
                                <a href="#" wire:click.prevent="removeFilter('departuredateVisitors')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($unitVisitors)
                            <li class="list-inline-item">
                                Unidad: {{ $units->where('id',$unitVisitors)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('unitVisitors')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($stateVisitors)
                            <li class="list-inline-item">
                                Estado: {{ $states->where('id',$stateVisitors)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('stateVisitors')" class="text-danger">
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
                        <label for="admissiondateVisitors">Fecha Ingreso</label>
                        <input wire:model="admissiondateVisitors" type="date" class="form-control" id="admissiondateVisitors">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="departuredateVisitors">Fecha Salida</label>
                        <input wire:model="departuredateVisitors" type="date" class="form-control" id="departuredateVisitors">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="unitVisitors">Unidad</label>
                        <select wire:model="unitVisitors" class="form-control" id="unitVisitors">
                            <option value="">Seleccionar unidad</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="stateVisitors">Estados</label>
                        <select wire:model="stateVisitors" class="form-control" id="stateVisitors">
                            <option value="">Seleccionar Estado </option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
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
                    <th scope="col">Ingreso</th>
                    <th scope="col">Salida</th>
                    <th scope="col">Unidad</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $countVisitors = 1;
                @endphp
                @foreach($visitorentries as $visitorentry)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countVisitors}}</th>
                        <td>{{ $visitorentry->admission_date }}</td>
                        <td>{{ $visitorentry->departure_date }}</td>
                        <td>{{ $visitorentry->unit->name }}</td>
                        <td>{{ $visitorentry->state->name }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.visitorentries.edit')
                                    <button type="button" data-toggle="modal" data-target="#modalEditVisitorentries_{{$visitorentry->id}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('admin.visitorentries.destroy')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $visitorentry->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $visitorentry->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar este Ingreso del visitante?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('admin.visitorentries.destroy', $visitorentry) }}">
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
                        $countVisitors++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
