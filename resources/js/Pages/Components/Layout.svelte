<script>
    export let center = false;
</script>

<div class="flex flex-col min-h-screen">
    <div
        class="bg-blue-300 shadow-md flex items-center justify-between px-2 py-4"
    >
        <div class="p-1">TS Notes</div>
        <div class="flex gap-2">
            <a href="/connexion" class="border rounded-md p-1 px-2 bg-violet-200">Connexion</a>
            <a href="/inscription" class="border rounded-md p-1 px-2 bg-violet-400">Inscription</a>
            <a href="/parametres" class="border rounded-md p-1 px-2 bg-violet-400">Paramètres</a>
            <a href="/dashboard" class="border rounded-md p-1 px-2 bg-violet-400">Dashboard</a>
            <a href="/logout" class="border rounded-md p-1 px-2 bg-violet-400">Logout</a>
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
