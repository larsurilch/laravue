<template>
    <div class="field" :class="[field ? 'error' : '', classe]">
        <slot></slot>
        <small class="errors_form" v-if="field">{{ field[0] }}</small>
    </div>
</template>

<script>
    export default {
        props: {
            field: {
                type: Array
            },
            classe: {
                type: String
            }
        }
    }
</script>

<style scoped>
    .errors_form {
        color: #9f3a38;
    }
</style>