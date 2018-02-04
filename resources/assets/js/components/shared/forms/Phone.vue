<template>
    <input type="text" :name="name" :value="value" v-mask="maskPhone" @input="updateMask" autocomplete="off"/>
</template>

<script>
    import { VueMaskDirective } from 'v-mask'

    export default {
        directives: {
            mask: VueMaskDirective
        },
        props: ['name', 'value'],
        data() {
          return {
              maskPhone: '(##) ####-####?#'
          }
        },
        methods: {
            updateMask (e) {
                let phone_value = $(e.target).val()

                if(phone_value.length > 14) {
                    this.maskPhone = '(##) #####-####'
                } else {
                    this.maskPhone = '(##) ####-####?#'
                }

                this.$emit('input', phone_value)
            }
        }
    }
</script>