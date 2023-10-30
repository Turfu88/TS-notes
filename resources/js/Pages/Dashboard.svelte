<script>
    import { onMount } from "svelte";
    import Layout from "./Components/Layout.svelte";
    import Calendar from "@event-calendar/core";
    import TimeGrid from "@event-calendar/time-grid";
    import DayGrid from "@event-calendar/day-grid";
    import ResourceTimeGrid from "@event-calendar/resource-time-grid";
    import Interaction from "@event-calendar/interaction";
    import "@event-calendar/core/index.css";
    import ViewSelector from "./Components/ViewSelector.svelte";
    import DayView from "./Components/DayView.svelte"
    import { momentLocale } from "./Components/MomentWithLocale.js";
    import {
        Button,
        Spinner,
        Progressbar
    } from "flowbite-svelte";
    import StatMonthSelector from "./Components/StatMonthSelector.svelte";
    import { getUser } from "../api/user";
    import { createEvents } from "../helpers/calendar";

    let isLoading = true;
    let user = null;
    let userTimesheets = [];
    let plugins = [TimeGrid, DayGrid, ResourceTimeGrid, Interaction];
    let options = null;

    onMount(async () => {
        const res = await getUser();
        user = res.user;
        userTimesheets = res.timesheets;
        options = {
            view: "dayGridMonth",
            firstDay: 1,
            dateClick: (e) => handleDateClick(e),
            eventClick: (e) => handleEventClick(e),
            events: createEvents(userTimesheets),
        };
        isLoading = false;
    });

    async function handleInvalidateTimesheets() {
        const res = await getUser();
        user = res.user;
        console.log(userTimesheets);
        userTimesheets = res.timesheets;
        console.log(res.timesheets);
        options = {
            view: "dayGridMonth",
            firstDay: 1,
            dateClick: (e) => handleDateClick(e),
            eventClick: (e) => handleEventClick(e),
            events: createEvents(userTimesheets),
        };
    }

    function handleDateClick(e) {
        selectedDay = e.date;
        momentLocale();
        view = "day";
    }

    function handleEventClick(e) {
        selectedDay = e.event.start;
        view = "day";
    }

    function handleChangeView(value) {
        view = value;
    }

    function getMonthProgressValue(value, workDaysPerMonth) {
        return (value * 100) / workDaysPerMonth;
    }

    export let view = "calendar";
    export let selectedDay = null;
</script>

<Layout center={isLoading}>
    {#if isLoading === true}
        <Spinner color="purple" />
    {:else}
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
                    <Progressbar
                        progress={getMonthProgressValue(20, 21)}
                        size="h-4"
                    />
                </div>
            {:else if view === "timesheet"}
                <ViewSelector change={handleChangeView} {view} />
                <StatMonthSelector />

                <div class="container">
                    <p>Timesheet</p>
                </div>
            {:else if view === "day"}
                <div class="container">
                    <Button
                        color="light"
                        on:click={() => handleChangeView("calendar")}
                    >
                        Retour
                    </Button>
                    <DayView selectedDay={selectedDay} userTimesheets={userTimesheets} on:invalidateTimesheets={handleInvalidateTimesheets} />
                </div>
            {/if}
        </div>
    {/if}
</Layout>
