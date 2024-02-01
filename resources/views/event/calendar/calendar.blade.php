@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Eventos</h3>
                        </div>
                        <div>
                            <button id="btn-entity" class="btn btn-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">+ Nuevo</button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h4 id="offcanvasRightLabel"><b>Gestión de evento</b></h4>
                                    <button onclick="clean()" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    {{ view("event.form.form") }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-6">
            <div class="col-md-12 col-12">
                <div class="card p-3">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
    {{ view('event.calendar.calendar-script') }}
@endsection