@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="d-flex justify-content-between align-items-center block-mobile">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 text-white">Detalles del evento: <b>{{ $event->title }}</b></h3>
                    </div>
                    <div>
                        @if ($event->validForSettings())
                            <button onclick="$('#dialog-validate-people').modal('show'); $('#phone-validate-people').focus()" class="btn btn-white mobile-w-100" type="button">+ Nuevo asistente</button>
                            <button id="btn-entity" class="btn btn-white mobile-w-100 hide" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">+ Nuevo asistente</button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h4 id="offcanvasRightLabel"><b>Nuevo asistente</b></h4>
                                    <button onclick="clean()" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    {{ view("people.form.form") }}
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
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mt-2">
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
                            @if ($event->type == \App\Shared\EventType::CONECTIONS_GROUP)
                            @php
                                $leaders = $event->conection_group->getLeadersFull();
                                $text = "";
                                foreach ($leaders as $leader) {
                                    if($text != "") $text .= ", ";
                                    $text .= $leader->names();
                                }
                            @endphp
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-2">
                                <label><b>Lideres: </b><span id="info-news">{{ $text }}</span></label>
                            </div>
                            @endif
                            
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
                                <button onclick="exportReport()" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Exportar" type="button" class="btn btn-icon btn-success border border-2 rounded-circle btn-dashed ms-2">
                                    <i data-feather="file-text" class="nav-icon icon-xs"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row mt-6">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap mb-0" id="tb-detail-event">
                                            <thead class="table-light">
                                                
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ view('event.detail-event.detail-event-script', compact(['event'])) }}

    <style>
        .attended{
            background-color: #baedd5;
            border-radius: 15px;
        }
    </style>
@endsection
