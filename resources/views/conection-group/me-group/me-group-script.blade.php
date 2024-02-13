<script>
    const urlRemove = "{{env('APP_URL')}}/conection-group/remove-people/"

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
</script>