<script>
    export let change = () => {}; // no-operation function
    export let timesheetTime;
</script>

<div class="text-center mt-6">Absence</div>
<div class="flex justify-center">
    <div class="grid grid-cols-2 gap-4">
        <button
            on:click={() => change("3.5")}
            class="w-48 p-1 border rounded-md {timesheetTime === '3.5' ? 'bg-green-200' : ''}"
            type="button"
        >
            3.5 (demi-journée)
        </button>
        <button
            on:click={() => change("7")}
            class="w-48 p-1 border rounded-md {timesheetTime === '7' ? 'bg-green-200' : ''}"
            type="button"
        >
            7 (journée complète)
        </button>
    </div>
</div>
