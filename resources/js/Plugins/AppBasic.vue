<script>

    import AppLayout from '@/Components/AppLayout'
    import AppButton from '@/Components/AppButton'
    import AppButtonIcon from '@/Components/AppButtonIcon'
    import AppModal from '@/Components/AppModal'
    import AppInput from '@/Components/AppInput'
    import AppLoading from '@/Components/AppLoading'

    export default {

        install: (app, options) => {
            app.component('AppLayout', AppLayout)
            app.component('AppButton', AppButton)
            app.component('AppButtonIcon', AppButtonIcon)
            app.component('AppModal', AppModal)
            app.component('AppInput', AppInput)
            app.component('AppLoading', AppLoading)
        }

    }

</script>