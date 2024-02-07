<script>
    const urlValidatePeople = "{{env('APP_URL')}}/people/find-by-phone/"
    async function validatePeople() {
        let value = $("#phone-validate-people").val()
        if(isEmpty(value)){
            showAlert("Error", "El campo de validación es obligatorio", "error")
            return;
        }
        setLoading(true, "btn-validate-people", "loading-validate-people")
        try {
            let validation = await $.get(urlValidatePeople + value)
            setLoading(false, "btn-validate-people", "loading-validate-people")
            if(validation.error) throw validation.message
            let search = validation.data
            if(search != null){
                let message = `Se encontro que el número de telefono pertenece a ${search.fullname + " " + search.lastname} ¿Deseas agregarlo como asistente del evento?`
                showAlert("!Confirma¡", message, "info", () => {
                    postSaveForm(validation, false)
                }, null, "Sí", "Cancelar")
            }else{
                $("#dialog-validate-people").modal('hide')
                openEdit(JSON.stringify(
                    {
                        phone: value, 
                        type: "{{\App\Shared\PeopleType::FOLLOWER}}",
                        status: "{{\App\Shared\PeopleStatus::ACTIVE}}"
                    }))
            }              
        } catch (error) {
            showAlert("Error", error, "error")
            setLoading(false, "btn-validate-people", "loading-validate-people")
        }
    }

    function closeValidatePeople() {
        $("#dialog-validate-people").modal('hide')
        $("#phone-validate-people").val("")
    }
</script>