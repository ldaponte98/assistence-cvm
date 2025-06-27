<script>

    const urlFindConectionGroups = "{{env('APP_URL')}}/conection-group/find-by-red/"

    function find() {
        setLoadingFullScreen(true)
        $("#form-report").submit()
    }

    function validateClassification(){
        let option = $("#classification option:selected").val();
        if (option == "{{ \App\Shared\ClassificationType::NEWS_IN_RED }}" || option == "{{ \App\Shared\ClassificationType::OLDS_IN_RED }}") {
            $("#div_red").fadeIn()
            $("#div_conection_group_id").fadeIn()
        }else{
            $("#div_red").fadeOut()
            $("#div_conection_group_id").fadeOut()
        }
    }

    async function validateType() {
        await findConectionGroups()
    }

    async function findConectionGroups() {
        let red = $("#red").val()
        if(!isEmpty(red)){
            try {
                setLoading(true)
                validation = await $.get(urlFindConectionGroups + red)
                setLoading(false)
                if(validation.error) throw validation.message
                setDataSelect(validation.data, "id", "name", "conection_group_id", true, "Todos")
            } catch (error) {
                setLoading(false)
                showAlert("Error", error, "error")
            }
        }
    }
</script>