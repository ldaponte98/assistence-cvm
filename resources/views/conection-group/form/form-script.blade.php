<script>
    const urlSave = "{{env('APP_URL')}}/conection-group/create"
    const urlUpdate = "{{env('APP_URL')}}/conection-group/update"
    const urlGetNeighborhoods = "{{asset('neighborhoods.json')}}"
    
    $(document).ready(async () => {
        await getNeighborhoods()
        @if ($entity->id != null)
        @php
            $json = json_encode($entity);
                echo "openEdit(`$json`);";
            @endphp
        @endif
        
    })

    function posOpenEdit(entity) {
        console.log({entity: entity})
        $("#leaders").val(entity.leaders.map(item => item.id));
        $("#segment_leaders").val(entity.segment_leaders.map(item => item.id));
        console.log({segments: entity.segment_leaders.map(item => item.id)})
        if(entity.check_years == 1){
            $("#in-check-years").prop('checked', true)
            validateYears()
        } 

        if(entity.check_neighborhoods == 1){
            $("#in-check-neighborhoods").prop('checked', true)
            let array = entity.neighborhoods.split("%%")
            console.log({array: array})
            $("#neighborhoods").val(array);
            validateNeighborhoods()
        }else{
            $("#neighborhoods").val([]);
            validateNeighborhoods()
        } 

        if(entity.check_couples == 1){
            $("#in-check-couples").prop('checked', true)
            validateCouples()
        } 
        $('.select2').trigger('change.select2');
    }
    
    var requiredFields = [
        { property: "name", message: "Nombre del grupo es un campo obligatorio" },
        { property: "red", message: "Telefono es un campo obligatorio" },
        { property: "segment_leaders", message: "Lideres de segmento encargado asociado es un campo obligatorio" },
        { property: "leaders", message: "Lideres asociados es un campo obligatorio" },
        { property: "status", message: "Estado es un campo obligatorio" }
    ];

    function validateYears() {
        let value = $("#in-check-years").prop('checked')
        if(value){
            $("#check_years").val(1)
            $("#div-years").fadeIn()
            requiredFields.push({ property: "initial_age", message: "Fecha inicial es un campo obligatorio." })
            requiredFields.push({ property: "final_age", message: "Fecha final es un campo obligatorio." })
            requiredFields.push({ property: "check_years", message: "" })
        }else{
            $("#check_years").val(0)
            requiredFields = requiredFields.filter(p => p.property != "initial_age" && p.property != "final_age" && p.property != "check_years")
            $("#div-years").fadeOut()
        }
    }

    function validateNeighborhoods() {
        let value = $("#in-check-neighborhoods").prop('checked')
        if(value){
            $("#check_neighborhoods").val(1)
            $("#div-neighborhoods").fadeIn()
            requiredFields.push({ property: "check_neighborhoods", message: "" })
            requiredFields.push({ property: "neighborhoods", message: "Barrios asociados es un campo obligatorio." })
        }else{
            $("#check_neighborhoods").val(0)
            requiredFields = requiredFields.filter(p => p.property != "neighborhoods" && p.property != "check_neighborhoods")
            $("#div-neighborhoods").fadeOut()
        }
    }

    function validateCouples() {
        let value = $("#in-check-couples").prop('checked')
        if(value){
            $("#check_couples").val(1)
            requiredFields.push({ property: "check_couples", message: "" })
        }else{
            $("#check_couples").val(0)
            requiredFields = requiredFields.filter(p => p.property != "neighborhoods" && p.property != "check_couples")
        }
    }

    async function getNeighborhoods() {
        try {
            validation = await $.get(urlGetNeighborhoods)
            let data = validation.map((item) => {
                return {
                    id: item,
                    name: item
                }
            })
            setDataSelect(data, "id", "name", "neighborhoods", true, "")
        } catch (error) {
            showAlert("Error", error, "error")
        }
    }

    function postSaveForm(validation) {
        showAlert("!Listo¡", validation.message, "success", () => {
            location.href = "{{ route('conection-group/all') }}"
        })
    }
</script>