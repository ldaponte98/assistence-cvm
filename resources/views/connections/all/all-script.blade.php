<script>
    const urlAssignPeople = "{{env('APP_URL')}}/connections/assign-member"
    
    setTypePeopleDefault("{{ \App\Shared\PeopleType::SERVER }}")

    async function postSaveForm(response) {
        clean()
        $(".btn-close").click()
        setLoadingFullScreen(true)
        let request = {
            people_id: response.data.id
        }
        let validation = await $.post(urlAssignPeople, request)
        setLoadingFullScreen(false)
        if(validation.error){
            showAlert("Error", validation.message, "error", 
            () => {
                $(".btn-close").click()
            })
            return;
        }
        showAlert("!Listo¡", validation.message, "success", 
        () => {
            setLoadingFullScreen(true)
            location.reload()
        })
    }
</script>