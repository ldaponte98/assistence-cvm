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
                            <button onclick="showNew()" class="btn btn-white" type="button">+ Nuevo</button>
                            <button id="btn-entity" class="hide" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Nuevo</button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h4 id="offcanvasRightLabel"><b>Gestion de grupo de conexión</b></h4>
                                    <button onclick="clean()" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    {{ view("conection-group.form.form") }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-6">
            <div class="col-md-12 col-12">
                <div class="card">
                    <input id="filter-conection-group" list="list-filter" type="text" class="form-control" placeholder="Consulta cualquier campo aqui">
                    <datalist id="list-filter">
                        @foreach (\App\Shared\RedType::LIST as $item)
                            <option value="{{ $item["text"] }}">
                        @endforeach
                        <option value="Activo">
                        <option value="Inactivo">
                    </datalist>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0" id="tb-conection-group">
                            <thead class="table-light">
                                <tr>
                                    <th class="center"><b>Nombre</b></th>
                                    <th class="center"><b>Red</b></th>
                                    <th class="center"><b>Edad inicial</b></th>
                                    <th class="center"><b>Edad final</b></th>
                                    <th class="center"><b>Estado</b></th>
                                    <th class="center"><b>Acciones</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ \App\Shared\RedType::get($item->red) }}</td>
                                        <td>{{ $item->initial_age }}</td>
                                        <td>{{ $item->final_age }}</td>
                                        <td class="center">
                                            @if ($item->status == 1)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="center">
                                            <button onclick="openEdit('{{json_encode($item)}}')" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Gestionar información" type="button" class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2">
                                                <i data-feather="settings" class="nav-icon icon-xs"></i>
                                            </button>
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