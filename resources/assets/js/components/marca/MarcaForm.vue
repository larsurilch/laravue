<template>
    <div>
        <heading icone="registered" titulo="Marca" :subtitulo="addSubtitle" url="/marcas"
                 label="Voltar" color="violet" :status="status" :message="message"></heading>
        <form class="ui form" @submit.prevent="save">
            <form-error classe="required" :field="errors.descricao">
                <label>Descrição</label>
                <input type="text" name="descricao" v-model="marca.descricao" autocomplete="off" v-focus/>
            </form-error>
            <submit-button :submitted="submitted">
                <input type="submit" class="ui green button" v-if="marca.descricao" value="Salvar"/>
            </submit-button>
        </form>
    </div>
</template>

<script>
    import Heading from '../shared/header/Heading.vue'
    import FormError from '../shared/form-error/FormError.vue'
    import SubmitButton from '../shared/submit-button/SubmitButton.vue'
    import Focus from '../../directives/Focus'
    import Marca from '../../domain/marca/Marca'
    import GlobalService from '../../domain/GlobalService'

    export default {
        data () {
            return {
                marca: new Marca(),
                id: this.$route.params.id,
                message: null,
                status: null,
                submitted: false,
                success: false,
                errors: []
            }
        },
        created () {
            this.service = new GlobalService(this.$router)

            if(this.id) {
                this.show()
            }
        },
        directives: {
            focus: Focus
        },
        components: {
            'heading' : Heading,
            'form-error' : FormError,
            'submit-button' : SubmitButton,
        },
        methods: {
            show() {
                this.$http.get(`api/marcas/${this.id}`)
                    .then(response => {
                        this.marca = response.body
                    })
            },

            save() {
                this.submitted = true

                if(this.id) {
                    this._save = this.$http.put(`api/marcas/${this.id}`, this.marca)
                } else {
                    this._save = this.$http.post('api/marcas', this.marca)
                }

                this._save
                    .then(response => {
                        this.errors = response.body.errors ? response.body.errors : []
                        this.success = response.body.success
                        this.message = response.body.message
                        this.status = response.body.status

                        if(response.body.success) {
                            this.service.storage(response.body.message, response.body.status, '/marcas')
                        }

                        this.submitted = false
                    })
            }
        },
        computed: {
            addSubtitle () {
                if(this.id) {
                    return 'Alterar marca'
                }

                return 'Adicionar marca'
            }
        }
    }
</script>