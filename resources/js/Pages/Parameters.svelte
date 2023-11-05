<script>
    import { onMount } from "svelte";
    import { createForm } from "svelte-forms-lib";
    import * as yup from "yup";
    import Layout from "./Components/Layout.svelte";
    import { Input, Button, Spinner } from "flowbite-svelte";
    import { getUserInfo, updateUser } from "../api/user";
    import { getProjects } from "../api/project";

    export let title;

    let user;
    let isLoading = true;
    let userProjects = null;
    const allProjects = getProjects();   

    onMount(async () => {
        const res = await getUserInfo();
        user = res.user;
        if (!user) {
            window.location.href = `/connexion`;
        }
        form.set(user);
        userProjects = JSON.parse(user.projects);
        isLoading = false;
    });

    function toggleProject(value) {
        if (userProjects.includes(value)) {
            const newValue = userProjects.filter((project) => project !== value);
            userProjects = [...newValue];
        } else {
            userProjects = [...userProjects, value];
        }
    }

    const { form, errors, handleChange, handleSubmit } = createForm({
        initialValues: {
            coef_low: "",
            coef_high: "",
        },
        validationSchema: yup.object().shape({
            coef_low: yup.number().required().positive().lessThan(5),
            coef_high: yup.number().required().positive().lessThan(5)
        }),
        onSubmit: (values) => {
            updateUser(values);
        },
    });
</script>

<Layout center={isLoading}>
    {#if isLoading === true}
        <Spinner color="purple" />
    {:else}
        <div class="flex flex-col items-center text-center space-y-4">
            <h1 class="block mt-4 font-bold text-4xl">{title}</h1>
            <p>Mes coef.</p>
            <form
                on:submit|preventDefault={handleSubmit}
                class="flex flex-col gap-4 m-auto max-w-md"
            >
                <div class="flex justify-center gap-10">
                    {#if $errors.coef_low}
                        <small>{$errors.coef_low}</small>
                    {/if}
                    {#if $errors.coef_high}
                        <small>{$errors.coef_high}</small>
                    {/if}
                    <Input
                        id="coef_low"
                        on:change={handleChange}
                        bind:value={$form.coef_low}
                        type="number"
                        step="0.1"
                        class="w-32"                        
                    />
                    <Input
                        id="coef_high"
                        on:change={handleChange}
                        bind:value={$form.coef_high}
                        type="number"
                        step="0.1"
                        class="w-32"
                    />
                </div>
                <div class="flex justify-center mt-6 mb-16">
                    <Button
                        color="light"
                        type="submit"
                        class="border rounded-md bg-gray-200 p-2 px-4"
                    >
                        Modifier
                    </Button>
                </div>
            </form>
            <div class="border-t-2 mt-4 w-60 m-auto" />

            <div class="flex flex-col justify-start">
                <div class="text-center">Projets</div>
                <div class="grid grid-cols-3 gap-3">
                    {#each allProjects as project}
                        <Button
                            outlined
                            on:click={() => toggleProject(project.id)}
                            color="black"
                            class="w-28 p-1 border rounded-lg {userProjects.includes(project.id)
                                ? 'bg-green-200'
                                : ''}"
                        >
                            {project.name}
                        </Button>
                    {/each}
                </div>
            </div>
            <div>
                <Button
                    on:click={() => updateUser({...user, projects: userProjects})}
                    outline
                    color="light"
                    class="border rounded-md bg-gray-200 p-2 px-4"
                    type="button"
                >
                    Modifier
                </Button>
            </div>
        </div>
    {/if}
</Layout>
