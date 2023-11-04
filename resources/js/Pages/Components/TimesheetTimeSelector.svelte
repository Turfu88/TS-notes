<script>
    import {Button} from "flowbite-svelte";
    export let change = () => {}; // no-operation function
    export let timesheetTime;
    export let currentWortime;

    let extra = 0;

    function updateTime(time) {
        time = time + extra;
        change(time.toString());
    }

    function toggleExtraTime() {
        if (extra === 0.5) {
            extra = 0;
            updateTime(Math.floor(parseFloat(timesheetTime)));
        } else {
            extra = 0.5;
            updateTime(parseFloat(timesheetTime));
        }
    }
</script>

<div class="grid grid-cols-8 gap-4">
    <Button
        on:click={() => updateTime(1)}
        disabled={currentWortime + extra + 1 > 7}
        color="light"
        class="w-20 p-1 border rounded-md {timesheetTime === '1' || timesheetTime === '1.5' ? 'bg-green-200' : ''}"
        type="button"
    >
        1
    </Button>
    <Button
        on:click={() => updateTime(2)}
        disabled={currentWortime + extra + 2 > 7}
        color="light"
        class="w-20 p-1 border rounded-md {timesheetTime === '2' || timesheetTime === '2.5' ? 'bg-green-200' : ''}"
        type="button"
    >
        2
    </Button>
    <Button
        on:click={() => updateTime(3)}
        disabled={currentWortime + extra + 3 > 7}
        color="light"
        class="w-20 p-1 border rounded-md {timesheetTime === '3' || timesheetTime === '3.5' ? 'bg-green-200' : ''}"
        type="button"
    >
        3
    </Button>
    <Button
        on:click={() => updateTime(4)}
        disabled={currentWortime + extra + 4 > 7}
        color="light"
        class="w-20 p-1 border rounded-md {timesheetTime === '4' || timesheetTime === '4.5' ? 'bg-green-200' : ''}"
        type="button"
    >
        4
    </Button>
    <Button
        on:click={() => updateTime(5)}
        disabled={currentWortime + extra + 5 > 7}
        color="light"
        class="w-20 p-1 border rounded-md {timesheetTime === '5' || timesheetTime === '5.5' ? 'bg-green-200' : ''}"
        type="button"
    >
        5
    </Button>
    <Button
        on:click={() => updateTime(6)}
        disabled={currentWortime + extra + 6 > 7}
        color="light"
        class="w-20 p-1 border rounded-md {timesheetTime === '6' || timesheetTime === '6.5' ? 'bg-green-200' : ''}"
        type="button"
    >
        6
    </Button>
    <Button
        on:click={() => updateTime(7)}
        disabled={currentWortime + extra + 7 > 7}
        color="light"
        class="w-20 p-1 border rounded-md {timesheetTime === '7' || timesheetTime === '7.5' ? 'bg-green-200' : ''}"
        type="button"
    >
        7
    </Button>
    <Button
        on:click={toggleExtraTime}
        disabled={currentWortime + parseFloat(timesheetTime) +  0.5 > 7}
        color="light"
        class="w-20 p-1 border rounded-md {extra === 0.5 ? 'bg-green-200' : ''}"
        type="button"
    >
        0,5
    </Button>
</div>
