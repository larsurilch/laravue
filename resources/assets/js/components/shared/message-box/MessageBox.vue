<template>
    <div v-if="message">
        <div :class="`ui ${status} message box-margin`">
            <i class="close icon" v-close-message></i>
            <div class="header">
                {{ message }}
            </div>
        </div>
    </div>
</template>

<script>
    import CloseMessage from '../../../directives/CloseMessage'

    export default {
        directives: {
            'close-message': CloseMessage
        },
        props: {
            status: {
                type: String
            },
            message: {
                type: String
            }
        }
    }
</script>

<style scoped>
    .box-margin {
        margin-bottom: 15px !important;
    }
</style>