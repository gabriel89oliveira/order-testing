<template>
    
    <div class="flex flex-col md:flex-row justify-center items-center py-2 mb-4">
        <div class="grow font-bold text-lg">
            <p>Lista de artigos</p>
        </div>
        <div>
            <app-button>
                <a :href="route('article')"> Gerenciar Artigos </a>
            </app-button>
        </div>
    </div>

    <div class="h-full md:overflow-y-auto md:max-h-full mt-6">

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
                            <order-article-add :article_id="article.id" @addArticle="addArticle(article)" />
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="w-full flex flex-col space-y-6 text-sm text-gray-500 text-center italic pt-8">
                
                <div>Nenhum artigo cadastrado ainda.</div>

                <div>
                    <a :href="route('article')">
                        <app-button>Gerenciar Artigos</app-button>
                    </a>
                </div>
                
            </div>

        </div>

    </div>

</template>

<script>

    import OrderArticleAdd from '@/Components/OrderArticleAdd'

    export default {

        components: {
            OrderArticleAdd,
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
            },

            addArticle(article) {
                this.$emit("addArticle", article)
            }

        },

        emits: ['addArticle']
        
    }

</script>