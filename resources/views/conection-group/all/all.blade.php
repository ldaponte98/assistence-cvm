@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Grupos de conexión</h3>
                        </div>
                        <div>
                            <a href="{{ route('conection-group/settings') }}" class="btn btn-white" type="button">+ Nuevo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-6">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 data-table" id="tb-conection-group">
                            <thead class="table-light">
                                <tr>
                                    <th class="center"><b>Nombre</b></th>
                                    <th class="center"><b>Red</b></th>
                                    <th class="center"><b>¿Valida la edad?</b></th>
                                    <th class="center"><b>¿Valida el barrio?</b></th>
                                    <th class="center"><b>¿Admite casados?</b></th>
                                    <th class="center"><b>Estado</b></th>
                                    <th class="center"><b>Acciones</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ \App\Shared\RedType::get($item->red) }}</td>
                                        <td class="center">{{ $item->check_years == 1 ? 'Si' : 'No' }}</td>
                                        <td class="center">{{ $item->check_neighborhoods == 1 ? 'Si' : 'No' }}</td>
                                        <td class="center">{{ $item->check_couples == 1 ? 'Si' : 'No' }}</td>
                                        <td class="center">
                                            @if ($item->status == 1)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="center">
                                            <a href="{{ route('conection-group/settings', $item->id) }}" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Gestionar información" class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2">
                                                <i data-feather="settings" class="nav-icon icon-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ view('people.all.all-script') }}
@endsection