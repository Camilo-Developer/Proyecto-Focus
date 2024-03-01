<div>
    <div class="col-12">
        @if($dateInitElementEntries || $dateFinishElementEntries || $elementIDElementEntries)
            <div class="row">
                <div class="col-12">
                    <h5>
                        Filtros aplicados
                    </h5>
                    <ul class="list-inline">
                        @if ($dateInitElementEntries)
                            <li class="list-inline-item">
                                Fecha ingreso: {{ $dateInitElementEntries }}
                                <a href="#" wire:click.prevent="removeFilter('dateInitElementEntries')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($dateFinishElementEntries)
                            <li class="list-inline-item">
                                Fecha salida: {{ $dateFinishElementEntries }}
                                <a href="#" wire:click.prevent="removeFilter('dateFinishElementEntries')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($elementIDElementEntries)
                            <li class="list-inline-item">
                                Elemento: {{ $elements->where('id',$elementIDElementEntries)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('elementIDElementEntries')" class="text-danger">
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
                        <label for="dateInitElementEntries">Fecha ingreso</label>
                        <input wire:model="dateInitElementEntries" type="date" class="form-control" id="dateInitElementEntries">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateFinishElementEntries">Fecha salida</label>
                        <input wire:model="dateFinishElementEntries" type="date" class="form-control" id="dateFinishElementEntries">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="elementIDElementEntries">Elemento</label>
                        <select wire:model="elementIDElementEntries" class="form-control" id="elementIDElementEntries">
                            <option value="">Seleccionar Elemento </option>
                            @foreach($elements as $element)
                                <option value="{{ $element->id }}">{{ $element->name }}</option>
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
                    <th scope="col">Elemento</th>
                    <th scope="col">Nota</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $countElementEntries = 1;
                @endphp
                @foreach($elementEntries as $elemententry)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countElementEntries}}</th>
                        <td>{{ $elemententry->admission_date }}</td>
                        <td>{{ $elemententry->departure_date }}</td>
                        <td>{{ $elemententry->element->name }}</td>
                        <td>{{ $elemententry->note }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.elemententries.edit')
                                    <button type="button" data-toggle="modal" data-target="#modalEditelemententries_{{$elemententry->id}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('admin.elemententries.destroy')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $elemententry->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $elemententry->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar este ingreso del elemento?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('admin.elemententries.destroy', $elemententry) }}">
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
                        $countElementEntries++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
