<div class="row">
    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Tipo<span class="required">*</span></b></label>
        <select class="form-select property" id="type" name="type" onchange="validateType()">
            <option value=""></option>
            @foreach (\App\Shared\EventType::LIST as $item)
                <option value="{{ $item["code"] }}">{{ $item["text"] }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12 col-sm-12 mt-2" id="box-red">
        <label for="validationCustom01" class="form-label"><b>Red<span class="required">*</span></b></label>
        <select class="form-select property" id="red" name="red" onchange="validateRed()">
            <option value=""></option>
            @foreach (\App\Shared\RedType::LIST as $item)
                @if (\App\Models\User::validRed($item["code"]))
                    <option value="{{ $item["code"] }}">{{ $item["text"] }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-12 col-sm-12 mt-2 hide" id="box-group">
        <label for="validationCustom01" class="form-label"><b>Grupo de conexión<span class="required">*</span></b></label>
        <select class="form-select select2 property" multiple id="conection_group_id" name="conection_group_id">
           
        </select>
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label class="form-label"><b>Titulo<span class="required">*</span></b></label>
        <input type="text" value="" class="form-control property" id="title" name="title" autocomplete="off">
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label class="form-label"><b>Fecha inicial<span class="required">*</span></b></label>
        <input type="text" value="" class="form-control property datetimepicker" id="start" name="start" autocomplete="off">
    </div>
    <div class="col-md-12 col-sm-12 mt-2">
        <label class="form-label"><b>Fecha final<span class="required">*</span></b></label>
        <input type="text" value="" class="form-control property datetimepicker" id="end" name="end" autocomplete="off">
    </div>

    <div class="col-md-12 col-sm-12 mt-2">
        <label for="validationCustom01" class="form-label"><b>Días<span class="required">*</span></b></label>
        <select class="form-select property select2" multiple id="days" name="days" placeholder="Seleccione">
            <option value="all">Todos los dias</option>
            <option value="monday">Lunes</option>
            <option value="tuesday">Martes</option>
            <option value="wednesday">Miercoles</option>
            <option value="thursday">Jueves</option>
            <option value="friday">Viernes</option>
            <option value="saturday">Sabado</option>
            <option value="sunday">Domingo</option>
        </select>
    </div>

    <div class="col-md-12 col-sm-12 mt-2 hide" id="box-autoregister">
        <label for="validationCustom01" class="form-label"><b>Autoregistro</b></label>
        <center>
            <a id="link-autoregister" target="_blank">
                <div id="qr-event"></div>
            </a>
        </center>
    </div>

    <div class="col-md-12 col-sm-12 mt-2 hide" id="box-link-play">
        <label for="validationCustom01" class="form-label"><b>Link para jugar</b></label><br>
        <a id="link-play" target="_blank">Presiona aquí</a>
    </div>
    
    <div class="col-md-12 col-sm-12 mt-5 pull-right">
        <button onclick="save()" class="btn btn-primary w-100 btn-loading">Guardar</button>
        <div class="text-center loading">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Por favor espere...</span>
            </div>
          </div>
    </div>

    <div class="col-md-12 col-sm-12 mt-2 pull-right hide" id="box-cancel">
        <button onclick="cancelEvent()" class="btn btn-primary w-100" id="btn-loading-cancel">Cancelar evento</button>
        <div class="text-center hide" id="loading-cancel">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Por favor espere...</span>
            </div>
          </div>
    </div>
</div>
{{ view('event.form.form-script') }}