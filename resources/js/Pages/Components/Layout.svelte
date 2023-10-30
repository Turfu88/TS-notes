<script>
    import { isLogedIn, logout } from "../../api/user";

    export let center = false;
    const userIsLogedIn = isLogedIn();

    function handleClickLogout() {
        logout();
        window.location.href = '/logout';
    }
</script>

<div class="flex flex-col min-h-screen">
    <div
        class="bg-blue-300 shadow-md flex items-center justify-between px-2 py-4"
    >
        <div class="p-1">TS Notes</div>
        <div class="flex gap-2">
            {#if userIsLogedIn}
                <a
                    href="/dashboard"
                    class="border rounded-md p-1 px-2 bg-violet-400"
                >
                    Dashboard
                </a>
                <a
                    href="/parametres"
                    class="border rounded-md p-1 px-2 bg-violet-400"
                >
                    Paramètres
                </a>
                <button
                    on:click={handleClickLogout}
                    class="border rounded-md p-1 px-2 bg-violet-400"
                >
                    Logout
                </button>
            {:else}
                <a
                    href="/connexion"
                    class="border rounded-md p-1 px-2 bg-violet-200"
                >
                    Connexion
                </a>
                <a
                    href="/inscription"
                    class="border rounded-md p-1 px-2 bg-violet-400"
                >
                    Inscription
                </a>
            {/if}
        </div>
    </div>
    <div class="flex-grow {center ? 'flex items-center justify-center' : ''}">
        <slot />
    </div>
    <div class="bg-blue-100 flex items-center justify-center py-2">
        <div class="text-sm">TS Notes - 2023</div>
    </div>
</div>

<style>
</style>
