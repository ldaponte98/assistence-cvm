@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Inicio (Eventos)</h3>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($events as $event)
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <div class="card hand" onclick="location.href = '{{ route('event/settings', $event->id) }}'">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">{{ $event->title }}</h4>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary text-primary
                        rounded-2">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <h1 class="fw-bold">{{ date('H:i', strtotime($event->start)) }}</h1>
                            <p class="mb-0"> {{ $event->getInfo() }} </p>
                        </div>
                        @if ($event->managed == 1)
                            <span class="badge bg-success">Asistencia tomada</span>
                        @else
                            <span class="badge bg-warning">Sin asistencia registrada</span>
                        @endif
                        
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
