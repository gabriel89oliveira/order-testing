<template>
<app-layout>

    
    <div class="flex flex-col rounded-xl bg-white w-full md:w-2/3 p-4 shadow">

        <div class="flex flex-col items-center justify-around md:flex-row md:space-x-8 w-full text-lg font-bold border-b border-gray-300 text-center p-4">
            <div>
                GERENCIAR ARTIGOS
                <p class="font-normal text-sm">Nessa página você pode gerenciar sua lista de artigos, 
                cadastrando novos artigos, editando os artigos já cadastrados 
                ou até mesmo excluindo algum artigo da lista.</p>
            </div>
            <div>
                <app-button>
                    <a :href="route('order')"> Simular Ordem </a>
                </app-button>
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:divide-x md:space-x-4">
            
            <div class="w-full p-4">
                <article-manager />
            </div>

        </div>

    </div>

</app-layout>
</template>

<script>

    import ArticleManager from '@/Components/ArticleManager'

    export default {

        components: {
            ArticleManager,
        }
    }

</script>