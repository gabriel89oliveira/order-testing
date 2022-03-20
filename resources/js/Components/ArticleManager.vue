<template>
    
    <div class="flex flex-col md:flex-row justify-center items-center py-2 mb-4">
        <div class="grow font-bold text-lg">
            <p>Lista de artigos</p>
        </div>
        <div>
            <article-manager-create-button @loadArticles="loadArticles" />
        </div>
    </div>

    <div>

        <app-loading v-if="loading" />
        <div v-else>
            <div v-if="articles.length > 0" class="table w-full">
                <div class="table-header-group">
                    <div class="table-row py-2">
                        <div class="table-cell text-left font-bold">Código</div>
                        <div class="table-cell text-left font-bold">Nome</div>
                        <div class="table-cell text-left font-bold">Preço</div>
                        <div class="table-cell text-center font-bold">Gerenciar</div>
                    </div>
                </div>
                <div class="table-row-group">
                    <div class="table-row" v-for="article in articles" :key="article.id">
                        <div class="table-cell text-left py-1 border-t border-gray-300">{{ article.code }}</div>
                        <div class="table-cell text-left py-1 border-t border-gray-300">{{ article.name }}</div>
                        <div class="table-cell text-left py-1 border-t border-gray-300">{{ article.unit_price }}</div>
                        <div class="table-cell text-center py-1 border-t border-gray-300">
                            <article-manager-edit-button :article_id="article.id" @loadArticles="loadArticles" />
                            <article-manager-delete-button :article_id="article.id" @loadArticles="loadArticles" />
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="w-full text-sm text-gray-500 text-center italic pt-8">
                Nenhum artigo cadastrado ainda.
            </div>

        </div>

    </div>

</template>

<script>

    import ArticleManagerCreateButton from '@/Components/ArticleManagerCreateButton'
    import ArticleManagerEditButton from '@/Components/ArticleManagerEditButton'
    import ArticleManagerDeleteButton from '@/Components/ArticleManagerDeleteButton'

    export default {

        components: {
            ArticleManagerCreateButton,
            ArticleManagerEditButton,
            ArticleManagerDeleteButton
        },

        data() {
            return {
                articles: [],
                loading: false
            }
        },

        created() {
            this.loadArticles()
        },

        methods: {

            loadArticles() {

                this.loading = true

                axios.get('/api/article')
                .then(response => {
                    this.articles = response.data.articles
                    this.loading = false
                })
                .catch(exception => {
                    this.loading = false
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Não foi possivel carregar os artigos!'
                    })
                })
            }

        }
        
    }

</script>