<div class="row">
    <div class="col-md-12 col-sm-12">
        <label for="validationCustom01" class="form-label"><b>Usuario<span class="required">*</span></b></label>
        <input type="text" class="form-control property" id="username" name="username" autocomplete="off">
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Contraseña<span class="required">*</span></b></label>
        <input type="password" class="form-control property" id="password" name="password" autocomplete="off">
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Perfil<span class="required">*</span></b></label>
        <select class="form-select property" id="profile_id" name="profile_id">
            @foreach (\App\Models\Profile::getProfiles() as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Registro en base de datos<span class="required">*</span></b></label>
        <input onkeyup="findInfoPeoples(this.value)" type="text" class="form-control property" id="people" name="people" placeholder="Escribe cualquier campo de la persona previamente registrada" required>
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
{{ view('user.form.form-script') }}