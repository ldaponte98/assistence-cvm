@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Historial de personal</h3>
                        </div>
                        <div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-6">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="form-control">
                        <div class="col-md-12 col-sm-12 mt-2">
                            <form method="POST" action="" id="form-history">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-10">
                                        <label for="validationCustom01" class="form-label"><b>Registro en base de datos<span class="required">*</span></b></label>
                                        <input onkeyup="findInfoPeoples(this.value)" type="text" class="form-control property" id="people" name="people" placeholder="Escribe cualquier campo de la persona previamente registrada" required>
                                    </div>
                                    <div class="col-sm-2 mt-2">
                                        <br>
                                        <button class="btn btn-primary w-100 right">Consultar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($error)
                        <br>
                            <div class="alert alert-danger">{{$error}}</div>
                            <script>setTimeout(() => {$(".alert").fadeOut()}, 8000)</script>
                        @endif

                        @if (isset($people))
                        
                            <div class="table-responsive mt-5">
                                <h6><b>Resultados encontrados</b></h6>
                                <table class="table table-bordered text-tran-none" id="tb-history-people">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20%"><b>Nombre</b></th>
                                            <th>{{$people->fullname}}</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 20%"><b>Apellido</b></th>
                                            <th>{{$people->lastname}}</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 20%"><b>Categorización</b></th>
                                            <th>{{$people->getTextType()}}</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 20%"><b>Telefono</b></th>
                                            <th>{{$people->phone ? $people->phone : "No definida"}}</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 20%"><b>Edad</b></th>
                                            <th>{{$people->birthday ? $people->getAge() . " años" : "No definida"}}</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 20%"><b>Fecha nacimiento</b></th>
                                            <th>{{$people->birthday ? $people->birthday : "No definida"}}</th>
                                        </tr>
                                        

                                        <tr>
                                            <th style="width: 20%"><b>Genero</b></th>
                                            <th>{{$people->gender ? ($people->gender == "M" ? "Hombre" : "Mujer") : "No definido"}}</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 20%"><b>Correo electrónico</b></th>
                                            <th>{{$people->email ? $people->email : "No definido"}}</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 20%"><b>Número de documento</b></th>
                                            <th>{{$people->document ? $people->document : "No definido"}}</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 20%"><b>Estado actual</b></th>
                                            <th>{{$people->getTextStatus() ? $people->getTextStatus() : "No definido"}}</th>
                                        </tr>
                                    </thead>
                                </table>
                                <br>
                                {{ view("people.history.tabs.tabs", compact("people")) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ view('people.history.history-script') }}
    {{ view('general-utilities-script') }}
@endsection