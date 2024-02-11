<div>
    <div class="col-12">
        @if($nameVisitors)
            <div class="row">
                <div class="col-12">
                    <h5>
                        Filtros aplicados
                    </h5>
                    <ul class="list-inline">
                        @if ($nameVisitors)
                            <li class="list-inline-item">
                                Visitante: {{ $nameVisitors }}
                                <a href="#" wire:click.prevent="removeFilter('nameVisitors')" class="text-danger">
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
                        <label for="nameVisitors">Visitante</label>
                        <input wire:model="nameVisitors" type="text" class="form-control" id="nameVisitors" placeholder="Ingrese el nombre del visitante">
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
                        <th scope="col">Nombre Visitante</th>
                        <th scope="col">Apellido Visitante</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $countVisitors = 1;
                @endphp
                @foreach($visitors as $visitor)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countVisitors}}</th>
                        <td>{{ $visitor->name }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.visitors.edit')
                                    <button type="button" data-toggle="modal" data-target="#modalEditVisitorss_{{$visitor->id}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                @endcan
                                @can('admin.visitors.destroy')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal_{{ $visitor->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $visitor->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que quieres eliminar este visitante?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="{{ route('admin.visitors.destroy', $visitor) }}">
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
