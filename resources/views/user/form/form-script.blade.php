<script>
    const urlSave = "{{env('APP_URL')}}/user/create"
    const urlUpdate = "{{env('APP_URL')}}/user/update"
    const requiredFields = [
        { property: "red", message: "Red es un campo obligatorio" },
        { property: "username", message: "Nombre de usuario es un campo obligatorio" },
        { property: "password", message: "Contraseña es un campo obligatorio" },
        { property: "profile_id", message: "Perfil es un campo obligatorio" },
        { property: "people", message: "Registro en base de datos es un campo obligatorio" }
    ];

    function posOpenEdit(entity) {
        $("#people").val(entity.people.fullname + " " + entity.people.lastname + " (Tel: " + entity.people.phone + ")")
    }
</script>