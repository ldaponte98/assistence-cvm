<script>
    const urlFind = "{{env('APP_URL')}}/report/get-assistance-general"
    $(document).ready(() => {
        setFilter("filter-assistance-general", "tb-assistance-general")
    })

    async function find() {
        try {
            setLoading(true)
            let red = $("#red").val()
            let request = {
                start: $("#start").val(),
                end: $("#end").val(),
                type: $("#type").val(),
                red: $("#red").val()
            }
            let validation = await $.post(urlFind, request)
            setLoading(false)
            if(validation.error) throw validation.message
            drawBody(validation.data)
        } catch (error) {
            setLoading(false)
            showAlert("Error", error, "error")
        }
    }

    function drawBody(response) {
        let data = response.length == 0 ? "<tr><td colspan='8'><center>No se encontraron resultados</center></td></tr>" : "";
        let totals = {
            total: 0,
            attendeds: 0,
            not_attendeds: 0,
            news: 0
        }
        response.forEach(element => {
            let row = `<tr>
                <td>${element.title}</td>
                <td>${element.start}</td>
                <td>${element.end}</td>
                <td>${element.assistance}</td>
                <td>${element.total}</td>
                <td>${element.attendeds}</td>
                <td>${element.not_attendeds}</td>
                <td>${element.news}</td>
                <td class="center">
                    <a href="{{ route('event/settings', '-param-') }}" target="_blank" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Ver detalle de evento" type="button" class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2">
                        <i data-feather="eye" class="nav-icon icon-xs"></i>
                    </a>
                </td>
            </tr>`
            row = row.replaceAll("-param-", element.event_id);
            data += row;
            totals.total += parseFloat(element.total);
            totals.attendeds += parseFloat(element.attendeds);
            totals.not_attendeds += parseFloat(element.not_attendeds);
            totals.news += parseFloat(element.news);
        });
        let footer = `<tr>
            <td colspan="4"><b>Totales</b></td>
            <td><b>${totals.total}</b></td>
            <td><b>${totals.attendeds}</b></td>
            <td><b>${totals.not_attendeds}</b></td>
            <td><b>${totals.news}</b></td>
            <td></td>
        </tr>`
        $("#tb-assistance-general tbody").html(data + footer)
        if(response.length > 0){
            $("#btn-export").fadeIn()
        }else{
            $("#btn-export").fadeOut()
        }
        refreshTables()
    }

    function exportReport() {
        tableToExcel("tb-assistance-general", "Reporte de asistencias")
    }
</script>