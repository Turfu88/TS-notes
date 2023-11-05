<script>
    import { Button } from "flowbite-svelte";
    import { getUserProjects } from "../../api/user";

    export let change = () => {}; // no-operation function
    export let timesheetProject;
    export let user;

    let userProjects = getUserProjects(user);

</script>

<div class="grid grid-cols-3 gap-4">
    {#each userProjects as project}
    <Button
        on:click={() => change(project.name)}
        outline
        color="black"
        class="w-28 p-1 border rounded-md {timesheetProject === project.name
            ? 'bg-green-200'
            : ''}"
        type="button"
    >
        {project.name}
    </Button>
    {/each}
</div>
