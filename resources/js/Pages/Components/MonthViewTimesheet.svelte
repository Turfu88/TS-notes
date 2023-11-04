<script>
    import StatMonthSelector from "./StatMonthSelector.svelte";
    import { createEventDispatcher } from "svelte";
    import { momentLocale } from "../../lib/MomentWithLocale.js";
    import {
        Table,
        TableBody,
        TableBodyCell,
        TableBodyRow,
        TableHead,
        TableHeadCell,
        Button
    } from "flowbite-svelte";
    import {
        filterTimesheetsFromSelectedMonth,
        getActiveDays,
        getTimesheetsOrderedByDay,
    } from "../../helpers/timesheetHelper";
    import moment from "moment";
    import { updateTimesheet } from "../../api/timesheet";

    const dispatch = createEventDispatcher();
    momentLocale();

    export let userTimesheets;
    export let bankHolidays;

    let monthSelected = 0;
    let selectedMonth = moment().subtract(monthSelected, "months").month() + 1;
    let timesheetsFromSelectedMonth = filterTimesheetsFromSelectedMonth(
        userTimesheets,
        selectedMonth
    );
    let activeDays = getActiveDays(
        bankHolidays,
        moment().subtract(monthSelected, "months")
    );
    let timesheetsOrderedByDay = getTimesheetsOrderedByDay(
        timesheetsFromSelectedMonth
    );

    function handleUpdatePodio(timesheet) {
        if (!timesheet.is_podio_updated) {
            timesheet.is_podio_updated = true;
            updateTimesheet(timesheet.id, timesheet).then((response) => {
                dispatch("invalidateTimesheets");
                timesheetsFromSelectedMonth = filterTimesheetsFromSelectedMonth(userTimesheets, selectedMonth);
                timesheetsOrderedByDay = getTimesheetsOrderedByDay(timesheetsFromSelectedMonth);
            });
        } else {
            timesheet.is_podio_updated = false;
            updateTimesheet(timesheet.id, timesheet).then((response) => {
                dispatch("invalidateTimesheets");
                timesheetsFromSelectedMonth = filterTimesheetsFromSelectedMonth(userTimesheets, selectedMonth);
                timesheetsOrderedByDay = getTimesheetsOrderedByDay(timesheetsFromSelectedMonth);
            });
        }
    }

    function isDayValid(timesheets) {
        const totalHoursUpdated = timesheets.reduce((currentTotal, timesheet) => {
            if (timesheet.is_podio_updated) {
                return timesheet.worktime + currentTotal;
            }
            return currentTotal;
        }, 0)

        return totalHoursUpdated === 7 ? "bg-green-200" : "bg-red-200";
    }

    function getTicketLink(timesheet) {
        return "https://www.podio.com/" + timesheet.project + "/ticket/" + timesheet.ticket
    }

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
        timesheetsOrderedByDay = getTimesheetsOrderedByDay(
            timesheetsFromSelectedMonth
        );
    }
</script>

<StatMonthSelector {monthSelected} change={handleChangeMonth} />
<div class="container">
    <div class="mt-6">
        {#each timesheetsOrderedByDay as day}
            <div class="mb-4">
                <Table shadow>
                    <TableHead defaultRow={false}>
                        <tr>
                            <TableHeadCell colspan="6" class={isDayValid(day.timesheets)}>
                                {moment(day.date).format("D MMMM YYYY")}
                            </TableHeadCell>
                        </tr>
                    </TableHead>
                    <TableBody class="divide-y">
                        {#each day.timesheets as timesheet}
                            <TableBodyRow>
                                {#if timesheet.ticket === 0}
                                    <TableBodyCell colspan="6">Absent</TableBodyCell>
                                {:else}
                                    <TableBodyCell class="w-48">{timesheet.project}</TableBodyCell>
                                    <TableBodyCell class="w-40 text-center">{timesheet.ticket}</TableBodyCell>
                                    <TableBodyCell class="w-40 text-center">{timesheet.worktime} h</TableBodyCell>
                                    <TableBodyCell class="w-40 text-center">
                                        {#if timesheet.is_podio_updated }
                                        <svg class="w-6 h-6 text-green-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        {:else}
                                        <svg class="w-6 h-6 text-red-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m13 7-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        {/if}
                                    </TableBodyCell>
                                    <TableBodyCell class="w-40 text-center">
                                        <a href={getTicketLink(timesheet)} target="_blank" >
                                            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
                                            </svg>
                                        </a>
                                    </TableBodyCell>
                                    <TableBodyCell class="w-40 px-0 text-center">
                                        {#if !timesheet.is_podio_updated }
                                            <Button color="blue" on:click={handleUpdatePodio(timesheet)} type="button">
                                                Podio à jour
                                            </Button>
                                        {:else}
                                            <div class="w-28"></div>
                                            <Button color="blue" on:click={handleUpdatePodio(timesheet)} type="button">
                                                Podio reverse
                                            </Button>
                                        {/if}
                                    </TableBodyCell>
                                {/if}
                            </TableBodyRow>
                        {/each}
                    </TableBody>
                </Table>
            </div>
        {/each}
    </div>
</div>
