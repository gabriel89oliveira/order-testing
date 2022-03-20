<template>
<app-layout>

    <div class="flex flex-col space-y-6 md:flex-row md:space-x-6 md:space-y-0">
    
        <app-button class="text-xl p-4">
            <a :href="route('article')">Gerenciar Artigos</a>
        </app-button>

        <app-button class="text-xl p-4">
            <a :href="route('order')">Simular Ordens</a>
        </app-button>

    </div>

</app-layout>
</template>