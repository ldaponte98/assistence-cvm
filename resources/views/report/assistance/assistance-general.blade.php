@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Asistencia general</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                        <div class="mb-lg-0">
                            <label>Fecha Inicial</label>
                            <input type="text" class="form-control datetimepicker" id="start" value="{{ date('Y-m-d')}} 00:00">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                        <div class="mb-lg-0">
                            <label>Fecha Final</label>
                            <input type="text" class="form-control datetimepicker" id="end" value="{{ date('Y-m-d')}} 23:59">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                        <div class="mb-lg-0">
                            <label>Tipo</label>
                            <select class="form-select property" id="type" name="type" onchange="validateType()">
                                <option value="">Todos</option>
                                @foreach (\App\Shared\EventType::LIST as $item)
                                    <option value="{{ $item["code"] }}">{{ $item["text"] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                        <div class="mb-lg-0">
                            <label>Red</label>
                            <select class="form-select property" id="red" name="red">
                                <option value="">Todas</option>
                                @foreach (\App\Shared\RedType::LIST as $item)
                                    @if (\App\Models\User::validRed($item["code"]))
                                        <option @if (session('red') == $item["code"]) selected @endif value="{{ $item["code"] }}">{{ $item["text"] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-12 col-md-12 col-sm-12 center">
                        <button class="btn btn-primary" onclick="find()">Consultar</button>
                        <button id="btn-export" class="btn btn-success hide" onclick="exportReport()">Exportar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-6">
            <div class="col-md-12 col-12">
                <input type="text" placeholder="Consulta por cualquier campo" class="form-control" id="filter-assistance-general">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0" id="tb-assistance-general">
                            <thead class="table-light">
                                <tr>
                                    <th class="center"><b>Evento</b></th>
                                    <th class="center"><b>Fecha Inicial</b></th>
                                    <th class="center"><b>Fecha Final</b></th>
                                    <th class="center"><b>Asistencia</b></th>
                                    <th class="center"><b>Participantes</b></th>
                                    <th class="center"><b>Asistentes</b></th>
                                    <th class="center"><b>Inasistentes</b></th>
                                    <th class="center"><b>Nuevos</b></th>
                                    <th class="center"><b></b></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ view('report.assistance.assistance-general-script') }}
@endsection