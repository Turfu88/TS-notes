<script>
    import Layout from "./Components/Layout.svelte";
    export let title;
</script>

<Layout center={true}>
    <div class="flex-grow flex flex-col justify-center text-center space-y-4 py-6">
        <h1 class="block font-bold text-4xl">{title}</h1>
        <div class="container">
            <form class="flex flex-col gap-4 m-auto max-w-md">
                <div class="flex flex-col justify-start">
                    <label for="email" class="text-start">Email</label>
                    <input
                        name="email"
                        type="text"
                        class="border rounded-md p-2"
                    />
                </div>
                <div class="flex flex-col justify-start">
                    <label for="password" class="text-start">Mot de passe</label
                    >
                    <input
                        name="password"
                        type="password"
                        class="border rounded-md p-2"
                    />
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
            <div class="border-t-2 mt-4 w-60 m-auto"></div>
            <p class="my-2">Inconnu au bataillon ?</p>
            <a href="/inscription" class="border rounded bg-violet-400 p-2">Ici pour s'inscrire</a>
        </div>
    </div>
</Layout>
