<script>
    import Layout from "./Components/Layout.svelte";
    import { Input, Button } from "flowbite-svelte";

    export let title;
</script>

<Layout center={false}>
    <div class="flex flex-col items-center text-center space-y-4">
        <h1 class="block mt-4 font-bold text-4xl">{title}</h1>
        <p>Mes coef.</p>
        <div class="flex justify-center gap-10">
            <Input type="number" id="coef_low" required class="w-32" />
            <Input type="number" id="coef_high" required class="w-32" />
        </div>
        <div class="flex justify-center mt-6 mb-16">
            <Button color="light">Modifier</Button>
        </div>
        <div class="border-t-2 mt-4 w-60 m-auto"></div>

        <div class="flex flex-col justify-start">
            <div class="text-center">Projets</div>
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
                Modifier
            </button>
        </div>
    </div>
</Layout>