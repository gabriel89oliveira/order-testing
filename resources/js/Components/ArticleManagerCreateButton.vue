<template>

    <app-button @click="$refs.articleForm.clear(), $refs.modal.openModal()">Cadastrar um novo artigo</app-button>

    <app-modal ref="modal">

        <template v-slot:header>
            Cadastrar um novo artigo
        </template>

        <template v-slot:body> 
            <article-manager-form ref="articleForm" :edit="false" @articleCreated="articleCreated" />
        </template>

        <template v-slot:footer> 
            <app-button @click="$refs.articleForm.create()">Enviar</app-button>
        </template>

    </app-modal>
    
</template>

<script>

    import ArticleManagerForm from '@/Components/ArticleManagerForm'

    export default {
        components: {
            ArticleManagerForm
        },

        data() {
            return {
                showModal: false
            }
        },

        methods: {

            articleCreated() {

                // Close modal
                this.$refs.modal.closeModal()

                // Update article list
                this.$emit('loadArticles')
            }

        },

        emits: ['loadArticles']
    }

</script>