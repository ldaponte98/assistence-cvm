<script>
    const urlFind = "{{env('APP_URL')}}/event/find"

    $(document).ready(() => {
        findEvents();
    })

    function showNew() {
        clean()
        validateType();
        $("#btn-entity").click()
    }

    function InitializeCalendar(events = []) {
        let div = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(div, {
                initialView: isMobile() ? 'timeGridDay' : 'dayGridMonth',
                locale: 'es',
                dateClick: selectedDate,
                eventClick: selectedEvent,
                eventMouseLeave: hoverEvent,
                themeSystem: 'bootstrap5',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
                    longPressDelay: 0,
                },
                events: events
        });
        calendar.render();
    }

    async function findEvents() {
        try {
            setLoadingFullScreen(true)
            let validation = await $.get(urlFind)
            setLoadingFullScreen(false)
            if(validation.error) throw validation.message
            InitializeCalendar(validation.data)   
        } catch (error) {
            setLoadingFullScreen(false)
            showAlert("Error", error, "error")
        }   
    }

    function selectedDate(info) {
        let current = new Date()
        let hourStart = getHour(current)
        current.setHours(current.getHours() + 1)
        let hourEnd = getHour(current)

        openEdit(JSON.stringify({ days: "all", start: info.dateStr + " " + hourStart, end: info.dateStr + " " + hourEnd }))
    }

    function selectedEvent(info) {
        let event = {
            days: "all",
            start: info.event.start,
            end: info.event.end,
            id: info.event.id,
            title: info.event.title,
            red: info.event.red 
        }
        Object.assign(event, info.event.extendedProps);
        console.log({event: info.event})
        openEdit(JSON.stringify(event))
    }
    
    function hoverEvent(info) {
        let hourStart = getHour(info.event.start)
        let hourEnd = getHour(info.event.end)
        let title = info.event.title;
        if(info.event.extendedProps.conection_group_id != null){
            title += ` [${info.event.extendedProps.conection_group.name}]`
        }
        $(info.el).tooltip({ 
            title: title  + ` (Horario: ${hourStart} hasta ${hourEnd})` 
        });
    }
    
</script>