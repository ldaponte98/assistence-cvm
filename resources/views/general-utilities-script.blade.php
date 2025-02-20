<script>
    async function findInfoPeoples(value) {
        if(value.length > 3){
            let validation = await $.get("{{env('APP_URL')}}/people/find-by-characters/" + value)
            $("#people").autocomplete({
                source: validation.map((item) => { return item.info })
            });
            $("#people").autocomplete("search");
        }
    }
</script>