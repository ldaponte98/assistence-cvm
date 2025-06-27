@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Clasificación de personas</h3>
                        </div>
                        <div>
                            <button id="btn-entity" class="hide" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Nuevo</button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h4 id="offcanvasRightLabel"><b>Datos basicos</b></h4>
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
        <div class="card mt-6">
            <div class="card-body">
                <form method="POST" action="{{ route('report/clasification-people') }}" id="form-report" >
                    @csrf
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                            <div class="mb-lg-0">
                                <label>Fecha Inicial</label>
                                <input type="text" class="form-control datetimepicker" id="start" name="start" value="{{ date('Y-m-d')}} 00:00">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                            <div class="mb-lg-0">
                                <label>Fecha Final</label>
                                <input type="text" class="form-control datetimepicker" id="end" name="end" value="{{ date('Y-m-d')}} 23:59">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                            <div class="mb-lg-0">
                                <label>Clasificación</label>
                                <select onchange="validateClassification()" class="form-select property" id="classification" name="classification">
                                    <option value="">Todos</option>
                                    @foreach (\App\Shared\ClassificationType::LIST as $item)
                                        <option value="{{ $item["code"] }}">{{ $item["text"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="div_red" class="col-lg-3 col-md-3 col-sm-12 mt-2 hide">
                            <div class="mb-lg-0">
                                <label>Red</label>
                                <select onchange="validateType()" class="form-select property" id="red" name="red">
                                    <option value="">Todas</option>
                                    @foreach (\App\Shared\RedType::LIST as $item)
                                        @if (\App\Models\User::validRed($item["code"]))
                                            <option @if (session('red') == $item["code"]) selected @endif value="{{ $item["code"] }}">{{ $item["text"] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="div_conection_group_id" class="col-lg-3 col-md-3 col-sm-12 mt-2 hide">
                            <div class="mb-lg-0">
                                <label>Grupo de conexión</label>
                                <select class="form-select property" id="conection_group_id" name="conection_group_id">
                                    <option value="">Todos</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12 col-md-12 col-sm-12 center">
                            <div id="div-loading" class="text-center hide">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Por favor espere...</span>
                                </div>
                            </div>
                            <div id="div-actions">
                                <button class="btn btn-primary" onclick="find()">Consultar</button>
                                <button id="btn-export" class="btn btn-success hide" onclick="exportReport()">Exportar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if (isset($peoples))
        <div class="row mt-6">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 data-table" id="tb-people">
                            <thead class="table-light">
                                <tr>
                                    <th class="center"><b>Nombres</b></th>
                                    <th class="center"><b>Apellido</b></th>
                                    <th class="center"><b>Sexo</b></th>
                                    <th class="center"><b>Categorización</b></th>
                                    <th class="center"><b>Telefono</b></th>
                                    <th class="center"><b>F. Nacimiento</b></th>
                                    <th class="center"><b>Email</b></th>
                                    <th class="center"><b>Grupo conexión</b></th>
                                    <th class="center"><b>Estado</b></th>
                                    <th class="center"><b>Acciones</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peoples as $people)
                                    <tr>
                                        <td>{{ $people->fullname }}</td>
                                        <td>{{ $people->lastname }}</td>
                                        <td>{{ $people->getGender() }}</td>
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
                                                <i data-feather="eye" class="nav-icon icon-xs"></i>
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

        @endif
    </div>
    {{ view('report.clasification-peoples.clasification-peoples-script') }}
@endsection