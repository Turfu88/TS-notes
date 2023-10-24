<script>
    export let change = () => {}; // no-operation function
    export let monthSelected = 'current';
</script>

<div class="flex gap-0">
    <button on:click={() => change("calendar")} class="w-32 p-1 border rounded-l-md {monthSelected === 'current' ? 'bg-green-200' : ''}">
        Ce mois-ci
    </button>
    <button on:click={() => change("stat")} class="w-32 p-1 border {monthSelected === '1monthAgo' ? 'bg-green-200' : ''}">
        Le mois dernier
    </button>
    <button on:click={() => change("timesheet")} class="w-32 p-1 border {monthSelected === '2monthsAgo' ? 'bg-green-200' : ''}">
        2 mois
    </button>
    <button on:click={() => change("timesheet")} class="w-32 p-1 border {monthSelected === '3monthsAgo' ? 'bg-green-200' : ''}">
        3 mois
    </button>
    <button on:click={() => change("timesheet")} class="w-32 p-1 border rounded-r-md {monthSelected === '4monthAgo' ? 'bg-green-200' : ''}">
        4 mois
    </button>
</div>
