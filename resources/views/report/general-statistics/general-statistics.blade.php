@extends('layout.principal')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Estadisticas generales</h3>
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
                            <label>Tipo de evento</label>
                            <select onchange="validateType()" class="form-select property" id="type" name="type" onchange="validateType()">
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
                            <button class="btn btn-primary" onclick="generate()">Generar estadisticas</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-6 div-charts mb-5" style="display: none">
            <div class="col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12">
                                <h2><b>Grafico asistencial por fecha</b></h2>
                                <div style="width: 100%;"><canvas id="totalByDate"></canvas></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    {{ view('report.general-statistics.general-statistics-script') }}
@endsection