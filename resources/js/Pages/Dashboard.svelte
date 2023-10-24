<script>
    import Layout from "./Components/Layout.svelte";
    import Calendar from "@event-calendar/core";
    import TimeGrid from "@event-calendar/time-grid";
    import DayGrid from "@event-calendar/day-grid";
    import ResourceTimeGrid from "@event-calendar/resource-time-grid";
    import Interaction from "@event-calendar/interaction";
    import "@event-calendar/core/index.css";
    import ViewSelector from "./Components/ViewSelector.svelte";
    import { Progressbar } from "flowbite-svelte";
    import moment from "moment";
    import { momentLocale } from "./Components/MomentWithLocale.js";
    import TimesheetTypeSelector from "./Components/TimesheetTypeSelector.svelte";
    import TimesheetProjectSelector from "./Components/TimesheetProjectSelector.svelte";
    import { Input, Textarea, Checkbox, Button } from "flowbite-svelte";
    import TimesheetTimeSelector from "./Components/TimesheetTimeSelector.svelte";
    import StatMonthSelector from "./Components/StatMonthSelector.svelte";

    const progressGraduation = ["0", "1", "2", "3", "4", "5", "6", "7"];
    function handleDateClick(e) {
        console.log("Date click: ", e.date);
        console.log(e.date);
        selectedDay = e.date;
        momentLocale();
        console.log(moment(selectedDay).format("D MMMM YYYY"));
        view = "day";
    }

    function handleEventClick(e) {
        console.log("Event click: ", e.event.start);
        selectedDay = e.event.start;
        view = "day";
    }

    let plugins = [TimeGrid, DayGrid, ResourceTimeGrid, Interaction];
    let options = {
        view: "dayGridMonth",
        firstDay: 1,
        dateClick: (e) => handleDateClick(e),
        eventClick: (e) => handleEventClick(e),
        events: [
            // your list of events
            {
                id: 1,
                start: "2023-10-16",
                end: "2023-10-16",
                title: "7",
                editable: true,
                backgroundColor: "#B2FFD6",
                textColor: "black",
            },
            {
                id: 2,
                start: "2023-10-16",
                end: "2023-10-16",
                title: "3",
                editable: true,
                backgroundColor: "#F8A7A5",
                textColor: "black",
            },
        ],
    };

    function handleChangeView(value) {
        view = value;
    }

    function handleChangeTimesheetType(value) {
        timesheetType = value;
    }

    function handleChangeTimesheetProject(value) {
        timesheetProject = value;
    }

    function handleChangeTimesheetTime(value) {
        timesheetTime = value;
    }

    function getProgressValue(value) {
        return (value * 100) / 7;
    }
    function getMonthProgressValue(value, workDaysPerMonth) {
        return (value * 100) / workDaysPerMonth;
    }

    export let view = "calendar";
    export let timesheetType = null;
    export let timesheetProject = null;
    export let selectedDay = null;
    export let timesheetTime = null;
</script>

<Layout center={false}>
    <div class="flex flex-col items-center space-y-4 mb-10 px-10 pt-10">
        {#if view === "calendar"}
            <ViewSelector change={handleChangeView} {view} />
            <div class="container">
                <Calendar {plugins} {options} />
            </div>
        {:else if view === "stat"}
            <ViewSelector change={handleChangeView} {view} />
            <StatMonthSelector />
            <div class="container">
                <div class="flex justify-between">
                    <div>0 jour</div>
                    <div>21 jours</div>
                </div>
                <Progressbar progress={getMonthProgressValue(20, 21)} size="h-4" />
            </div>
        {:else if view === "timesheet"}
            <ViewSelector change={handleChangeView} {view} />
            <StatMonthSelector />

            <div class="container">
                <p>Timesheet</p>
            </div>
        {:else if view === "day"}
            <div class="container">
                <Button color="light" on:click={() => handleChangeView("calendar")}>
                    Retour
                </Button>
                <p class="text-center text-xl">
                    Journée du {moment(selectedDay).format("D MMMM YYYY")}
                </p>
                <div class="flex justify-between">
                    {#each progressGraduation as graduation}
                        <div>{graduation}</div>
                    {/each}
                </div>
                <Progressbar progress={getProgressValue(2)} size="h-4" />
                <p class="text-center text-xl mt-10">Ajouter un TS</p>
                <div class="flex justify-center mt-5">
                    <div class="w-48 border rounded p-1 text-center">
                        {moment(selectedDay).format("D MMMM YYYY")}
                    </div>
                </div>
                <div class="text-center mt-6">Type</div>
                <div class="flex justify-center">
                    <TimesheetTypeSelector
                        change={handleChangeTimesheetType}
                        {timesheetType}
                    />
                </div>
                <div class="text-center mt-6">Projet</div>
                <div class="flex justify-center">
                    <TimesheetProjectSelector
                        change={handleChangeTimesheetProject}
                        {timesheetProject}
                    />
                </div>
                <div class="text-center mt-6">Ticket (numéro)</div>
                <div class="flex justify-center">
                    <Input type="number" id="ticket" required class="w-48" />
                </div>
                <div class="text-center mt-6">Temps (en heure)</div>
                <div class="flex justify-center">
                    <TimesheetTimeSelector
                        change={handleChangeTimesheetTime}
                        {timesheetTime}
                    />
                </div>
                <div class="text-center mt-6">Note (optionnel)</div>
                <Textarea
                    id="note-complementaire"
                    placeholder="Note"
                    rows="4"
                    name="note"
                />
                <div class="flex justify-center mt-6">
                    <Checkbox>TS à jour sur Podio</Checkbox>
                </div>
                <div class="flex justify-center mt-6 mb-16">
                    <Button color="light">Valider</Button>
                </div>
            </div>
        {/if}
    </div>
</Layout>
