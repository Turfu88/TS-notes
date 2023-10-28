<script>
    export let change = () => {}; // no-operation function
    export let timesheetType;
</script>

<div class="flex gap-0">
    <button on:click={() => change("worked")} class="w-28 p-1 border rounded-l-md {timesheetType === 'worked' ? 'bg-red-200' : ''}" type="button">
        Travaillé
    </button>
    <button on:click={() => change("holiday")} class="w-28 p-1 border rounded-r-md {timesheetType === 'holiday' ? 'bg-green-200' : ''}" type="button">
        Absence
    </button>
</div>
