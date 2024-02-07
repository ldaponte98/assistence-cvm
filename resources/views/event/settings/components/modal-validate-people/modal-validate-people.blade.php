<div class="modal fade" id="dialog-validate-people" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Validación de asistente</h5>
            <button onclick="closeValidatePeople()" type="button" class="btn-close" aria-label="Close" >
            
            </button>
        </div>
        <div class="modal-body">
            <center>
                <label><b>Por favor digite el número de teléfono del asistente.</b></label>
                <br>
                <input id="phone-validate-people" type="number" class="form-control">
            </center>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeValidatePeople()">Cancelar</button>
            <button type="button" class="btn btn-primary btn-loading" id="btn-validate-people" onclick="validatePeople()">Validar información</button>
            <div class="text-center loading" id="loading-validate-people">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Por favor espere...</span>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
{{ view('event.settings.components.modal-validate-people.modal-validate-people-script') }}