<script>
    import { createEventDispatcher } from "svelte";
    import moment from "moment";
    import TimesheetTypeSelector from "../Components/TimesheetTypeSelector.svelte";
    import TimesheetProjectSelector from "../Components/TimesheetProjectSelector.svelte";
    import TimesheetTimeSelector from "../Components/TimesheetTimeSelector.svelte";
    import TimesheetTimeOffSelector from "../Components/TimesheetTimeOffSelector.svelte";
    import { createForm } from "svelte-forms-lib";
    import {
        prepareValuesForRequest,
        getTimesheetsConsumption,
    } from "../../helpers/timesheetHelper";
    import {
        Input,
        Textarea,
        Checkbox,
        Button,
        Progressbar,
    } from "flowbite-svelte";
    import {
        createTimesheet,
        updateTimesheet,
        removeTimesheet,
    } from "../../api/timesheet";

    const progressGraduation = ["0", "1", "2", "3", "4", "5", "6", "7"];
    const dispatch = createEventDispatcher();
    export let selectedDay;
    export let userTimesheets;
    export let timesheetType = "worked";
    export let timesheetProject = null;
    export let timesheetTime = 0;
    export let isUpdatingMode = false;
    export let timesheetToUpdate = null;
    const formInit = {
        note: "",
        ticket: "",
        project: "",
        worktime: "",
        worktimeOff: "",
        is_working: true,
        is_podio_updated: false,
    };

    const dayFormated = moment(selectedDay).format("YYYY-MM-D");
    let timesheetsFromDay = userTimesheets.filter(
        (timesheet) => timesheet.date === dayFormated
    );
    let consumption = getTimesheetsConsumption(timesheetsFromDay);
    const { form, errors, handleChange, handleSubmit } = createForm({
        initialValues: formInit,
        validate: (values) => {
            let errors = {};
            if (values.ticket === "" && timesheetType === "worked") {
                errors["ticket"] = "Numéro de ticket Podio ?";
            }
            if (values.worktime === "" && timesheetType === "worked") {
                errors["worktime"] = "Timesheet non défini";
            }
            if (values.project === "" && timesheetType === "worked") {
                errors["project"] = "Projet non spécifié";
            }
            if (values.worktimeOff === "" && timesheetType === "holiday") {
                errors["worktimeOff"] = "Absence non définie";
            }
            return errors;
        },
        onSubmit: (values) => {
            if (true === isUpdatingMode) {
                updateTimesheet(timesheetToUpdate.id, timesheetToUpdate).then(
                    (response) => {
                        dispatch("invalidateTimesheets");
                        timesheetsFromDay = timesheetsFromDay.map((timesheet) => {
                            if (timesheet.id === timesheetToUpdate.id) {
                                return response.timesheet;
                            }
                            return timesheet;
                        });
                        consumption = getTimesheetsConsumption(timesheetsFromDay)
                    }
                );
            } else {
                const valuesPrepared = prepareValuesForRequest(
                    values,
                    selectedDay
                );
                createTimesheet(valuesPrepared).then((response) => {
                    dispatch("invalidateTimesheets");
                    timesheetsFromDay = timesheetsFromDay.concat([response.timesheet]);
                    consumption = getTimesheetsConsumption(timesheetsFromDay);
                });
            }
        },
    });

    function handleChangeTimesheetType(value) {
        timesheetType = value;
        handleChange({
            target: {
                name: "is_working",
                value: value === "worked",
            },
        });
    }

    function handleChangeTimesheetProject(value) {
        timesheetProject = value;
        handleChange({
            target: {
                name: "project",
                value: value,
            },
        });
    }

    function handleChangeTimesheetTime(value) {
        timesheetTime = value;
        handleChange({
            target: {
                name: "worktime",
                value: value.toString(),
            },
        });
    }

    function handleChangeTimesheetTimeOff(value) {
        timesheetTime = value;
        handleChange({
            target: {
                name: "worktimeOff",
                value: value,
            },
        });
    }

    function getProgressValue(value) {
        return (value * 100) / 7;
    }

    function handleChangeUpdatingMode(timesheet) {
        isUpdatingMode = true;
        timesheetToUpdate = {
            ...timesheet,
            worktime: timesheet.worktime.toString(),
        };
        form.set(timesheetToUpdate);
        timesheetTime = timesheet.worktime;
        timesheetProject = timesheet.project;
    }

    function handleCancelUpdatingMode() {
        isUpdatingMode = false;
        timesheetToUpdate = null;
        form.set(formInit);
        timesheetProject = null;
        timesheetTime = 0;
    }

    function handleDeleteTimesheet() {
        removeTimesheet(timesheetToUpdate.id).then((response) => {
            dispatch("invalidateTimesheets");
            timesheetsFromDay = timesheetsFromDay.filter((timesheet) => timesheet.id !== timesheetToUpdate.id);
            consumption = getTimesheetsConsumption(timesheetsFromDay);
            isUpdatingMode = false;
            timesheetToUpdate = null;
            form.set(formInit);
            timesheetProject = null;
            timesheetTime = 0;
        });
    }
