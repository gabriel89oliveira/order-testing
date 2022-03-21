<template>
<app-layout>

    <div class="flex flex-col justify-center space-y-6 md:flex-row md:space-y-0 md:divide-x divide-y md:divide-y-0">
    
        <div class="flex flex-col justify-end p-4 md:w-1/4">
            <app-button class="text-xl p-4">
                <a :href="route('article')">Gerenciar Artigos</a>
            </app-button>
            <p class="mt-4 text-right px-2">Gerencie sua lista de artigos, criando novos itens, editando ou excluindo itens já cadastrados.</p>
        </div>

        <div class="flex flex-col justify-start p-4 md:w-1/4">
            <app-button class="text-xl p-4">
                <a :href="route('order')">Simular Ordens</a>
            </app-button>
            <p class="mt-4 text-left px-2">Simule uma ordem com base nos artigos cadastrados e veja quanto de desconto você terá.</p>
        </div>

    </div>

</app-layout>
</template>