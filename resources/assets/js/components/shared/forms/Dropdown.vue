<template>
    <select class="ui search dropdown" @change="updateDropdown">
        <option value="">Selecione uma opção</option>
        <option v-for="(name, id) in itens" :value="id" :key="id">{{ name }}</option>
    </select>
</template>

<script>
    export  default {
        props: ['itens', 'value'],
        watch: {
            value (val) {
                let el = $(this.$el)

                if(val === null || val === '') {
                    el.dropdown('clear')
                } else {
                    if (val instanceof Array) {
                        val = val.map(String)
                    }

                    el.dropdown('set selected', val)
                }
            }
        },
        mounted() {
            $(this.$el).dropdown()
        },
        methods: {
            updateDropdown() {
                let id_value = $(this.$el).val()

                id_value = (id_value === "" || id_value === null) ? '' : id_value
                this.$emit('input', id_value)
                this.$emit('loadCombo')
            }
        }
    }
</script>

<style scoped>
    .ui.dropdown .menu {
        z-index: 999999 !important;
    }
</style>