<template>

    <div class="absolute top-0 left-0 w-screen h-screen bg-gray-900/20 flex justify-center items-center z-40 shadow-lg" v-show="visible">

        <div class="bg-white shadow-md rounded-lg w-full md:max-w-4xl flex flex-col mx-2">
            
            <!-- Header -->
            <div class="w-full py-2 px-4 font-bold text-lg text-gray-800">
                <slot name="header" />
            </div>

            <!-- Body -->
            <div class="w-full p-6 border-y border-gray-300">
                <slot name="body" />
            </div>

            <!-- Footer -->
            <div class="flex flex-row w-full p-4 justify-end">
                <app-button class="bg-red-500" @click="closeModal()">Cancelar</app-button>
                <slot name="footer" />
            </div>

        </div>

    </div>

</template>

<script>

    export default {

        data() {
            return {
                visible: false
            }
        },

        methods: {
            openModal() {
                this.visible = true
            },

            closeModal() {
                this.visible = false
            }
        }
    }

</script>