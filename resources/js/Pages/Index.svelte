<script>
    import Calendar from '@event-calendar/core';
    import TimeGrid from '@event-calendar/time-grid';
    import DayGrid from '@event-calendar/day-grid';
    import ResourceTimeGrid from '@event-calendar/resource-time-grid';
    import Interaction from '@event-calendar/interaction';
    import '@event-calendar/core/index.css';

    function handleDateClick(e) {
        console.log("Date click: ",e);
    }

    function handleEventClick(e) {
        console.log("Event click: ", e);
    }

    let plugins = [TimeGrid, DayGrid, ResourceTimeGrid, Interaction];
    let options = {
        view: 'dayGridMonth',
        firstDay: 1,
        dateClick: (e) => handleDateClick(e),
        eventClick: (e) => handleEventClick(e),
        events: [
            // your list of events
            {
                id: 1,
                start: '2023-10-16',
                end: '2023-10-16',
                title: '7',
                editable: true,
                backgroundColor: '#B2FFD6',
                textColor: 'black',
            },
            {
                id: 2,
                start: '2023-10-16',
                end: '2023-10-16',
                title: '3',
                editable: true,
                backgroundColor: '#F8A7A5',
                textColor: 'black',
            }
        ]
    };

    export let title;
</script>


<div class="flex flex-col items-center text-center space-y-4">
    <h1 class="block mt-4 font-bold text-4xl">{title}</h1>
    <div class="container">
        <Calendar {plugins} {options} />
    </div>

</div>
