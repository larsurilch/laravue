<template>
    <div>
        <heading icone="spy" titulo="Proprietário" :subtitulo="addSubtitle"
                 url="/proprietarios" label="Voltar" color="violet" :status="status" :message="message" :verify="permission('proprietarios.index')"></heading>
        <form class="ui form" @submit.prevent="save">
            <div class="three fields">
                <form-error classe="required ten wide" :field="errors.nome">
                    <label>Nome</label>
                    <input type="text" name="nome" v-model="proprietario.nome" autocomplete="off" v-focus>
                </form-error>
                <form-error classe="required three wide" :field="errors.tipo">
                    <label>Tipo</label>
                    <select v-model="proprietario.tipo" @change="clearField">
                        <option value="PJ">Pessoa Jurídica</option>
                        <option value="PF">Pessoa Física</option>
                    </select>
                </form-error>
                <div class="required three wide" v-if="proprietario.tipo === 'PJ'">
                    <form-error :field="errors.documento">
                        <label>CNPJ:</label>
                        <input type="text" name="documento" v-mask="'##.###.###/###-##'" v-model="proprietario.documento" autocomplete="off">
                    </form-error>
                </div>
                <div class="required three wide" v-else>
                    <form-error :field="errors.documento">
                        <label>CPF:</label>
                        <input type="text" name="documento" v-mask="'###.###.###-##'" v-model="proprietario.documento" autocomplete="off">
                    </form-error>
                </div>
            </div>
            <div class="three fields">
                <form-error classe="required three wide" :field="errors.fone_principal">
                    <label>Telefone principal:</label>
                    <phone name="fone_principal" v-model="proprietario.fone_principal"></phone>
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
                    <input type="text" name="cep" v-mask="'##.###-###'" v-model="proprietario.cep" autocomplete="off">
                </form-error>
                <form-error classe="required six wide" :field="errors.estado_id">
                    <label>Estado</label>
                    <dropdown v-model="proprietario.estado_id" :itens="estados" @loadCombo="loadCidade"></dropdown>
                </form-error>
            </div>
            <div class="one field">
                <form-error classe="required six wide" :field="errors.cidade_id">
                    <label>Cidade</label>
                    <dropdown v-model="proprietario.cidade_id" :itens="cidades" class="dropdown-cidade"></dropdown>
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
    import Phone from '../shared/forms/Phone.vue'
    import Dropdown from '../shared/forms/Dropdown.vue'
    import Focus from '../../directives/Focus'
    import { VueMaskDirective } from 'v-mask'
    import Proprietario from '../../domain/proprietario/Proprietario'
    import GlobalService from '../../domain/GlobalService'
    import EstadoService from '../../domain/estado/EstadoService'
    import CidadeService from '../../domain/cidade/CidadeService'
    import permission from '../../mixins/permission'

    export default {
        data () {
            return {
                proprietario: new Proprietario(),
                estados: [],
                cidades: [],
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
            this.estados = new EstadoService(this.$resource)

            this.estados
                .lista()
                .then(estados => this.estados = estados.list)

            if(this.id) {
                this.show()
            }
        },
        directives: {
            focus: Focus,
            mask: VueMaskDirective
        },
        components: {
            'heading': Heading,
            'form-error': FormError,
            'submit-button': SubmitButton,
            'phone': Phone,
            'dropdown': Dropdown
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
            },

            loadCidade () {
                let cidade_id = this.proprietario.cidade_id

                this.cidades = new CidadeService(this.$resource)
                this.cidades
                    .busca(this.proprietario.estado_id)
                    .then(cidades => {
                        this.cidades = cidades.list

                        $('.dropdown-cidade').dropdown('clear')

                        setTimeout(function () {
                            $('.dropdown-cidade').dropdown('set selected', cidade_id)
                        }, 10)

                        if(!(cidade_id in this.cidades)) {
                            this.proprietario.cidade_id = ''
                        }
                    })
            },

            clearField () {
                this.proprietario.documento = ''
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