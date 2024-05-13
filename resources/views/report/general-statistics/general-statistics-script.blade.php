<script> 
    $(document).ready(() => {
        $("#nav-toggle").click()
    })
    const urlFindConectionGroups = "{{env('APP_URL')}}/conection-group/find-by-red/"
    const urlGenerate = "{{env('APP_URL')}}/report/generate-general-statistics"

    function localLoading(loading) {
        $("#div-actions").css("display", loading ? "none" : "block")
        $("#div-loading").css("display", loading ? "block" : "none")
    }

    async function validateType() {
        let type = $("#type option:selected").text();
        await isConectionGroup(type)
    }

    async function isConectionGroup(type) {
        let typeConectionGroup = "{{ \App\Shared\EventType::get(\App\Shared\EventType::CONECTIONS_GROUP) }}"
        if (type == typeConectionGroup) {
            $("#div_conection_group_id").fadeIn()
            await findConectionGroups()
        }else{
            $("#div_conection_group_id").fadeOut()
            $("#conection_group_id").val(null);
        }
    }

    async function findConectionGroups() {
        let red = $("#red").val()
        if(!isEmpty(red)){
            try {
                setLoading(true)
                validation = await $.get(urlFindConectionGroups + red)
                setLoading(false)
                if(validation.error) throw validation.message
                setDataSelect(validation.data, "id", "name", "conection_group_id", true, "Todos")
            } catch (error) {
                setLoading(false)
                showAlert("Error", error, "error")
            }
        }
    }

    async function generate() {
        try {
            localLoading(true)
            let red = $("#red").val()
            let request = {
                start: $("#start").val(),
                end: $("#end").val(),
                type: $("#type").val(),
                red: $("#red").val(),
                conection_group_id: $("#conection_group_id").val()
            }
            let validation = await $.post(urlGenerate, request)
            localLoading(false)
            if(validation.error) throw validation.message
            drawStatistics(validation.data)
        } catch (error) {
            localLoading(false)
            showAlert("Error", error, "error")
        }
    }

    function drawStatistics(response) {
        const data = response.totalByDate;
        new Chart(document.getElementById('totalByDate'),
            {
                type: 'line',
                options: {
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            text: 'Grafico asistencial por fecha'
                        }
                    }
                },
                data: {
                    labels: data.map(row => row.date),
                    datasets: [
                        {
                            label: 'Asistentes',
                            data: data.map(row => row.attendeds),
                            borderColor: '#FF6384',
                            backgroundColor: '#FFB1C1',
                            pointStyle: 'circle',
                            pointRadius: 10,
                            pointHoverRadius: 15
                        },
                        {
                            label: 'Nuevos',
                            data: data.map(row => row.news),
                            borderColor: '#36A2EB',
                            backgroundColor: '#9BD0F5',
                            pointStyle: 'circle',
                            pointRadius: 10,
                            pointHoverRadius: 15
                            
                        },
                        {
                            label: 'Registrados',
                            data: data.map(row => row.total),
                            borderColor: '#eb6000',
                            backgroundColor: '#f08d49',
                            pointStyle: 'circle',
                            pointRadius: 10,
                            pointHoverRadius: 15                            
                        }
                    ]
                }
            }
        );
        $(".div-charts").fadeIn()
    }
</script>