<script>
    var idUser = null;

    async function findInfoPeoples(value) {
        if(value.length > 3){
            let validation = await $.get("{{env('APP_URL')}}/people/find-by-characters/" + value)
            $("#people").autocomplete({
                source: validation.map((item) => { return item.info })
            });
            $("#people").autocomplete("search");
        }
    }

    function clean() {
        this.idUser = null
        $("#username").val("")
        $("#password").val("")
        $("#profile_id").val("")
        $("#people").val("")
    }

    function openEdit(jsonUser) {
        let user = JSON.parse(jsonUser)
        clean()
        this.idUser = user.id
        $("#username").val(user.username)
        $("#password").val(user.password)
        $("#profile_id").val(user.profile_id)
        $("#people").val(user.people.fullname + " " + user.people.lastname + " (Tel: " + user.people.phone + ")")
        $("#btn-user").click()
    }

    function validateForm() {
        if($("#username").val() == "") throw "Nombre de usuario obligatorio";
        if($("#password").val() == "") throw "Contraseña obligatoria";
        if($("#profile_id").val() == "") throw "Perfil obligatorio";
        if($("#people").val() == "") throw "Registro de base de datos obligatorio";
    }

    async function save() {
        try {
            setLoading(true)
            validateForm()
            let request = {
                id: this.idUser,
                username: $("#username").val(),
                password: $("#password").val(),
                profile_id: $("#profile_id").val(),
                people: $("#people").val()
            }
            let validation = null;
            if(this.idUser == null) {
                validation = await $.post("{{env('APP_URL')}}/user/create", request)
            }else{
                validation = await $.put("{{env('APP_URL')}}/user/update", request)
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

</script>