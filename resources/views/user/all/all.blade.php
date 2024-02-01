@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Usuarios</h3>
                        </div>
                        <div>
                            <button id="btn-entity" class="btn btn-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">+ Nuevo</button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h4 id="offcanvasRightLabel"><b>Gestion de usuario</b></h4>
                                    <button onclick="clean()" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    {{ view("user.form.form") }}
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
                    <input id="filter-users" list="list-filter" type="text" class="form-control" placeholder="Consulta cualquier campo aqui">
                    <datalist id="list-filter">
                        @foreach (\App\Models\Profile::getProfiles() as $item)
                            <option value="{{ $item->name }}">
                        @endforeach
                        <option value="Activo">
                        <option value="Inactivo">
                    </datalist>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0" id="tb-users">
                            <thead class="table-light">
                                <tr>
                                    <th class="center"><b>Usuario</b></th>
                                    <th class="center"><b>Perfil</b></th>
                                    <th class="center"><b>Registro</b></th>
                                    <th class="center"><b>Red</b></th>
                                    <th class="center"><b>Creado por</b></th>
                                    <th class="center"><b>Estado</b></th>
                                    <th class="center"><b>Acciones</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td><img alt="avatar" src="{{ $user->people->getAvatar() }}" class="rounded-circle" width="30" /> {{ $user->username }}</td>
                                        <td>{{ $user->profile->name }}</td>
                                        <td>{{ $user->people->names() . " (Tel: ".$user->people->phone.")" }}</td>
                                        <td>{{ \App\Shared\RedType::get($user->red) }}</td>
                                        <td>{{ $user->createdBy->username }}</td>
                                        <td class="center">
                                            @if ($user->status == 1)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="center">
                                            <button onclick="openEdit('{{json_encode($user)}}')" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Editar usuario" type="button" class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2">
                                                <i data-feather="edit-2" class="nav-icon icon-xs"></i>
                                            </button>
                                            @if ($user->status == 1)
                                                <button onclick="changeStatus({{$user->id}}, 0)" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Inactivar usuario" type="button" class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2">
                                                    <i data-feather="slash" class="nav-icon icon-xs"></i>
                                                </button>
                                            @else
                                                <button onclick="changeStatus({{$user->id}}, 1)" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Activar usuario" type="button" class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2">
                                                    <i data-feather="slash" class="nav-icon icon-xs"></i>
                                                </button>
                                            @endif
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
    {{ view('user.all.all-script') }}
@endsection