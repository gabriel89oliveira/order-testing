<template>

    <app-loading v-if="loading" />

    <div v-else class="flex flex-col space-y-4">
        
        <div>
            <app-input type="text" v-model="form.article_name" label="Nome do artigo" />
        </div>

        <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0 w-full">
            <div class="grow">
                <app-input type="text" v-model="form.article_code" label="Código" />
            </div>

            <div class="grow">
                <app-input type="text" v-model="form.article_price" label="Preço unitário" />
            </div>
        </div>

    </div>

</template>

<script>

    export default {

        props: {
            edit: {
                type: Boolean,
                default: false
            },
            article_id: {
                type: [Number, BigInt, String],
                default: ''
            }
        },

        data() {
            return {
                loading: false,
                error: false,
                form: {
                    article_name: '',
                    article_code: '',
                    article_price: '',
                }
            }
        },

        methods: {

            // Clear form data
            clear() {

                this.form.article_name = ''
                this.form.article_code = ''
                this.form.article_price = ''

            },

            // Search for article data
            search() {
                
                this.loading = true

                axios.get('/api/article/' + this.article_id)
                .then(response => {
                    this.form.article_name = response.data.article.name
                    this.form.article_code = response.data.article.code
                    this.form.article_price = response.data.article.unit_price
                    this.loading = false
                })
                .catch(exception => {

                    this.loading = false

                    // Clear form
                    this.form.article_name = ''
                    this.form.article_code = ''
                    this.form.article_price = ''

                    // Fire error alert
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Não foi possivel carregar esse artigo!'
                    })
                })

            },

            // Submit form to create a new article
            create() {

                axios.post('/api/article', this.form)
                .then(response => {
                    this.$emit('articleCreated')
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Yeeeep!',
                        text: response.data.message
                    })
                })
                .catch(exception => {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: exception.response.data.message
                    })
                })

            },

            // Submit form to update an article
            update() {

                axios.put('/api/article/' + this.article_id, this.form)
                .then(response => {
                    this.$emit('articleUpdated')
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Yeeeep!',
                        text: response.data.message
                    })
                })
                .catch(exception => {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: exception.response.data.message
                    })
                })

            }
        },

        emits: ['articleCreated', 'articleUpdated']
    }

</script>