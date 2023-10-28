<script>
    import moment from "moment";
    import TimesheetTypeSelector from "../Components/TimesheetTypeSelector.svelte";
    import TimesheetProjectSelector from "../Components/TimesheetProjectSelector.svelte";
    import TimesheetTimeSelector from "../Components/TimesheetTimeSelector.svelte";
    import TimesheetTimeOffSelector from "../Components/TimesheetTimeOffSelector.svelte";
    import {
        Input,
        Textarea,
        Checkbox,
        Button,
        Progressbar,
    } from "flowbite-svelte";
    import { createForm } from "svelte-forms-lib";
    import { createTimesheet } from "../../api/timesheet";
    import * as yup from "yup";

    const progressGraduation = ["0", "1", "2", "3", "4", "5", "6", "7"];
    export let selectedDay;
    export let timesheetType = "worked";
    export let timesheetProject = null;
    export let timesheetTime = null;

    const { form, errors, handleChange, handleSubmit } = createForm({
        initialValues: {
            note: "",
            ticket: "",
            project: "",
            worktime: "",
            worktimeOff: "",
            is_working: true,
            is_podio_updated: false,
        },
        validate: values => {
            let errors = {};
            if (values.ticket === "") {
                errors['ticket'] = "Numéro de ticket Podio ?";
            }
            if (values.worktime === "" && timesheetType === "worked") {
                errors['worktime'] = "Timesheet non défini";
            }
            if (values.project === "" && timesheetType === "worked") {
                errors['project'] = "Projet non spécifié";
            }
            if (values.worktimeOff === "" && timesheetType === "holiday") {
                errors['worktimeOff'] = "Absence non définie";
            }
            return errors;
        },
        // validationSchema: yup.object().shape({
        //     note: yup.string(),
        //     ticket: timesheetType === "worked" ? yup.string().required() : yup.string(),
        //     worktime: timesheetType === "worked" ? yup.string().required() : yup.string(),
        //     worktimeOff: timesheetType === "holiday" ? yup.string().required() : yup.string(),
        //     project: timesheetType === "worked" ? yup.string().required() : yup.string(),
        //     is_podio_updated: yup.boolean(),
        //     is_working: yup.boolean()
        // }),
        onSubmit: (values) => {
            console.log(values);
            return;
            createTimesheet(values).then((response) => {
                console.log(response);
            });
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
                value: value,
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
</script>

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
                required
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
            <Checkbox
                bind:checked={$form.is_podio_updated}
            >
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
