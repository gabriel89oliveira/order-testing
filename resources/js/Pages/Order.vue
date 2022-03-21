<template>
<app-layout class="md:h-screen">

    <div class="flex flex-col md:h-full rounded-xl bg-white w-full md:w-2/3 p-4 shadow md:overflow-hidden">

        <div class="w-full text-lg font-bold border-b border-gray-300 text-center p-4">
            SIMULAR UMA ORDEM
            <p class="font-normal text-sm">
            Nessa página você pode simular uma ordem, selecionando os itens
            da lista de artigos. Uma prévia do valor total é exibido,
            mostrando também o desconto quando aplicável.</p>
        </div>

        <div class="flex flex-col h-full md:flex-row md:divide-x md:space-x-4">
            
            <div class="flex flex-col h-full pb-24 w-full md:w-1/2 p-4">
                <order-articles @addArticle="addArticle($event)" />
            </div>
            
            <div class="flex flex-col h-full pb-24 w-full md:w-1/2 p-4">
                <order-preview ref="order_preview" />
            </div>

        </div>

    </div>

</app-layout>
</template>

<script>

    import OrderArticles from '@/Components/OrderArticles'
    import OrderPreview from '@/Components/OrderPreview'

    export default {

        components: {
            OrderArticles,
            OrderPreview
        },

        methods: {

            addArticle(article) {
                this.$refs.order_preview.newArticle(article)
                // console.log('Recebido com sucesso')
                // console.log(article)
            }
        }
    }

</script>