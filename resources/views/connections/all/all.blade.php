@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Miembros de conexiones</h3>
                        </div>
                        <div>
                            <button onclick="$('#dialog-validate-people').modal('show'); $('#phone-validate-people').focus()" class="btn btn-white mobile-w-100" type="button">+ Nuevo miembro</button>
                            <button id="btn-entity" class="hide" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Nuevo</button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h4 id="offcanvasRightLabel"><b>Gestion de miembro de conexiones</b></h4>
                                    <button onclick="clean()" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    {{ view("people.form.form") }}
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
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 data-table" id="tb-people">
                            <thead class="table-light">
                                <tr>
                                    <th class="center"><b>Registro</b></th>
                                    <th class="center"><b>Categorización</b></th>
                                    <th class="center"><b>Telefono</b></th>
                                    <th class="center"><b>F. Nacimiento</b></th>
                                    <th class="center"><b>Email</b></th>
                                    <th class="center"><b>Estado</b></th>
                                    <th class="center"><b>Acciones</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peoples as $people)
                                    <tr>
                                        <td><img alt="avatar" src="{{ $people->getAvatar() }}" class="rounded-circle" width="30" /> {{ $people->names() }}</td>
                                        <td>{{ \App\Shared\PeopleType::get($people->type) }}</td>
                                        <td>{{ $people->phone }}</td>
                                        <td>{{ $people->birthday != null ? date('d/m/Y', strtotime($people->birthday)) : "" }}</td>
                                        <td>{{ $people->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ \App\Shared\PeopleStatus::getClass($people->status) }}">
                                                {{ \App\Shared\PeopleStatus::get($people->status) }}
                                            </span>
                                        </td>
                                        <td class="center">
                                            <button onclick="openEdit('{{json_encode($people)}}')" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Gestionar información" type="button" class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2">
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
    {{ view('event.settings.components.modal-validate-people.modal-validate-people') }}
    {{ view('connections.all.all-script') }}
@endsection