<template>
    <div>
        <heading icone="spy" titulo="Proprietário" :subtitulo="addSubtitle"
                 url="/proprietarios" label="Voltar" color="violet" :status="status" :message="message"></heading>
        <form class="ui form" @submit.prevent="save">
            <div class="three fields">
                <form-error classe="required ten wide" :field="errors.nome">
                    <label>Nome</label>
                    <input type="text" name="nome" v-model="proprietario.nome" autocomplete="off" v-focus>
                </form-error>
                <form-error classe="required three wide" :field="errors.tipo">
                    <label>Tipo</label>
                    <select v-model="proprietario.tipo">
                        <option value="PJ">Pessoa Jurídica</option>
                        <option value="PF">Pessoa Física</option>
                    </select>
                </form-error>
                <form-error classe="required three wide" :field="errors.documento">
                    <label>Documento:</label>
                    <input type="text" name="documento" v-model="proprietario.documento" autocomplete="off">
                </form-error>
            </div>
            <div class="three fields">
                <form-error classe="required three wide" :field="errors.fone_principal">
                    <label>Telefone principal:</label>
                    <input type="text" name="fone_principal" v-model="proprietario.fone_principal" autocomplete="off">
                </form-error>
                <form-error classe="required eight wide" :field="errors.endereco">
                    <label>Endereço:</label>
                    <input type="text" name="endereco" v-model="proprietario.endereco" autocomplete="off">
                </form-error>
                <form-error classe="five wide" :field="errors.complemento">
                    <label>Complemento:</label>
                    <input type="text" name="complemento" v-model="proprietario.complemento" autocomplete="off">
                </form-error>
            </div>
            <div class="three fields">
                <form-error classe="required six wide" :field="errors.bairro">
                    <label>Bairro:</label>
                    <input type="text" name="bairro" v-model="proprietario.bairro" autocomplete="off">
                </form-error>
                <form-error classe="four wide" :field="errors.cep">
                    <label>CEP:</label>
                    <input type="text" name="cep" v-model="proprietario.cep" autocomplete="off">
                </form-error>
                <form-error classe="required six wide" :field="errors.estado_id">
                    <label>Estado</label>
                    <input type="text" name="estado_id" v-model="proprietario.estado_id" autocomplete="off">
                </form-error>
            </div>
            <div class="one field">
                <form-error classe="required six wide" :field="errors.cidade_id">
                    <label>Cidade</label>
                    <input type="text" name="cidade_id" v-model="proprietario.cidade_id" autocomplete="off">
                </form-error>
            </div>
            <submit-button :submitted="submitted">
                <input type="submit" class="ui green button"
                       v-if="proprietario.nome && proprietario.tipo && proprietario.documento  && proprietario.fone_principal
                               && proprietario.endereco && proprietario.bairro && proprietario.estado_id && proprietario.cidade_id"
                       value="Salvar">
            </submit-button>
        </form>
    </div>
</template>

<script>
    import Heading from '../shared/header/Heading.vue'
    import FormError from '../shared/form-error/FormError.vue'
    import SubmitButton from '../shared/submit-button/SubmitButton.vue'
    import Focus from '../../directives/Focus'
    import Proprietario from '../../domain/proprietario/Proprietario'
    import GlobalService from '../../domain/GlobalService'

    export default {
        data () {
            return {
                proprietario: new Proprietario(),
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
            'heading': Heading,
            'form-error': FormError,
            'submit-button': SubmitButton
        },
        methods: {
            show() {
                this.$http.get(`api/proprietarios/${this.id}`)
                    .then(response => {
                        this.proprietario = response.body
                    })
            },

            save () {
                this.submitted = true

                if(this.id) {
                    this._save = this.$http.put(`api/proprietarios/${this.id}`, this.proprietario)
                } else {
                    this._save = this.$http.post('api/proprietarios', this.proprietario)
                }

                this._save
                    .then(response => {
                        this.errors = response.body.errors ? response.body.errors: []
                        this.success = response.body.success
                        this.message = response.body.message
                        this.status = response.body.status

                        if(response.body.success) {
                            this.service.storage(response.body.message, response.body.status, '/proprietarios')
                        }

                        this.submitted = false
                    })
            }
        },
        computed: {
            addSubtitle () {
                if(this.id) {
                    return 'Alterar proprietário'
                }

                return 'Adicionar proprietário'
            }
        }
    }
</script>