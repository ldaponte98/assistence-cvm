<script>
    let eventValid = {{ $event->validForSettings() == false ? 'false' : true }}
    const urlSaveAssistance = "{{env('APP_URL')}}/event/save-assistance"
    const urlFindAssistants = "{{env('APP_URL')}}/event/find-assistants/{{$event->id}}"
    const urlAutoregister = "{{env('APP_URL')}}/event/autoregister/"
    const urlPlay = "{{env('APP_URL')}}/event/play/"

    var assistants = []
    var questions = []
    var assistantsOrigin = []

    $(document).ready(async () => {
        await findAssistants()
        refreshAssistants()
    })

    function exportReport() {
        setLoadingFullScreen(true)
        tableToExcel("tb-detail-event", "Reporte detallado de evento {{$event->title}}")
        setLoadingFullScreen(false)
    }

    function refreshAssistants() {
        let render = ""
        let attended = 0
        let news = 0
        let headerQuestions = `
            <tr>
                <th class="center"><b>Nombre completo</b></th>
                <th class="center"><b>Tipo</b></th>
                <th class="center"><b>Participación</b></th>
                <th class="center"><b>Genero</b></th>
                <th class="center"><b>Telefono</b></th>
                <th class="center"><b>F. Nacimiento</b></th>
                <th class="center"><b>Edad</b></th>
                <th class="center"><b>Email</b></th>
                <th class="center"><b>Estado</b></th>`
        questions.forEach((item) => {
            headerQuestions += `<th class="center"><b>${item.question}</b></th>`
        })
        headerQuestions += `</tr>`
        assistants.forEach((item) => {
            if(item.attended) attended++
            if(item.isNew) news++
            render += `<tr>
                            <td>${item.name}</td>
                            <td>${item.type}</td>
                            <td>${item.isNew ? "Nuevo" : "Antiguo"}</td>
                            <td>${item.gender}</td>
                            <td>${item.phone != null ? item.phone : ""}</td>
                            <td>${item.birthday}</td>
                            <td>${item.age} años</td>
                            <td>${item.email != null ? item.email : ""}</td>
                            <td>${item.status}</td>`
            questions.forEach((question) => {
                let answer = item.questions.find(p => p.code == question.code)?.answer
                render += `<td>${answer != null ? answer : ""}</td>`
            })
            render += `</tr>`
        })
        if(render == "") render = "<label>No hay personas que asistieron al evento<label>"
        $("#info-attended").html(attended)
        $("#info-not-attended").html(assistants.length - attended)
        $("#info-news").html(news)
        $("#tb-detail-event thead").html(headerQuestions)
        $("#tb-detail-event tbody").html(render)
        setDatatable("tb-detail-event")
    }

    async function findAssistants() {
        setLoadingFullScreen(true)
        try{
            let validation = await $.get(urlFindAssistants)
            setLoadingFullScreen(false)
            if(validation.error) throw validation.message
            assistants = validation.data.result
            questions = validation.data.questions
            assistantsOrigin = assistants
        } catch (error) {
            setLoadingFullScreen(false)
            showAlert("Error", error, "error")
        }    
    }

</script>