@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Mi grupo de conexión</h3>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
            <div class="row mt-6">
                @if ($group != null)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <label><b>Nombre: </b> {{ $group->name }}</label>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <label><b>Red: </b> {{ \App\Shared\RedType::get($group->red) }}</label>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <label><b>Edades: </b> Entre {{ $group->initial_age }} y {{ $group->final_age }}</label>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                        <label><b>Creado: </b> {{ date('d/m/Y', strtotime($group->created_at)) }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-6">
                        <div class="card">
                            <input id="filter-conection-group-assistant" list="list-filter" type="text" class="form-control" placeholder="Consulta cualquier campo aqui">
                            <datalist id="list-filter">
                                @foreach (\App\Shared\PeopleType::LIST as $item)
                                    <option value="{{ $item["text"] }}">
                                @endforeach
                                @foreach (\App\Shared\PeopleStatus::LIST as $item)
                                    <option value="{{ $item["text"] }}">
                                @endforeach
                            </datalist>
                            <div class="table-responsive">
                                <table class="table text-nowrap mb-0" id="tb-conection-group-assistant">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="center"><b>Nombre</b></th>
                                            <th class="center"><b>Clasificación</b></th>
                                            <th class="center"><b>Telefono</b></th>
                                            <th class="center"><b>Email</b></th>
                                            <th class="center"><b>Fecha ingreso</b></th>
                                            <th class="center"><b>Estado</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($group->getAssistants() as $people)
                                            <tr>
                                                <td><img alt="avatar" src="{{ $people->getAvatar() }}" class="rounded-circle" width="30" /> {{ $people->names() }}</td>
                                                <td>{{ \App\Shared\PeopleType::get($people->type) }}</td>
                                                <td>{{ $people->phone }}</td>
                                                <td>{{ $people->email }}</td>
                                                <td>{{ date('d/m/Y H:i', strtotime($people->created_at)) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ \App\Shared\PeopleStatus::getClass($people->status) }}">
                                                        {{ \App\Shared\PeopleStatus::get($people->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <label>No tienes un grupo de conexión asignado</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>        
    </div>
    {{ view('conection-group.me-group.me-group-script') }}
@endsection