@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="d-flex justify-content-between align-items-center block-mobile">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 text-white">Evento: <b>{{ $event->title }}</b></h3>
                    </div>
                    <div>
                        @if ($event->validForSettings())
                            <button id="btn-entity" class="btn btn-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">+ Nuevo asistente</button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h4 id="offcanvasRightLabel"><b>Nuevo asistente</b></h4>
                                    <button onclick="clean()" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    {{ view("event.form-new-assistant.form-new-assistant") }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>  
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                <label><b>Red: </b> {{ \App\Shared\RedType::get($event->red) }}</label>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <label><b>Tipo: </b> {{ \App\Shared\EventType::get($event->type) }}</label>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <label><b>Fecha: </b> {{ date('d/m/Y', strtotime($event->start)) }}</label>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <label><b>Hora de inicio: </b> {{ date('H:i', strtotime($event->start)) }}</label>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <label><b>Hora de finalización: </b> {{ date('H:i', strtotime($event->end)) }}</label>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <label><b>Asistieron: <span id="info-attended">0</span></b> </label>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <label><b>No asistieron:  <span id="info-not-attended">0</span></b></label>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
                                <label><b>Nuevos:  <span id="info-news">0</span></b></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6">
                                <h3><b>Asistencia</b></h3>
                            </div>
                            <div class="col-6 pull-right">
                                @if ($event->validForSettings())
                                    <button onclick="changeAll(true)" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Marcar a todos como asistentes" type="button" class="btn btn-icon btn-success border border-2 rounded-circle btn-dashed ms-2">
                                        <i data-feather="check" class="nav-icon icon-xs"></i>
                                    </button>
                                    <button onclick="changeAll(false)" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Marcar a todos como inasistentes" type="button" class="btn btn-icon btn-danger border border-2 rounded-circle btn-dashed ms-2">
                                        <i data-feather="x" class="nav-icon icon-xs"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div id="assistants">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 mt-5 pull-right">
                <button onclick="save()" class="btn btn-primary w-100 btn-loading">Guardar</button>
                <div class="text-center loading">
                    <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Por favor espere...</span>
                    </div>
                  </div>
            </div>
        </div>
    </div>
    {{ view('event.settings.settings-script', compact(['event'])) }}

    <style>
        .attended{
            background-color: #baedd5;
            border-radius: 15px;
        }
    </style>
@endsection