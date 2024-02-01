<script>
    const urlSave = "{{env('APP_URL')}}/conection-group/create"
    const urlUpdate = "{{env('APP_URL')}}/conection-group/update"
    const requiredFields = [
        { property: "name", message: "Categorización es un campo obligatorio" },
        { property: "red", message: "Telefono es un campo obligatorio" },
        { property: "initial_age", message: "Nombres es un campo obligatorio" },
        { property: "final_age", message: "Estado es un campo obligatorio" },
        { property: "segment_leaders", message: "Lideres de segmento encargado asociado es un campo obligatorio" },
        { property: "leaders", message: "Lideres asociados es un campo obligatorio" },
        { property: "status", message: "Estado es un campo obligatorio" }
    ];

    function posOpenEdit(entity) {
        console.log({entity: entity})
        $("#leaders").val(entity.leaders.map(item => item.id));
        $("#segment_leaders").val(entity.segment_leaders.map(item => item.id));
        $('.select2').trigger('change.select2');
    }

    async function findInfoPeoples(value, idInput, type) {
        if(value.length > 3){
            let validation = await $.get("{{env('APP_URL')}}/people/find-by-characters/" + value + "/" + type)
            $("#" + idInput).autocomplete({
                source: validation.map((item) => { return item.info })
            });
            $("#" + idInput).autocomplete("search");
        }
    }
</script>