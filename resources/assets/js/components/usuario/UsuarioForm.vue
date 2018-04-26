<template>
    <div>
        <heading icone="users" titulo="Usuários" :subtitulo="addSubtitle" url="/usuarios"
                 label="Voltar" color="violet" :status="status" :message="message" :verify="permission('usuarios.index')"></heading>
        <form class="ui form" @submit.prevent="save">
            <div class="three fields">
                <form-error classe="required six wide" :field="errors.email">
                    <label>E-mail</label>
                    <input type="email" name="email" v-model="usuario.email" autocomplete="off" v-focus/>
                </form-error>
                <form-error classe="required four wide" :field="errors.senha">
                    <label>Senha</label>
                    <div class="ui left icon input">
                        <input type="password" name="senha" v-model="usuario.senha" autocomplete="off"/>
                        <i class="lock icon"></i>
                    </div>
                </form-error>
                <form-error classe="required four wide" :field="errors.perfil_id">
                    <label>Perfil</label>
                    <dropdown v-model="usuario.perfil_id" :itens="perfis"></dropdown>
                </form-error>
            </div>
            <div class="three fields">
                <form-error classe="required three wide" :field="errors.ativo">
                    <label>Ativo</label>
                    <select v-model="usuario.ativo">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </form-error>
            </div>
            <div v-if="id">
                <submit-button :submitted="submitted">
                    <input type="submit" class="ui green button" v-if="usuario.email && usuario.perfil_id" value="Salvar"/>
                </submit-button>
            </div>
            <div v-else>
                <submit-button :submitted="submitted">
                    <input type="submit" class="ui green button" v-if="usuario.email && usuario.perfil_id && usuario.senha" value="Salvar"/>
                </submit-button>
            </div>
        </form>
    </div>
</template>

<script>
    import Heading from '../shared/header/Heading.vue'
    import FormError from '../shared/form-error/FormError.vue'
    import SubmitButton from '../shared/submit-button/SubmitButton.vue'
    import Dropdown from '../shared/forms/Dropdown.vue'
    import Focus from '../../directives/Focus'
    import Usuario from '../../domain/usuario/Usuario'
    import GlobalService from '../../domain/GlobalService'
    import PerfilService from '../../domain/perfil/PerfilService'
    import permission from '../../mixins/permission'

    export default {
        data () {
            return {
                usuario: new Usuario(),
                perfis: [],
                id: this.$route.params.id,
                message: null,
                status: null,
                submitted: false,
                success: false,
                errors: []
            }
        },
        mixins: [permission],
        created () {
            this.service = new GlobalService(this.$router)
            this.perfis = new PerfilService(this.$resource)

            this.perfis
                .lista()
                .then(perfis => this.perfis = perfis.list)

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
            'dropdown' : Dropdown
        },
        methods: {
            show() {
                this.$http.get(`api/usuarios/${this.id}`)
                    .then(response => {
                        this.usuario = response.body
                    })
            },

            save() {
                this.submitted = true

                if(this.id) {
                    this._save = this.$http.put(`api/usuarios/${this.id}`, this.usuario)
                } else {
                    this._save = this.$http.post('api/usuarios', this.usuario)
                }

                this._save
                    .then(response => {
                        this.errors = response.body.errors ? response.body.errors : []
                        this.success = response.body.success
                        this.message = response.body.message
                        this.status = response.body.status

                        if(response.body.success) {
                            this.service.storage(response.body.message, response.body.status, '/usuarios')
                        }

                        this.submitted = false
                    })
            }
        },
        computed: {
            addSubtitle () {
                if(this.id) {
                    return 'Alterar usuário'
                }

                return 'Adicionar usuário'
            }
        }
    }
</script>