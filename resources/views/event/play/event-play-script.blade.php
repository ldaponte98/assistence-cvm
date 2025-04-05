<script>
    const urlFindAssistants = "{{env('APP_URL')}}/event/find-assistants/{{$event->id}}"
    var configuration = {
        onlyNews: false
    }

    var finishInscription = false
    var assistants = []

    function configure() {
        this.configuration.onlyNews = $("#in-check-only-news").prop("checked");
    }

    async function findAssistants() {
        if (!finishInscription) {
            try{
                let validation = await $.get(urlFindAssistants)
                if(validation.error) throw validation.message
                assistants = validation.data
                $("#num-players").html(assistants.length)
                setTimeout(() => {
                    findAssistants()
                }, 3 * 1000);
            } catch (error) {
                showAlert("Error", error, "error")
            }
        } 
    }

    function start() {
        $('#btn-start').fadeOut();
        let countdown = 10;
        $("#text-winner").html(`El ganador se mostrara en <br><b class='counter-lb'>${countdown}</b>`);
        let interval = setInterval(() => { 
            countdown--;
            $("#text-winner").html(`El ganador se mostrara en <br><b class='counter-lb'>${countdown}</b>`);
            if (countdown <= 0) {
                clearInterval(interval);
                chooseWinner();
            }
        }, 1000);
    }

    function chooseWinner() {
        let list = assistants;
        if (configuration.onlyNews) {
            list = list.filter(p => p.isNew);
        }
        const winner = getRandom(list);
        $("#text-winner").html(`El ganador es <br> <b>${winner.name.toUpperCase()}</b>`);
        $('#btn-reset').fadeIn();
    }

    function getRandom(list) {
        const index = Math.floor(Math.random() * list.length);

        return list[index];
    }

    function restart() {
        $('#btn-reset').fadeOut();
        $('#btn-start').fadeIn();
        $("#text-winner").html(`¿Quién ganará?`);
    }

    $(document).ready(() => {
        findAssistants();
    })
</script>