<script>
    const urlSave = "{{env('APP_URL')}}/event/create"
    const urlUpdate = "{{env('APP_URL')}}/event/update"
    const urlFindConectionGroups = "{{env('APP_URL')}}/conection-group/find-by-red/"
    const urlCancel = "{{env('APP_URL')}}/event/cancel/"

    const requiredFields = [
        { property: "type", message: "Tipo de evento es un campo obligatorio" },
        { property: "red", message: "La red es un campo obligatorio" },
        { property: "title", message: "Titulo es un campo obligatorio" },
        { property: "start", message: "Fecha inicial es un campo obligatorio" },
        { property: "end", message: "Fecha final es un campo obligatorio" },
        { property: "days", message: "Dias de evento es un campo obligatorio" }
    ];

    function posOpenEdit(entity) {
        if(!isEmpty(entity.id)){
            $("#box-cancel").fadeIn()
        }else{
            $("#box-cancel").fadeOut()
        }
        $("#start").val(parseDateEventShow(entity.start))
        $("#end").val(parseDateEventShow(entity.end))
        $('#days').trigger('change.select2');
    }

    function validateType() {
        let type = $("#type option:selected").text();
        isConectionGroup(type)
    }

    async function isConectionGroup(type) {
        let typeConectionGroup = "{{ \App\Shared\EventType::get(\App\Shared\EventType::CONECTIONS_GROUP) }}"
        if (type == typeConectionGroup) {
            await findConectionGroups()
            $("#box-group").fadeIn()
            requiredFields.push({ property: "conection_group_id", message: "El grupo de conexión es un campo obligatorio." })
        }else{
            requiredFields = requiredFields.filter(item => item.property != "conection_group_id")
            $("#box-group").fadeOut()
        }
    }

    async function findConectionGroups() {
        try {
            setLoading(true)
            let red = $("#red").val()
            validation = await $.get(urlFindConectionGroups + red)
            setLoading(false)
            if(validation.error) throw validation.message
            setDataSelect(validation.data, "id", "name", "conection_group_id")
        } catch (error) {
            setLoading(false)
            showAlert("Error", error, "error")
        }
    }

    async function cancelEvent() {
        let observations = prompt("Indique el motivo de cancelación del evento");
        if (!isEmpty(observations)) {
            try {
                setLoading(true)
                let request = { observations: observations }
                validation = await $.put(urlCancel + this.id, request)
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
    }
</script>