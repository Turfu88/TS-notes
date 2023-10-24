<script>
    export let change = () => {}; // no-operation function
    export let view;
</script>

<div class="flex gap-0">
    <button on:click={() => change("calendar")} class="w-28 p-1 border rounded-l-md {view === 'calendar' ? 'bg-green-200' : ''}">
        Calendrier
    </button>
    <button on:click={() => change("stat")} class="w-28 p-1 border {view === 'stat' ? 'bg-green-200' : ''}">
        Stat
    </button>
    <button on:click={() => change("timesheet")} class="w-28 p-1 border rounded-r-md {view === 'timesheet' ? 'bg-green-200' : ''}">
        TS
    </button>
</div>
