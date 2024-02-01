<script>
    let eventValid = {{ $event->validForSettings() }}
    let assistants = [
        {
            id: 1,
            name: "Luis Daniel Aponte",
            attended: true,
            isNew: false
        },
        {
            id: 2,
            name: "Angie Perez Florian",
            attended: true,
            isNew: false
        },
        {
            id: 3,
            name: "Cristian Perez",
            attended: true,
            isNew: true
        }
    ]

    $(document).ready(() => {
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
                                    <label class="hand"> ${item.name} </label> ${item.isNew ? renderIsNew : ""}
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
</script>