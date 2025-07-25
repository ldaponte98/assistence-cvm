<script>
    let eventValid = {{ $event->validForSettings() == false ? 'false' : true }}
    const urlSaveAssistance = "{{env('APP_URL')}}/event/save-assistance"
    const urlFindAssistants = "{{env('APP_URL')}}/event/find-assistants/{{$event->id}}"
    const urlAutoregister = "{{env('APP_URL')}}/event/autoregister/"
    const urlPlay = "{{env('APP_URL')}}/event/play/"

    var assistants = []
    var assistantsOrigin = []

    $(document).ready(async () => {
        await findAssistants()
        refreshAssistants()
        validateAutoregister()
        validateLinkPlay()
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
                                    <label class="hand"><img alt="avatar" src="${item.avatar}" class="rounded-circle" width="30" /> <b> ${item.name} </b></label> ${item.isNew ? renderIsNew : ""}
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
            isNew: isNew,
            avatar: people.gender == "F" ? "{{\App\Models\People::imageAvatar('F')}}" : "{{\App\Models\People::imageAvatar('M')}}"
        })
        refreshAssistants()
        saveAssistance(true, false)
    }

    async function findAssistants() {
        setLoadingFullScreen(true)
        try{
            let validation = await $.get(urlFindAssistants)
            setLoadingFullScreen(false)
            if(validation.error) throw validation.message
            assistants = validation.data.result
            assistantsOrigin = assistants
        } catch (error) {
            setLoadingFullScreen(false)
            showAlert("Error", error, "error")
        }    
    }

    async function saveAssistance(validateLength = true, refresh = true) {
        try{
            let go = true
            if(assistants.length == 0 && validateLength){
                go = false
                showAlert("Confirmación", "No hay asistentes en el evento, ¿Esta seguro de registrar la asistencia sin asistentes?", "info", () => {
                    saveAssistance(false)
                })
            }
            if(go){
                setLoadingFullScreen(true, "Guardando la asistencia...")
                let event_id = "{{$event->id}}"
                let request = {
                    event_id: event_id,
                    assistants: this.assistants,
                    observations: $("#observations").val()
                }
                let validation = await $.post(urlSaveAssistance, request)
                setLoadingFullScreen(false)
                if(validation.error) throw validation.message
                if(refresh) {
                        showAlert("!Listo¡", validation.message, "success", () => {
                        setLoadingFullScreen(true)
                        location.reload()
                    })
                }
            }            
        } catch (error) {
            setLoadingFullScreen(false)
            showAlert("Error", error, "error")
        }
    }

    function filterAissistant(value) {
        this.assistants = this.assistantsOrigin.filter(
            item => item.name.toUpperCase().replaceAll(" ", "")
            .includes(value.toUpperCase().replaceAll(" ", "")))
        refreshAssistants()
    }

    function validateAutoregister() {
        try {
            const link = urlAutoregister + "{{$event->id}}"
            $("#link-autoregister").attr('href', link);
            generateQR(link, "qr-event", 200, 200, "Da clic para abrir el formulario");
        } catch (error) {
            console.error(error)
        }
    }

    function validateLinkPlay() {
        $("#link-play").html(urlPlay + "{{$event->id}}");
        $("#link-play").attr("href", urlPlay + "{{$event->id}}");
        $("#box-link-play").fadeIn() 
    }

</script>