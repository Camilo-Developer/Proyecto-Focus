<div>
    <div class="col-12">
        @if($nameSetResidencial || $nitSetResidencial || $stateSetResidencial || $userSetResidencial)
            <div class="row">
                <div class="col-12">
                    <h5>
                        FILTROS APLICADOS
                    </h5>
                    <ul class="list-inline">
                        @if ($nameSetResidencial)
                            <li class="list-inline-item">
                                NOMBRE: {{ strtoupper($nameSetResidencial) }}
                                <a href="#" wire:click.prevent="removeFilter('nameSetResidencial')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($nitSetResidencial)
                            <li class="list-inline-item">
                                NIT: {{ strtoupper($nitSetResidencial) }}
                                <a href="#" wire:click.prevent="removeFilter('nitSetResidencial')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                        @if ($stateSetResidencial)
                            <li class="list-inline-item">
                                ESTADO: {{ strtoupper($states->where('id',$stateSetResidencial)->first()->name) }}
                                <a href="#" wire:click.prevent="removeFilter('stateSetResidencial')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif

                        @if ($userSetResidencial)
                            <li class="list-inline-item">
                                RESPONSABLE: {{ strtoupper($users->where('id',$userSetResidencial)->first()->name) . ' ' .  strtoupper($users->where('id',$userSetResidencial)->first()->lastname)}}
                                <a href="#" wire:click.prevent="removeFilter('userSetResidencial')" class="text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endif
                      
                    </ul>
                </div>
            </div>
        @endif
    </div>
    <div class="col-12 mb-3">
        <form wire:submit.prevent="applyFilters" class="filter-form" wire:ignore>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nameSetResidencial">NOMBRE</label>
                        <input wire:model="nameSetResidencial" type="text" class="form-control" id="nameSetResidencial" placeholder="NOMBRE">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nitSetResidencial">NIT</label>
                        <input wire:model="nitSetResidencial" type="text" class="form-control" id="nitSetResidencial" placeholder="NIT">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="stateSetResidencial">ESTADO</label>
                        <select wire:model="stateSetResidencial" class="form-control" id="stateSetResidencial">
                            <option value="">-- SELECCIONAR --</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ strtoupper($state->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="userSetResidencial">RESPONSABLE</label>
                        <select wire:model="userSetResidencial" class="form-control" id="userSetResidencial3">
                            <option value="">-- SELECCIONAR --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ strtoupper($user->name) }} {{ strtoupper($user->lastname) }}</option>
                            @endforeach
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
                        <th scope="col">DIRECCIÓN</th>
                        <th scope="col">NIT</th>
                        <th scope="col">RESPONSABLE</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $countSetResidencial = 1;
                @endphp
                @foreach($setresidencials as $setresidencial)
                    <tr class="text-center">
                        <th scope="row" style="width: 50px;">{{$countSetResidencial}}</th>
                        <td>{{ strtoupper($setresidencial->name) }}</td>
                        <td>{{ strtoupper($setresidencial->address) }}</td>
                        <td>{{ strtoupper($setresidencial->nit) }}</td>
                        <td>{{ strtoupper($setresidencial->user->name ?? 'SIN USUARIO')}} {{ strtoupper($setresidencial->user->lastname ?? '')}}</td>
                        <td>{{ strtoupper($setresidencial->state->name) }}</td>
                        <td style="width: 100px;">
                            <div class="btn-group">
                                @can('admin.setresidencials.edit')
                                    <a href="{{route('admin.setresidencials.edit',$setresidencial)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('admin.setresidencials.destroy')
                                    <button type="button" class="btn btn-danger mx-2" data-toggle="modal" data-target="#confirmDeleteModal_{{ $setresidencial->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <!-- Confirmación de eliminación Modal -->
                                    <div class="modal fade" id="confirmDeleteModal_{{ $setresidencial->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">CONFIRMAR ELIMINACIÓN</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿ESTÁS SEGURO QUE QUIERES ELIMINAR ESTE CONJUNTO?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                                                    <form method="post" action="{{ route('admin.setresidencials.destroy', $setresidencial) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                                @can('admin.setresidencials.show')
                                    <a href="{{route('admin.setresidencials.show',$setresidencial)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @php
                        $countSetResidencial++;
                    @endphp
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        $('#userSetResidencial3').select2();
        $('#userSetResidencial3').on('change', function(e) {
            var userID = $('#userSetResidencial3').select2("val");
            @this.set('userSetResidencial',userID);
        });
    });
</script>
