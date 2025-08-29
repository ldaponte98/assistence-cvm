<script>
    const urlFindAssistants = "{{env('APP_URL')}}/event/find-assistants/{{$event->id}}"
    var configuration = {
        onlyNews: false,
        onlyAttend: false,
        winnerNotRepeat: false,
        countdown: 10
    }

    var finishInscription = false
    var assistantsOriginal = []
    var assistants = []
    var winners = []

    function configure() {
        this.configuration.onlyNews = $("#in-check-only-news").prop("checked");
        this.configuration.onlyAttend = $("#in-check-only-attend").prop("checked");
        this.configuration.winnerNotRepeat = $("#in-check-winner-not-repeat").prop("checked");
        this.configuration.countdown = $("#countdown").val() != "" ? $("#countdown").val() : this.configuration.countdown;
        $('#dialog-play').modal('hide');

        if (finishInscription) {
            refreshAssistants()
        }
    }

    function stop(){
        finishInscription = true; 
        $('#btn-stop').fadeOut(); 
        $('#btn-start').fadeIn();
    }

    async function findAssistants() {
        if (!finishInscription) {
            try{
                let validation = await $.get(urlFindAssistants)
                if(validation.error) throw validation.message
                assistantsOriginal = validation.data.result
                refreshAssistants()
                setTimeout(() => {
                    findAssistants()
                }, 3 * 1000);
            } catch (error) {
                showAlert("Error", error, "error")
            }
        }
    }

    function refreshAssistants() {
        let list = assistantsOriginal
        if (this.configuration.onlyNews) {
            list = list.filter(p => p.isNew);
        }
        if (this.configuration.onlyAttend) {
            list = list.filter(p => p.attended);
        }
        if (!this.configuration.winnerNotRepeat) {
            list = list.filter(p => winners.find(i => i.id == p.id) == null);
        }
        assistants = list
        $("#num-players").html(assistants.length)
    }

    function start() {
        if (assistants.length == 0) {
            showAlert("Error", "No hay participantes validos para empezar a jugar", "error")
            return;
        }
        $('#btn-start').fadeOut();
        let countdown = this.configuration.countdown;
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
        const winner = getRandom(assistants);
        winners.push(winner);
        $("#text-winner").html(`El ganador es <br> <b>${winner.name.toUpperCase()}</b>`);
        $('#btn-reset').fadeIn();
        congratulationsAnimation(".limiter");
    }

    function getRandom(list) {
        const index = Math.floor(Math.random() * list.length);

        return list[index];
    }

    function restart() {
        $('#btn-reset').fadeOut();
        $('#btn-start').fadeIn();
        $("#text-winner").html(`¿Quién ganará?`);
        refreshAssistants();
        resetCongratulationsAnimation();
    }

    $(document).ready(() => {
        findAssistants();
    })
</script>