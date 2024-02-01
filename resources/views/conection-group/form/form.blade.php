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
        <label for="validationCustom01" class="form-label"><b>Edad inicial<span class="required">*</span></b></label>
        <input type="number" class="form-control property" id="initial_age" name="initial_age" required>
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Edad final<span class="required">*</span></b></label>
        <input type="number" class="form-control property" id="final_age" name="final_age" required>
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
        <label for="validationCustom01" class="form-label"><b>Lideres asociados<span class="required">*</span></b></label>
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
    <div class="col-md-12 col-sm-12 mt-5 pull-right">
        <button onclick="save()" class="btn btn-primary w-100 btn-loading">Guardar</button>
        <div class="text-center loading">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Por favor espere...</span>
            </div>
          </div>
    </div>
</div>
{{ view('conection-group.form.form-script') }}