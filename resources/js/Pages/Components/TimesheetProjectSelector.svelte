<script>
    export let change = () => {}; // no-operation function
    export let timesheetProject;
</script>

<div class="grid grid-cols-3 gap-4">
    <button on:click={() => change("Eiffage")} class="w-28 p-1 border rounded-md {timesheetProject === 'Eiffage' ? 'bg-green-200' : ''}">
        Eiffage
    </button>
    <button on:click={() => change("Monoprix")} class="w-28 p-1 border rounded-md {timesheetProject === 'Monoprix' ? 'bg-green-200' : ''}">
        Monoprix
    </button>
    <button on:click={() => change("Socoda")} class="w-28 p-1 border rounded-md {timesheetProject === 'Socoda' ? 'bg-green-200' : ''}">
        Socoda
    </button>
    <button on:click={() => change("RRG")} class="w-28 p-1 border rounded-md {timesheetProject === 'RRG' ? 'bg-green-200' : ''}">
        RRG
    </button>
</div>
