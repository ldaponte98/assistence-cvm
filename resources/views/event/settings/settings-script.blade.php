<script>
    let eventValid = {{ $event->validForSettings() == false ? 'false' : true }}
    const urlSaveAssistance = "{{env('APP_URL')}}/event/save-assistance"
    const urlFindAssistants = "{{env('APP_URL')}}/event/find-assistants/{{$event->id}}"
    
    var assistants = []

    $(document).ready(async () => {
        await findAssistants()
        refreshAssistants()
    })

    function changeAll(attended) {
        if(eventValid){
            assistants = assistants.map((item) => { item.attended = attended; return item })
            refreshAssistants()
        }
    }

    function changeAssistant(id) {
        if(eventValid){
            assistants = assistants.map((item) => { if(item.id == id) item.attended = !item.attended; return item })
            refreshAssistants()
        }
    }

    function refreshAssistants() {
        let render = ""
        let renderIsNew = `<span class="badge bg-success">Nuevo</span>`
        let attended = 0
        let news = 0
        assistants.forEach((item) => {
            if(item.attended) attended++
            if(item.isNew) news++
            render += `<div onclick="changeAssistant(${item.id})" class="row hand ${item.attended ? 'attended' : ''}">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-2 mb-2">
                                    <label class="hand"><b> ${item.name} </b></label> ${item.isNew ? renderIsNew : ""}
                                </div>
                            </div>
                        <hr>`
        })
        if(render == "") render = "<label>No hay personas que asistieron al evento<label>"
        $("#info-attended").html(attended)
        $("#info-not-attended").html(assistants.length - attended)
        $("#info-news").html(news)
        $("#assistants").html(render)
    }
    //CUANDO SE REGISTRA UN NUEVO ASISTENTE
    function postSaveForm(responseApi, isNew = true) {
        clean()
        $(".btn-close").click()
        let people = responseApi.data;
        assistants.push({
            id: people.id,
            name: people.fullname + " " + (people.lastname != null ? people.lastname : ""),
            attended: true,
            isNew: isNew
        })
        refreshAssistants()
    }

    async function findAssistants() {
        setLoadingFullScreen(true)
        try{
            let validation = await $.get(urlFindAssistants)
            setLoadingFullScreen(false)
            if(validation.error) throw validation.message
            assistants = validation.data
        } catch (error) {
            setLoadingFullScreen(false)
            showAlert("Error", error, "error")
        }    
    }

    async function saveAssistance(validateLength = true) {
        try{
            let go = true
            if(assistants.length == 0 && validateLength){
                go = false
                showAlert("Confirmación", "No hay asistentes en el evento, ¿Esta seguro de registrar la asistencia sin asistentes?", "info", () => {
                    saveAssistance(false)
                })
            }
            if(go){
                setLoadingFullScreen(true)
                let event_id = "{{$event->id}}"
                let request = {
                    event_id: event_id,
                    assistants: this.assistants,
                    observations: $("#observations").val()
                }
                console.log({request: request})
                let validation = await $.post(urlSaveAssistance, request)
                setLoadingFullScreen(false)
                if(validation.error) throw validation.message
                showAlert("!Listo¡", validation.message, "success", () => {
                    setLoadingFullScreen(true)
                    location.reload()
                })
            }            
        } catch (error) {
            setLoadingFullScreen(false)
            showAlert("Error", error, "error")
        }
    }

</script>