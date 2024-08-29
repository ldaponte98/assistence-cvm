<script>
    const urlRemove = "{{env('APP_URL')}}/conection-group/remove-people/"
    const urlAssignPeople = "{{env('APP_URL')}}/conection-group/assign-people"

    async function remove(peopleId, groupId) {
        showAlert("Confirmación", `¿Seguro que desea eliminar a esta persona del grupo de conexión?`, "info", async () => {
            setLoadingFullScreen(true)
            try {
                let validation = await $.delete(urlRemove + peopleId + "/" + groupId)
                if(validation.error) throw validation.message
                setLoadingFullScreen(false)
                showAlert("!Listo¡", validation.message, "success", () => {
                    location.reload()
                })
            } catch (error) {
                console.log({error_remove_status: error})
                setLoadingFullScreen(false)
                showAlert("Error", `Ocurrio un error al realizar el proceso, porfavor comuniquese con el administrador del sistema.`, "error", () => {})
            }
            
        }, () => {})
    }

    function showNew(groupId) {
        clean()
        let initEntity = {
            type: "{{ \App\Shared\PeopleType::FOLLOWER }}",
            status: "{{ \App\Shared\PeopleStatus::ACTIVE }}",
        }
        this.extraData.push({key: "conection_group_id", value: groupId})
        openEdit(JSON.stringify(initEntity))
    }

    async function postSaveForm(response) {
        clean()
        $(".btn-close").click()
        setLoadingFullScreen(true)
        let request = {
            group_id: {{ $group->id }},
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