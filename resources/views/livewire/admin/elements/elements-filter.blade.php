<div>
    <div class="col-12">
        @if($nameElements || $contractoremployeeElements)
            <div class="row">
                <div class="col-12">
                    <h5>
                        Filtros aplicados
                    </h5>
                    <ul class="list-inline">
                        @if ($nameElements)
                            <li class="list-inline-item">
                                Nombre: {{ $nameElements }}
                                <a href="#" wire:click.prevent="removeFilter('nameElements')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($contractoremployeeElements)
                            <li class="list-inline-item">
                                Estado: {{ $contractoremployees->where('id',$contractoremployeeElements)->first()->name }}
                                <a href="#" wire:click.prevent="removeFilter('contractoremployeeElements')" class="text-danger">
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
                        <label for="nameElements">Nombre</label>
                        <input wire:model="nameElements" type="text" class="form-control" id="nameElements" placeholder="Ingrese el nombre del elemento">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="contractoremployeeElements">Empleado del contratista</label>
                        <select wire:model="contractoremployeeElements" class="form-control" id="contractoremployeeElements">
                            <option value="">Seleccionar Empleado del contratista </option>
                            @foreach($contractoremployees as $contractoremployee)
                                <option value="{{ $contractoremployee->id }}">{{ $contractoremployee->name }}</option>
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
                        <th scope="col">Nombre</th>
                        <th scope="col">Empleado del Contratista</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $countElements = 1;
                @endphp
                @foreach($elements as $element)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countElements}}</th>
                        <td>{{ $element->name }}</td>
                        <td>{{ $element->contractoremployee->name }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.elements.edit')
                                    <button type="button" data-toggle="modal" data-target="#modalEditElements_{{$element->id}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('admin.elements.destroy')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $element->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $element->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar este elemento?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('admin.elements.destroy', $element) }}">
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
                        $countElements++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
