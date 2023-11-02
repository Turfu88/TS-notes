<script>
    export let change = () => {}; // no-operation function
    export let monthSelected;
</script>

<div class="flex gap-0">
    <button on:click={() => change(0)} class="w-32 p-1 border rounded-l-md {0 === monthSelected ? 'bg-green-200' : ''}">
        Ce mois-ci
    </button>
    <button on:click={() => change(1)} class="w-32 p-1 border {1 === monthSelected ? 'bg-green-200' : ''}">
        Le mois dernier
    </button>
    <button on:click={() => change(2)} class="w-32 p-1 border {2 === monthSelected ? 'bg-green-200' : ''}">
        2 mois
    </button>
    <button on:click={() => change(3)} class="w-32 p-1 border {3 === monthSelected ? 'bg-green-200' : ''}">
        3 mois
    </button>
    <button on:click={() => change(4)} class="w-32 p-1 border rounded-r-md {4 === monthSelected ? 'bg-green-200' : ''}">
        4 mois
    </button>
</div>
