<template>

    <app-button-icon @click="deleteArticle()">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
    </app-button-icon>
    
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

        methods: {
            
            deleteArticle() {

                this.$swal.fire({
                    icon: 'error',
                    title: 'Deseja mesmo deletar esse artigo?',
                    text: 'Essa ação não poderá ser revertida.',
                    showCancelButton: true,
                    cancelButtonText: 'CANCELAR',
                    cancelButtonColor: '#9333ea',
                    confirmButtonText: 'DELETAR',
                    confirmButtonColor: '#ef4444',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        
                        // Delete item from database
                        axios.delete('/api/article/' + this.article_id)
                        .then(response => {

                            // Fire success message
                            this.$swal.fire(response.data.message, '', 'success')

                            // Update article list
                            this.$emit('loadArticles')
                        })
                        .catch(exception => {
                            
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: exception.response.data.message
                            })
                            
                        })

                    }
                })

            }
            
        },

        emits: ['loadArticles']

    }

</script>