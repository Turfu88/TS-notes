<script>
    import Layout from "./Components/Layout.svelte";
    import { createForm } from "svelte-forms-lib";
    import { login } from "../api/user";
    import * as yup from "yup";

    const { form, errors, handleChange, handleSubmit } = createForm({
        initialValues: {
            email: "",
            password: "",
        },
        validationSchema: yup.object().shape({
            email: yup.string().email().required(),
            password: yup.string().required(),
        }),
        onSubmit: (values) => {
            login(values).then((userIsIdentified) => {
                if (userIsIdentified) {
                    window.location.href = `/dashboard`;
                }
            });
        },
    });

    export let title;
</script>

<Layout center={true}>
    <div
        class="flex-grow flex flex-col justify-center text-center space-y-4 py-6"
    >
        <h1 class="block font-bold text-4xl">{title}</h1>
        <form
            on:submit|preventDefault={handleSubmit}
            class="flex flex-col gap-4 m-auto w-96"
        >
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
            <div>
                <button
                    type="submit"
                    class="border rounded-md bg-gray-200 p-2 px-4"
                >
                    Envoyer
                </button>
            </div>
        </form>
        <div class="border-t-2 mt-4 w-60 m-auto" />
        <p class="my-2">Inconnu au bataillon ?</p>
        <a href="/inscription" class="border rounded bg-violet-400 p-2 w-40 mx-auto"
            >Ici pour s'inscrire</a
        >
    </div>
</Layout>
