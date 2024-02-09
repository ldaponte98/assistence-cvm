<script>
    function changeStatus(userId, status) {
        showAlert("Confirmación", `¿Seguro que desea ${status == 1 ? 'activar' : 'inactivar'} a este usuario?`, "info", async () => {
            setLoadingFullScreen(true)
            try {
                let validation = await $.put("{{env('APP_URL')}}/user/change-status/" + userId + "/" + status)
                if(validation.error) throw validation.message
                setLoadingFullScreen(false)
                showAlert("!Listo¡", validation.message, "success", () => {
                    location.reload()
                })
            } catch (error) {
                console.log({error_change_status: error})
                setLoadingFullScreen(false)
                showAlert("Error", `Ocurrio un error al cambiar el estado del usuario, porfavor comuniquese con el administrador del sistema.`, "error", () => {})
            }
            
        }, () => {})
    }
</script>