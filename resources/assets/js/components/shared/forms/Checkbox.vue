<template>
    <div class="ui checkbox" :class="classe">
        <input :id="slugify(`${label}-${id}`)" type="checkbox" :tabindex="index" :checked="verify" :value="id" @change="update">
        <label :for="slugify(`${label}-${id}`)">{{ label }}</label>
    </div>
</template>

<script>
    export default {
        model: {
            prop: 'checked',
            event: 'change'
        },
        props: {
            value: {
                type: String
            },
            classe: {
                type: String
            },
            label: {
                required: true
            },
            id: {
                required: true
            },
            index: {
                type: Number
            },
            checked: {
                required: false
            }
        },
        computed: {
            verify () {
                if(this.checked instanceof Array) {
                    return this.checked.includes(this.value)
                }

                return this.checked === true
            }
        },
        methods: {
            slugify (text) {
                return text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '')
            },
            update(e) {
                let isChecked = e.target.checked

                if(this.checked instanceof Array) {
                    let newValue = [...this.checked]

                    if(isChecked) {
                        newValue.push(this.value)
                    } else {
                        newValue.splice(newValue.indexOf(this.value), 1)
                    }

                    this.$emit('change', newValue)
                } else {
                    this.$emit('change', isChecked ? true : false)
                }
            }
        }
    }
</script>