@extends('layout.principal')
@section('content')
    <div class="bg-primary pt-10 pb-21"></div>
    <div class="container-fluid mt-n22 px-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mb-2 mb-lg-0">
                            <h3 class="mb-0  text-white">Configuración grupo de conexión</h3>
                        </div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-6">
            <div class="col-md-12 col-12">
                <div class="card p-5">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <label for="validationCustom01" class="form-label"><b>Nombre<span class="required">*</span></b></label>
                            <input type="text" class="form-control property" id="name" name="name" required>
                        </div>
                        <div class="col-md-12 col-sm-12 mt-2">
                            <label for="validationCustom01" class="form-label"><b>Red<span class="required">*</span></b></label>
                            <select class="form-select property" id="red" name="red">
                                @foreach (\App\Shared\RedType::LIST as $item)
                                    <option value="{{ $item["code"] }}">{{ $item["text"] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 col-sm-12 mt-2">
                            <label for="validationCustom01" class="form-label"><b>Lideres de segmento encargados<span class="required">*</span></b></label>
                            <select class="form-select property select2" multiple id="segment_leaders" name="segment_leaders">
                                @foreach (\App\Models\People::getActives([\App\Shared\PeopleType::SEGMENT_LEADER ]) as $item)
                                    <option value="{{ $item->id }}">{{ $item->names() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 col-sm-12 mt-2">
                            <label for="validationCustom01" class="form-label"><b>Lideres de grupo<span class="required">*</span></b></label>
                            <select class="form-select property select2" multiple id="leaders" name="leaders">
                                @foreach (\App\Models\People::getActives([ \App\Shared\PeopleType::LEADER, \App\Shared\PeopleType::SEGMENT_LEADER]) as $item)
                                    <option value="{{ $item->id }}">{{ $item->names() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 col-sm-12 mt-2">
                            <label for="validationCustom01" class="form-label"><b>Estado<span class="required">*</span></b></label>
                                <select class="form-select property" id="status" name="status">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                        </div>
                        
                        <div class="col-md-12 col-sm-12 mt-2">
                            <hr>
                            <h3>Asignación de personas automático</h3>
                        </div>
                        
                        <div class="col-md-12 col-sm-12 mt-2">
                            <div class="form-check">
                                <input type="hidden" class="property" id="check_years">
                                <input class="form-check-input" type="checkbox" value="" id="in-check-years" name="check-years" onchange="validateYears()">
                                <label class="form-check-label" for="in-check-years">
                                    A este grupo se asignarán personas según su edad
                                </label>
                            </div>
                        </div>

                        <div id="div-years" class="hide">
                            <div class="col-md-12 col-sm-12 mt-2">
                                <label for="validationCustom01" class="form-label"><b>Edad inicial<span class="required">*</span></b></label>
                                <input type="number" class="form-control property" id="initial_age" name="initial_age" required>
                            </div>
                            <div class="col-md-12 col-sm-12 mt-2">
                                <label for="validationCustom01" class="form-label"><b>Edad final<span class="required">*</span></b></label>
                                <input type="number" class="form-control property" id="final_age" name="final_age" required>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 mt-2">
                            <div class="form-check">
                                <input type="hidden" class="property" id="check_neighborhoods">
                                <input class="form-check-input" type="checkbox" value="" id="in-check-neighborhoods" onchange="validateNeighborhoods()">
                                <label class="form-check-label" for="in-check-neighborhoods">
                                    A este grupo se asignarán personas según barrios especificos
                                </label>
                            </div>
                        </div>

                        <div id="div-neighborhoods" class="hide">
                            <div class="col-md-12 col-sm-12 mt-2">
                                <label for="validationCustom01" class="form-label"><b>Barrios que el grupo aceptara<span class="required">*</span></b></label>
                                <select class="form-select property select2" multiple id="neighborhoods" name="neighborhoods">
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 mt-2">
                            <div class="form-check">
                                <input type="hidden" class="property" id="check_couples">
                                <input class="form-check-input" type="checkbox" value="" id="in-check-couples" name="in-check-couples" onchange="validateCouples()">
                                <label class="form-check-label" for="in-check-couples">
                                    A este grupo se asignarán personas casadas o en unión libre
                                </label>
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
            </div>
        </div>
    </div>
    {{ view('conection-group.form.form-script', compact(['entity'])) }}
@endsection