<template>
    <div class="ui calendar">
        <div class="ui input left icon">
            <i class="calendar icon"></i>
            <input type="text" :placeholder="placeholder" v-mask="'##/##/####'" :value="value" @input="$emit('input', $event.target.value)" autocomplete="off" />
        </div>
    </div>
</template>

<script>
    import { VueMaskDirective } from 'v-mask'

    export default {
        props: ['placeholder', 'value'],
        directives: {
            mask: VueMaskDirective
        },
        mounted() {
            let formatDate = this.format

            $(this.$el).calendar({
                type: 'date',
                today: true,
                monthFirst: false,
                formatter: {
                    date: function (date, settings) {
                        return formatDate(date)
                    }
                },
                text: {
                    days: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
                    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    today: 'Hoje',
                    now: 'Agora',
                    am: 'AM',
                    pm: 'PM',
                },
                onHide: (date) => {
                    let format = $(date).val()

                    this.$emit('input', format)
                    this.$emit('change')
                }
            })
        },
        methods: {
            format (date) {
                if (!date) return ''
                return date.toLocaleDateString("pt-BR")
            }
        }
    }
</script>