<template>
    <div>
        <heading icone="lock" titulo="Perfis" :subtitulo="addSubtitle" url="/perfis"
                 label="Voltar" color="violet" :status="status" :message="message" :verify="permission('perfis.index')"></heading>
        <form class="ui form" @submit.prevent="save">
            <div class="one field">
                <form-error classe="required" :field="errors.descricao">
                    <label>Descrição</label>
                    <input type="text" name="descricao" v-model="perfil.descricao" autocomplete="off" v-focus/>
                </form-error>
            </div>
            <div class="ui four column grid">
                <div class="column" v-for="(label, id, index) in acoes">
                    <checkbox :label="label" :id="id" :index="index" :value="id" v-model="perfil.acao_list"></checkbox>
                </div>
            </div>
            <submit-button :submitted="submitted">
                <input type="submit" class="ui green button" v-if="perfil.descricao && perfil.acao_list.length > 0" value="Salvar"/>
            </submit-button>
        </form>
    </div>
</template>

<script>
    import Heading from '../shared/header/Heading.vue'
    import FormError from '../shared/form-error/FormError.vue'
    import Checkbox from '../shared/forms/Checkbox.vue'
    import SubmitButton from '../shared/submit-button/SubmitButton.vue'
    import Focus from '../../directives/Focus'
    import Perfil from '../../domain/perfil/Perfil'
    import GlobalService from '../../domain/GlobalService'
    import AcaoService from '../../domain/acao/AcaoService'
    import permission from '../../mixins/permission'

    export default {
        data () {
            return {
                perfil: new Perfil(),
                acoes: [],
                id: this.$route.params.id,
                message: null,
                status: null,
                submitted: false,
                success: false,
                visivel: false,
                errors: []
            }
        },
        mixins: [permission],
        created () {
            this.service = new GlobalService(this.$router)
            this.acoes = new AcaoService(this.$resource)

            this.acoes
                .lista()
                .then(acoes => this.acoes = acoes.list)

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
            'checkbox' : Checkbox,
        },
        methods: {
            show() {
                this.$http.get(`api/perfis/${this.id}`)
                    .then(response => {
                        this.perfil = response.body
                    })
            },

            save() {
                this.submitted = true

                if(this.id) {
                    this._save = this.$http.put(`api/perfis/${this.id}`, this.perfil)
                } else {
                    this._save = this.$http.post('api/perfis', this.perfil)
                }

                this._save
                    .then(response => {
                        this.errors = response.body.errors ? response.body.errors : []
                        this.success = response.body.success
                        this.message = response.body.message
                        this.status = response.body.status

                        if(response.body.success) {
                            this.service.storage(response.body.message, response.body.status, '/perfis')
                        }

                        this.submitted = false
                    })
            }
        },
        computed: {
            addSubtitle () {
                if(this.id) {
                    return 'Alterar perfil'
                }

                return 'Adicionar perfil'
            }
        }
    }
</script>