<div class="col-12 ">
    <div class="row">
    <div class="col-12">
        @if($nameTypeusers )
            <div class="row">
                <div class="col-12">
                    <h5>
                        FILTROS APLICADOS
                    </h5>
                    <ul class="list-inline">
                        @if ($nameTypeusers)
                            <li class="list-inline-item">
                                NOMBRE: {{ mb_strtoupper($nameTypeusers) }}
                                <a href="#" wire:click.prevent="removeFilter('nameTypeusers')" class="text-danger">
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
                        <label for="nameTypeusers">NOMBRE</label>
                        <input wire:model="nameTypeusers" type="text" class="form-control" id="nameTypeusers" placeholder="NOMBRE">
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
                        <th scope="col">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $countTypeusers = 1;
                @endphp
                @foreach($typeusers as $typeuser)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countTypeusers}}</th>
                        <td>{{ mb_strtoupper($typeuser->name) }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.typeusers.edit')
                                    <a href="{{route('admin.typeusers.edit',$typeuser)}}"   class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('admin.typeusers.destroy')
                                    <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#confirmDeleteModal_{{ $typeuser->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $typeuser->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">CONFIRMAR ELIMINACIÓN</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿ESTÁS SEGURO QUE QUIERES ELIMINAR ESTE TIPO DE USUARIO?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                                    <form method="post" action="{{ route('admin.typeusers.destroy', $typeuser) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">ELIMINAR</button>
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
                        $countTypeusers++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>
        {{$typeusers->links()}}
    </div>
    </div>
</div>