<div class="col-12 ">
    <div class="row">
    <div class="col-12">
        @if($nameVisitors || $phoneVisitors || $documentNumberVisitors || $confirmationVisitors)
            <div class="row">
                <div class="col-12">
                    <h5>
                        FILTROS APLICADOS
                    </h5>
                    <ul class="list-inline">
                        @if ($nameVisitors)
                            <li class="list-inline-item">
                                NOMBRE: {{ mb_strtoupper($nameVisitors) }}
                                <a href="#" wire:click.prevent="removeFilter('nameVisitors')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($phoneVisitors)
                            <li class="list-inline-item">
                                TELÉFONO: {{ mb_strtoupper($phoneVisitors) }}
                                <a href="#" wire:click.prevent="removeFilter('phoneVisitors')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($documentNumberVisitors)
                            <li class="list-inline-item">
                                NÚMERO DOCUMENTO: {{ mb_strtoupper($documentNumberVisitors)  }}
                                <a href="#" wire:click.prevent="removeFilter('documentNumberVisitors')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($confirmationVisitors)
                            <li class="list-inline-item">
                            CONFIRMACIÓN: {{ $confirmationVisitors == 1 ? 'SI' : ($confirmationVisitors == 2 ? 'NO' : 'NO') }}

                                <a href="#" wire:click.prevent="removeFilter('confirmationVisitors')" class="text-danger">
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
                        <label for="nameVisitors">NOMBRE</label>
                        <input wire:model="nameVisitors" type="text" class="form-control" id="nameVisitors" placeholder="NOMBRE">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="phoneVisitors">TELÉFONO</label>
                        <input wire:model="phoneVisitors" type="text" class="form-control" id="phoneVisitors" placeholder="TELÉFONO">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="documentNumberVisitors">NÚMERO DE DOCUMENTO</label>
                        <input wire:model="documentNumberVisitors" type="text" class="form-control" id="documentNumberVisitors" placeholder="NÚMERO DE DOCUMENTO">
                    </div>
                </div>
               
                <div class="col-md-3">
                        <div class="form-group">
                            <label for="confirmationVisitors">CONFIRMACIÓN</label>
                            <select wire:model="confirmationVisitors" class="form-control" id="confirmationVisitors">
                                <option value="">-- SELECCIONAR -- </option>
                                <option value="1">SI</option>
                                <option value="2">NO</option>
                            </select>
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
                        <th scope="col">NOMBRE</th>
                        <th scope="col">TELÉFONO</th>
                        <th scope="col">NÚMERO DOCUMENTO</th>
                        <th scope="col">CONFIRMACIÓN</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $countVisitors = 1;
                @endphp
                @foreach($visitors as $visitor)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countVisitors}}</th>
                        <td>{{ mb_strtoupper($visitor->name) }}</td>
                        <td>{{ $visitor->phone }}</td>
                        <td>{{ $visitor->document_number }}</td>
                        <td>
                            @if($visitor->confirmation == 1)
                                SI
                            @else
                                NO
                            @endif
                        </td>
                        <td>@if($visitor->state_id == 1) <div class="badge badge-success">{{ mb_strtoupper($visitor->state->name) }}</div> @else <div class="badge badge-danger">{{ mb_strtoupper($visitor->state->name) }}</div> @endif</td>
                        
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.visitors.edit')
                                    <a href="{{route('admin.visitors.edit',$visitor)}}"  class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('admin.visitors.destroy')
                                    <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#confirmDeleteModal_{{ $visitor->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $visitor->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">CONFIRMAR ELIMINACIÓN</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿ESTÁS SEGURO QUE QUIERES ELIMINAR ESTE VISITANTE?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                                                    <form method="post" action="{{ route('admin.visitors.destroy', $visitor) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                                @can('admin.visitors.show')
                                    <a href="{{route('admin.visitors.show',$visitor)}}"  class="btn btn-success"><i class="fa fa-eye"></i></a>
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
        {{$visitors->links()}}

    </div>
    </div>
</div>
