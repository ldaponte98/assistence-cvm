<script>
    const urlSave = "{{env('APP_URL')}}/people/create"
    const urlUpdate = "{{env('APP_URL')}}/people/update"
    const requiredFields = [
        { property: "type", message: "Categorización es un campo obligatorio" },
        { property: "phone", message: "Telefono es un campo obligatorio" },
        { property: "fullname", message: "Nombres es un campo obligatorio" },
        { property: "gender", message: "Estado es un campo obligatorio" },
        { property: "status", message: "Estado es un campo obligatorio" }
    ];
</script>