</script>

<p class="text-center text-xl">
    Journée du {moment(selectedDay).format("D MMMM YYYY")}
</p>
<div class="flex justify-between">
    {#each progressGraduation as graduation}
        <div>{graduation}</div>
    {/each}
</div>
<div />
<Progressbar
    progress={getProgressValue(consumption.totalWorktime)}
    size="h-4"
    color={consumption.totalWorktime === 7 ? "green" : "red"}
/>
<div class="flex justify-between mt-10">
    {#each progressGraduation as graduation}
        <div>{graduation}</div>
    {/each}
</div>
<Progressbar
    progress={getProgressValue(consumption.totalWorktimeUpdatedOnPodio)}
    size="h-4"
    color={consumption.totalWorktimeUpdatedOnPodio === 7 ? "green" : "red"}
/>
<div class="mt-10">
    {#each timesheetsFromDay as timesheet}
        <div class="mt-2 text-xl flex justify-between">
            <p>
                {timesheet.project} - {timesheet.ticket} - {timesheet.worktime} - {timesheet.note}
            </p>
            {#if true === isUpdatingMode && timesheet.id === timesheetToUpdate.id}
                <button type="button" on:click={handleCancelUpdatingMode}>
                    Annuler
                </button>
            {:else}
                <button
                    type="button"
                    on:click={() => handleChangeUpdatingMode(timesheet)}
                >
                    Modifier
                </button>
            {/if}
        </div>
    {/each}
</div>

{#if 7 > consumption.totalWorktime || true === isUpdatingMode}
    <p class="text-center text-xl mt-10">
        {isUpdatingMode ? "Modifier" : "Ajouter"} un TS
    </p>
    {#if true === isUpdatingMode}
        <div class="flex justify-center">
            <Button color="red" type="button" on:click={handleDeleteTimesheet}
                >Supprimer</Button
            >
        </div>
    {/if}
    <form on:submit|preventDefault={handleSubmit}>
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
        {#if "worked" === timesheetType}
            <div class="text-center mt-6">Projet</div>
            <div class="flex justify-center">
                <TimesheetProjectSelector
                    change={handleChangeTimesheetProject}
                    {timesheetProject}
                />
            </div>
            {#if $errors.project}
                <div class="flex justify-center">
                    <small class="text-red-600">{$errors.project}</small>
                </div>
            {/if}
            <div class="text-center mt-6">Ticket (numéro)</div>
            <div class="flex justify-center">
                <Input
                    id="ticket"
                    type="number"
                    on:change={handleChange}
                    bind:value={$form.ticket}
                    class="w-48 text-center"
                />
            </div>
            {#if $errors.ticket}
                <div class="flex justify-center">
                    <small class="text-red-600">{$errors.ticket}</small>
                </div>
            {/if}

            <div class="text-center mt-6">Temps (en heure)</div>
            <div class="flex justify-center">
                <TimesheetTimeSelector
                    change={handleChangeTimesheetTime}
                    {timesheetTime}
                    currentWortime={consumption.totalWorktime}
                />
            </div>
            {#if $errors.worktime}
                <div class="flex justify-center">
                    <small class="text-red-600">{$errors.worktime}</small>
                </div>
            {/if}

            <div class="text-center mt-6">Note (optionnel)</div>
            <Textarea
                id="note-complementaire"
                placeholder="Note"
                rows="4"
                name="note"
                bind:value={$form.note}
            />
            <div class="flex justify-center mt-6">
                <Checkbox bind:checked={$form.is_podio_updated}>
                    TS à jour sur Podio
                </Checkbox>
            </div>
        {:else}
            <TimesheetTimeOffSelector
                change={handleChangeTimesheetTimeOff}
                {timesheetTime}
            />
            {#if $errors.worktimeOff}
                <div class="flex justify-center">
                    <small class="text-red-600">{$errors.worktimeOff}</small>
                </div>
            {/if}
            <div class="text-center mt-6">Note (optionnel)</div>
            <Textarea
                id="note-complementaire"
                placeholder="Note"
                rows="4"
                name="note"
                on:change={handleChange}
                bind:value={$form.note}
            />
        {/if}
        <div class="flex justify-center mt-6 mb-16">
            <Button color="light" type="submit">Valider</Button>
        </div>
    </form>
{/if}
