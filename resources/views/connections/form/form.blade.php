<div class="row">
    <div class="col-md-12 col-sm-12">
        <label for="validationCustom01" class="form-label"><b>Categorización<span class="required">*</span></b></label>
        <select class="form-select property" id="type" name="type">
            @foreach (\App\Shared\PeopleType::LIST as $item)
                <option value="{{ $item["code"] }}">{{ $item["text"] }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Telefono<span class="required">*</span></b></label>
        <input type="text" class="form-control property" id="phone" name="phone" required>
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Fecha de nacimiento<span class="required">*</span></b></label>
        <input type="text" class="form-control property datepicker" placeholder="aaaa-mm-dd" id="birthday" name="birthday" required>
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Nombres<span class="required">*</span></b></label>
        <input type="text" class="form-control property" id="fullname" name="fullname" required>
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Apellidos</b></label>
        <input type="text" class="form-control property" id="lastname" name="lastname">
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Documento identificación</b></label>
        <input type="text" class="form-control property" id="document" name="document">
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Correo electronico</b></label>
        <input type="text" class="form-control property" id="email" name="email">
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Genero<span class="required">*</span></b></label>
        <select class="form-select property" id="gender" name="gender">
            <option value="F">Femenino</option>
            <option value="M">Masculino</option>
        </select>
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Estado<span class="required">*</span></b></label>
        <select class="form-select property" id="status" name="status">
            @foreach (\App\Shared\PeopleStatus::LIST as $item)
                <option value="{{ $item["code"] }}">{{ $item["text"] }}</option>
            @endforeach
        </select>
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
{{ view('people.form.form-script') }}