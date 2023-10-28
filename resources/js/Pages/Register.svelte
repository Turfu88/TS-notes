<script>
    import Layout from "./Components/Layout.svelte";
    import { createForm } from "svelte-forms-lib";
    import { createUser } from "../api/user";
    import * as yup from "yup";

    export let title;
    let projects = [];

    const { form, errors, handleChange, handleSubmit } = createForm({
        initialValues: {
            name: "",
            email: "",
            password: "",
            coef_low: "",
            coef_high: "",
            projects: []
        },
        validationSchema: yup.object().shape({
            name: yup.string().required(),
            email: yup.string().email().required(),
            password: yup.string().required(),
            coef_low: yup.string().required(),
            coef_high: yup.string().required(),
            projects: yup.array().min(1)
        }),
        onSubmit: (values) => {
            console.log(values);
            createUser(values).then((userIsIdentified) => {
                console.log(userIsIdentified);
                if (userIsIdentified) {
                    window.location.href = `/dashboard`;
                }
            });
        },
    });

    function toggleProject(value) {
        if (projects.includes(value)) {
            const newValue = projects.filter((project) => project !== value);
            projects = [...newValue];
        } else {
            projects = [...projects, value];
        }
        handleChange({
            target: {
                name: "projects",
                value: projects
            }
        });
    }
</script>

<Layout center={true}>
    <div
        class="flex-grow flex flex-col justify-center text-center space-y-4 py-6"
    >
        <h1 class="block font-bold text-4xl">{title}</h1>
        <form
            on:submit|preventDefault={handleSubmit}
            class="flex flex-col gap-4 m-auto max-w-md"
        >
            <div class="flex flex-col justify-start">
                <label for="name" class="text-start">Nom</label>
                <input
                    on:change={handleChange}
                    bind:value={$form.name}
                    name="name"
                    type="text"
                    class="border rounded-md p-2"
                />
                {#if $errors.name}
                    <small>{$errors.name}</small>
                {/if}
            </div>
            <div class="flex flex-col justify-start">
                <label for="email" class="text-start">Email</label>
                <input
                    on:change={handleChange}
                    bind:value={$form.email}
                    name="email"
                    type="text"
                    class="border rounded-md p-2"
                />
                {#if $errors.email}
                    <small>{$errors.email}</small>
                {/if}
            </div>
            <div class="flex flex-col justify-start">
                <label for="password" class="text-start">Mot de passe</label
                >
                <input
                    on:change={handleChange}
                    bind:value={$form.password}
                    name="password"
                    type="password"
                    class="border rounded-md p-2"
                />
                {#if $errors.password}
                    <small>{$errors.password}</small>
                {/if}
            </div>
            <div class="flex flex-col justify-start">
                <label for="coef_low" class="text-start"
                    >Coefficient bas</label
                >
                <input
                    on:change={handleChange}
                    bind:value={$form.coef_low}
                    name="coef_low"
                    type="text"
                    class="border rounded-md p-2"
                />
                {#if $errors.coef_low}
                    <small>{$errors.coef_low}</small>
                {/if}
            </div>
            <div class="flex flex-col justify-start">
                <label for="coef_high" class="text-start">
                    Coefficient haut
                </label>
                <input
                    on:change={handleChange}
                    bind:value={$form.coef_high}
                    name="coef_high"
                    type="text"
                    class="border rounded-md p-2"
                />
                {#if $errors.coef_high}
                    <small>{$errors.coef_high}</small>
                {/if}
            </div>
            <div class="flex flex-col justify-start">
                <div class="text-start">Projets</div>
                <div class="grid grid-cols-3 gap-3">
                    <button
                        class="border rounded-lg p-1 {projects.includes(
                            'RRG'
                        )
                            ? 'bg-green-200 border-green-600'
                            : ''}"
                        on:click={() => toggleProject("RRG")}
                        type="button"
                    >
                        RRG
                    </button>
                    <button
                        class="border rounded-lg p-1 {projects.includes(
                            'Eiffage'
                        )
                            ? 'bg-green-200 border-green-600'
                            : ''}"
                        on:click={() => toggleProject("Eiffage")}
                        type="button"
                    >
                        Djust (Eiffage)
                    </button>
                    <button
                        class="border rounded-lg p-1 {projects.includes(
                            'Monoprix'
                        )
                            ? 'bg-green-200 border-green-600'
                            : ''}"
                        on:click={() => toggleProject("Monoprix")}
                        type="button"
                    >
                        Djust (Monoprix)
                    </button>
                    <button
                        class="border rounded-lg p-1 {projects.includes(
                            'Seafoodia'
                        )
                            ? 'bg-green-200 border-green-600'
                            : ''}"
                        on:click={() => toggleProject("Seafoodia")}
                        type="button"
                    >
                        Djust (Seafoodia)
                    </button>
                </div>
                {#if $errors.projects}
                    <small>{$errors.projects}</small>
                {/if}
            </div>
            <div>
                <button
                    type="submit"
                    class="border rounded-md bg-gray-200 p-2 px-4"
                >
                    Envoyer
                </button>
            </div>
        </form>
    </div>
</Layout>
