<script>
    $(document).ready(() => {
        findEvents();
    })

    function InitializeCalendar(events = []) {
        let div = document.getElementById('calendar');
        console.log({ev: events})
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

    function findEvents() {
        setLoadingFullScreen(true)
        setTimeout(() => {
            let events = [
                { 
                    title: 'Grupo de conexiones 21-24', 
                    start: '2024-01-12 19:00:00', 
                    end: '2024-01-12 21:00:00',
                    id: 123 
                },
                { 
                    title: 'Grupo de conexiones 18-20', 
                    start: '2024-01-12 19:00:00', 
                    end: '2024-01-12 21:00:00',
                    id: 123 
                }
            ] 
            setLoadingFullScreen(false)
            InitializeCalendar(events)   
        }, 2 * 1000);
    }

    function selectedDate(info) {
        console.log({info: info})
    }

    function selectedEvent(info) {
        console.log({event: info.event.id})
    }
    
    function hoverEvent(info) {
        $(info.el).tooltip({ title: info.event.title + " (Horario: )" });
    }
    
</script>