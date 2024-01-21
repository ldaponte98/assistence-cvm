<div class="row">
    <div class="col-md-12 col-sm-12">
        <label for="validationCustom01" class="form-label"><b>Usuario</b></label>
        <input type="text" class="form-control" id="username" value="" required>
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Contraseña</b></label>
        <input type="text" class="form-control" id="password" value="" required>
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Perfil</b></label>
        <select class="form-select">
            @foreach (\App\Models\Profile::getProfiles() as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Registro</b></label>
        <input onkeyup="findRegisters(this.value)" type="text" class="form-control" id="register" placeholder="Escribe cualquier campo de la persona previamente registrada" required>
    </div>
</div>
{{ view('user.form.form-script') }}