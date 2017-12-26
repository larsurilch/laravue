<template>
    <div class="ui center aligned grid margin-submit">
        <div v-if="submitted">
            <button class="ui loading green disabled button">Salvar</button>
        </div>
        <div v-else>
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            submitted: {
                required: true,
                type: Boolean
            }
        }
    }
</script>

<style scoped>
    .margin-submit {
        margin-top: 15px !important;
    }
</style>