<script>
    export let change = () => {}; // no-operation function
    export let timesheetTime;
</script>

<div class="grid grid-cols-8 gap-4">
    <button on:click={() => change("1")} class="w-20 p-1 border rounded-md {timesheetTime === '1' ? 'bg-green-200' : ''}">
        1
    </button>
    <button on:click={() => change("2")} class="w-20 p-1 border rounded-md {timesheetTime === '2' ? 'bg-green-200' : ''}">
        2
    </button>
    <button on:click={() => change("3")} class="w-20 p-1 border rounded-md {timesheetTime === '3' ? 'bg-green-200' : ''}">
        3
    </button>
    <button on:click={() => change("4")} class="w-20 p-1 border rounded-md {timesheetTime === '4' ? 'bg-green-200' : ''}">
        4
    </button>
    <button on:click={() => change("5")} class="w-20 p-1 border rounded-md {timesheetTime === '5' ? 'bg-green-200' : ''}">
        5
    </button>
    <button on:click={() => change("6")} class="w-20 p-1 border rounded-md {timesheetTime === '6' ? 'bg-green-200' : ''}">
        6
    </button>
    <button on:click={() => change("7")} class="w-20 p-1 border rounded-md {timesheetTime === '7' ? 'bg-green-200' : ''}">
        7
    </button>
    <button on:click={() => change("0.5")} class="w-20 p-1 border rounded-md {timesheetTime === '0.5' ? 'bg-green-200' : ''}">
        0,5
    </button>
</div>
