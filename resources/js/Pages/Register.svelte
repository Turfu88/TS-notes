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
                    <label for="name" class="text-start">Nom</label>
                    <input
                        name="name"
                        type="text"
                        class="border rounded-md p-2"
                    />
                </div>
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
                <div class="flex flex-col justify-start">
                    <label for="coef_low" class="text-start"
                        >Coefficient bas</label
                    >
                    <input
                        name="coef_low"
                        type="text"
                        class="border rounded-md p-2"
                    />
                </div>
                <div class="flex flex-col justify-start">
                    <label for="coef_high" class="text-start"
                        >Coefficient haut</label
                    >
                    <input
                        name="coef_high"
                        type="text"
                        class="border rounded-md p-2"
                    />
                </div>
                <div class="flex flex-col justify-start">
                    <div class="text-start">Projets</div>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-green-200 border rounded-lg p-1">
                            RRG
                        </div>
                        <div class="bg-green-200 border rounded-lg p-1">
                            Djust (Eiffage)
                        </div>
                        <div class="bg-green-200 border rounded-lg p-1">
                            Djust (Monoprix)
                        </div>
                        <div class="bg-green-200 border rounded-lg p-1">
                            Djust (Seafoodia)
                        </div>
                    </div>
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
    </div>
</Layout>
