<script>
    import StatMonthSelector from "./StatMonthSelector.svelte";
    import { Progressbar } from "flowbite-svelte";
    import {
        filterTimesheetsFromSelectedMonth,
        formatDays,
        getActiveDays,
        getDaysUpdated,
        getProjectsWorkedOn,
        getTotalHoursPerTicket,
        getTotalWorkedByProject,
    } from "../../helpers/timesheetHelper";
    import moment from "moment";

    let monthSelected = 0;
    let selectedMonth = moment().subtract(monthSelected, "months").month() + 1;
    export let userTimesheets;
    export let bankHolidays;

    let timesheetsFromSelectedMonth = filterTimesheetsFromSelectedMonth(
        userTimesheets,
        selectedMonth
    );
    let activeDays = getActiveDays(
        bankHolidays,
        moment().subtract(monthSelected, "months")
    );
    let daysUpdated = getDaysUpdated(timesheetsFromSelectedMonth);
    let projectsWorkedOn = getProjectsWorkedOn(timesheetsFromSelectedMonth);
    let totalHoursPerTicket = getTotalHoursPerTicket(timesheetsFromSelectedMonth);
 
    function handleChangeMonth(month) {
        monthSelected = month;
        selectedMonth = moment().subtract(monthSelected, "months").month() + 1;
        timesheetsFromSelectedMonth = filterTimesheetsFromSelectedMonth(
            userTimesheets,
            selectedMonth
        );
        activeDays = getActiveDays(
            bankHolidays,
            moment().subtract(monthSelected, "months")
        );
        daysUpdated = getDaysUpdated(timesheetsFromSelectedMonth);
        projectsWorkedOn = getProjectsWorkedOn(timesheetsFromSelectedMonth);
    }

    function getMonthProgressValue(value, workDaysPerMonth) {
        return (value * 100) / workDaysPerMonth;
    }
</script>

<StatMonthSelector {monthSelected} change={handleChangeMonth} />
<div class="container">
    <div class="flex justify-between">
        <div>0 jour</div>
        <div>{activeDays} jours</div>
    </div>
    <Progressbar
        progress={getMonthProgressValue(daysUpdated, activeDays)}
        size="h-4"
    />
    <div class="relative" style="{`left: calc(${getMonthProgressValue(daysUpdated, activeDays)}% - 30px)`}">
        {formatDays(daysUpdated)}
    </div>
    <div class="mt-6">
        {#each projectsWorkedOn as project}
            {#if project !== ""}
                <div class="my-4">
                    {project} : {getTotalWorkedByProject(
                        project,
                        timesheetsFromSelectedMonth
                    )}
                </div>
                {#each totalHoursPerTicket as ticket}
                    {#if ticket.ticket !== 0 && ticket.project === project}
                        <div class="flex gap-10">
                            <p class="w-20 text-center">Ticket: {ticket.ticket}</p> 
                            <p class="w-12 text-center">{ticket.worktime}h </p>
                            <p class="text-center">{formatDays(ticket.worktime / 7)}</p>
                        </div>
                    {/if}
                {/each}
            {/if}
        {/each}
        {#if projectsWorkedOn.includes("")}
            <div class="border-t-2 my-2" />
            <div>
                Absence : {getTotalWorkedByProject(
                    "",
                    timesheetsFromSelectedMonth
                )}
            </div>
        {/if}
    </div>
</div>
