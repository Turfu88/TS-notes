<script>
    import { Button } from "flowbite-svelte";
    import Layout from "./Components/Layout.svelte";

    export let title;
</script>

<Layout center={true}>
    <div class="flex flex-col items-center text-center space-y-4">
        <h1 class="block mt-4 font-bold text-4xl">{title}</h1>
        <p>Une mini app pour noter vos timesheets et vous aider à conserver un Podio à jour.</p>
        <div class="flex flex-col gap-4 justify-center">
            <a href="/connexion">
                <Button color="light">
                    Connexion
                </Button>
            </a>
            <a href="/inscription">
                <Button color="light">
                    Inscription
                </Button>
            </a>
        </div>
    </div>
</Layout>
