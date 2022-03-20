<template>

    <div class="flex flex-col md:flex-row justify-center items-center py-2 mb-4">
        <div class="grow font-bold text-lg">
            <p>Resumo da ordem</p>
        </div>
    </div>

    <div v-if="articles.length > 0" class="flex flex-row items-center justify-center mt-2">

        <div class="flex flex-col space-y-1 text-right border-r border-gray-300 pr-4 w-1/2">

            <div class="font-semibold">
                Subtotal = R$ {{ parseFloat(total_amount_without_discount).toFixed(2) }}
            </div>
            <div class="font-normal italic">
                Desconto = R$ {{ parseFloat(total_amount_with_discount - total_amount_without_discount).toFixed(2) }}
            </div>
            <div class="font-bold">
                Total = R$ {{ parseFloat(total_amount_with_discount).toFixed(2) }}
            </div>

        </div>

        <div class="flex flex-row justify-start pl-4 w-1/2">
            <div>
                <app-button @click="submitOrder()">Enviar ordem</app-button>
            </div>
        </div>

    </div>

    <div v-if="articles.length > 0" class="h-full overflow-y-auto max-h-full mt-6">
        <div class="table w-full">
            <div class="table-header-group">
                <div class="table-row py-2">
                    <div class="table-cell text-left font-bold">Código</div>
                    <div class="table-cell text-left font-bold">Nome</div>
                    <div class="table-cell text-left font-bold">Preço</div>
                    <div class="table-cell text-center font-bold">Gerenciar</div>
                </div>
            </div>
            <div class="table-row-group">
                <div class="table-row" v-for="article, index in articles" :key="article.id">
                    <div class="table-cell text-left py-1 border-t border-gray-300">{{ article.code }}</div>
                    <div class="table-cell text-left py-1 border-t border-gray-300">{{ article.name }}</div>
                    <div class="table-cell text-left py-1 border-t border-gray-300">{{ article.unit_price }}</div>
                    <div class="table-cell text-center py-1 border-t border-gray-300">
                        <order-article-remove @click="removeArticle(index)" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-else class="w-full flex flex-col space-y-6 text-sm text-gray-500 text-center italic pt-8">
        <div>Nenhum artigo adicionado na ordem ainda.</div>
    </div>

</template>

<script>

    import OrderArticleRemove from '@/Components/OrderArticleRemove'

    export default {

        components: {
            OrderArticleRemove
        },

        data() {
            return {
                articles: [],
                total_amount_without_discount: 0,
                total_amount_with_discount: 0,
            }
        },

        methods: {
            
            // Add a new article to the list
            newArticle(article) {
                this.articles.push(article)
                this.calculateTotal()
            },

            // Remove an article from the list
            removeArticle(index) {
                this.articles.splice(index, 1)
                this.calculateTotal()
            },

            submitOrder() {
                
                let form = {
                    items: this.articles
                }

                axios.post('api/order', form)
                .then(response => {

                    // Clear articles array
                    this.articles = []

                    // Update server 1
                    let form = {
                        OrderId: response.data.order.id,
                        OrderCode: response.data.order.code,
                        OrderDate: response.data.order.date,
                        TotalAmountWithoutDiscount: response.data.order.total_amount_without_discount,
                        TotalAmountWithDiscount: response.data.order.total_amount_with_discount
                    }
                    axios.post('https://localhost:9001/order', form)

                    // Update server 2
                    form = {
                        id: response.data.order.id,
                        code: response.data.order.code,
                        date: response.data.order.date,
                        total: response.data.order.total_amount_without_discount,
                        discount: response.data.order.total_amount_with_discount - response.data.order.total_amount_without_discount
                    }
                    axios.post('https://localhost:9002/v1/order', form)

                    // Update server 3
                    form = {
                        id: response.data.order.id,
                        code: response.data.order.code,
                        date: response.data.order.date,
                        totalAmount: response.data.order.total_amount_without_discount,
                        totalAmountWithDiscount: response.data.order.total_amount_with_discount
                    }
                    axios.post('https://localhost:9003/web_api/order', form)

                    this.$swal.fire({
                        icon: 'success',
                        title: 'Yeeeep!',
                        text: 'Ordem enviada com sucesso!'
                    })

                })
                .catch(exception => {

                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Não foi possivel registrar a ordem'
                    })

                })

            },

            // Calculate final price with discount
            calculateTotal() {

                // Sum total amout of order
                this.total_amount_without_discount = this.totalAmount(this.articles)
                this.total_amount_with_discount = this.total_amount_without_discount

                // Array of unique items
                const unique_items = this.listUniqueItems(this.articles)

                // Check if there is any product with more than 5 items and less than 9 items
                let discount_check = this.checkDiscount(this.articles, unique_items)

                // Apply discount if applicable
                if(discount_check == true && this.total_amount_without_discount >= 500) {
                    this.total_amount_with_discount *= 0.85
                }

            },

            // Sum value of all items
            totalAmount(items) {
                
                let total = 0
                items.forEach(function (item) {
                    total += item.unit_price_value;
                });

                return total

            },

            // List unique items in order
            listUniqueItems(items) {
                return [...new Set(items.map(item => item.code))]
            },

            // Check discount rule
            checkDiscount(articles, unique_items) {
                
                let discount = false

                // Loop through list of unique items in order 
                unique_items.forEach(function (item) {

                    let total = 0

                    // Count number of times this item occurs in order
                    articles.forEach(function (article) {
                        if(article.code == item){
                            total += 1
                        }
                    })

                    // Apply rule
                    if (total >= 5 && total <= 9){
                        discount = true
                    }

                })

                return discount

            }

        }

    }

</script>