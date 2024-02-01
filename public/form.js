//ESTA FUNCIONALOIDAD ES PARA GLOBALIZAR LA LOGICA DEL CRUD

var id = null;

function clean() {
    this.id = null
    $(".property").val("")
}

function openEdit(json) {
    let entity = JSON.parse(json)
    clean()
    this.id = !isEmpty(entity.id) ? entity.id : null
    for (const property in entity) {
        $(`#${property}`).val(entity[property])
    }
    try {
        posOpenEdit(entity)
    } catch (error) {
        console.log("No se ejecuta posEdit")
    }
    $("#btn-entity").click()
}

function validateForm() {
    requiredFields.forEach(item => {
        if(isEmpty($("#" + item.property).val())) throw item.message;
    });
}

async function save() {
    try {
        setLoading(true)
        validateForm()
        let request = { id: this.id }
        $(".property").each(function(){
            let property = $(this).attr('id')
            request[property] = $("#" + property).val()
        });
        let validation = null;
        if(this.id == null) {
            validation = await $.post(urlSave, request)
        }else{
            validation = await $.put(urlUpdate, request)
        }
        setLoading(false)
        if(validation.error) throw validation.message
        showAlert("!Listo¡", validation.message, "success", () => {
            location.reload()
        })
    } catch (error) {
        setLoading(false)
        showAlert("Error", error, "error")
    }
}