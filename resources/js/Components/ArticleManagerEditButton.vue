<template>

    <app-button-icon @click="$refs.articleForm.search(), $refs.modal.openModal()">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
    </app-button-icon>

    <app-modal ref="modal">

        <template v-slot:header>
            Editar artigo
        </template>

        <template v-slot:body> 
            <article-manager-form ref="articleForm" :edit="true" :article_id="article_id" @articleUpdated="articleUpdated" />
        </template>

        <template v-slot:footer> 
            <app-button @click="$refs.articleForm.update()">Salvar</app-button>
        </template>

    </app-modal>
    
</template>

<script>

    import ArticleManagerForm from '@/Components/ArticleManagerForm'

    export default {
        props: {
            article_id: {
                type: [Number, BigInt],
                default: ''
            }
        },

        components: {
            ArticleManagerForm
        },

        methods: {
            
            articleUpdated() {

                // Close modal
                this.$refs.modal.closeModal()

                // Update article list
                this.$emit('loadArticles')
            }
            
        },

        emits: ['loadArticles']

    }

</script>