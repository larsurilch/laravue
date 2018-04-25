<template>
    <div>
        <heading icone="car" titulo="Veículo" :subtitulo="addSubtitle"
                 url="/veiculos" label="Voltar" color="violet" :status="status" :message="message" :verify="permission('veiculos.index')"></heading>
        <form class="ui form" @submit.prevent="save">
            <div class="four fields">
                <form-error classe="required four wide" :field="errors.modelo">
                    <label>Modelo</label>
                    <input type="text" name="modelo" v-model="veiculo.modelo" autocomplete="off" v-focus>
                </form-error>
                <form-error classe="required six wide" :field="errors.proprietario_id">
                    <label>Proprietário:</label>
                    <dropdown v-model="veiculo.proprietario_id" :itens="proprietarios"></dropdown>
                </form-error>
                <form-error classe="required three wide" :field="errors.placa">
                    <label>Placa:</label>
                    <input type="text" name="placa" v-mask="'AAA-####'" v-model="veiculo.placa" autocomplete="off">
                </form-error>
                <form-error classe="required three wide" :field="errors.ano">
                    <label>Ano:</label>
                    <input type="text" name="ano" v-mask="'####'" v-model="veiculo.ano" autocomplete="off">
                </form-error>
            </div>
            <div class="five fields">
                <form-error classe="three wide" :field="errors.quilometragem">
                    <label>Quilometragem:</label>
                    <input type="text" name="quilometragem" v-mask="'#?#######'" v-model="veiculo.quilometragem" autocomplete="off">
                </form-error>
                <form-error classe="required three wide" :field="errors.combustivel">
                    <label>Combustível:</label>
                    <input type="text" name="combustivel" v-model="veiculo.combustivel" autocomplete="off">
                </form-error>
                <form-error classe="required four wide" :field="errors.marca_id">
                    <label>Marca:</label>
                    <dropdown v-model="veiculo.marca_id" :itens="marcas"></dropdown>
                </form-error>
                <form-error classe="required three wide" :field="errors.data_cotacao">
                    <label>Data da cotação:</label>
                    <calendar v-model="veiculo.data_cotacao"></calendar>
                </form-error>
                <form-error classe="three wide" :field="errors.preco">
                    <label>Preço:</label>
                    <money type="text" name="preco" v-model="veiculo.preco" v-bind="money" autocomplete="off"></money>
                </form-error>
            </div>
            <div class="two fields">
                <form-error classe="required four wide" :field="errors.pais_id">
                    <label>País:</label>
                    <dropdown v-model="veiculo.pais_id" :itens="paises"></dropdown>
                </form-error>
                <form-error classe="required twelve wide" :field="errors.descricao">
                    <label>Descrição:</label>
                    <input type="text" name="descricao" v-model="veiculo.descricao" autocomplete="off">
                </form-error>
            </div>
            <submit-button :submitted="submitted">
                <input type="submit" class="ui green button"
                       v-if="veiculo.modelo && veiculo.proprietario_id && veiculo.placa  && veiculo.ano && veiculo.combustivel
                       && veiculo.marca_id && veiculo.data_cotacao && veiculo.pais_id && veiculo.descricao"
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
    import Dropdown from '../shared/forms/Dropdown.vue'
    import Calendar from '../shared/forms/Calendar.vue'
    import { VueMaskDirective } from 'v-mask'
    import { Money } from 'v-money'
    import Veiculo from '../../domain/veiculo/Veiculo'
    import PaisService from '../../domain/pais/PaisService'
    import MarcaService from '../../domain/marca/MarcaService'
    import ProprietarioService from '../../domain/proprietario/ProprietarioService'
    import GlobalService from '../../domain/GlobalService'
    import permission from '../../mixins/permission'

    export default {
        data () {
            return {
                veiculo: new Veiculo(),
                money: {
                    decimal: ',',
                    thousands: '.',
                    prefix: 'R$ ',
                    suffix: '',
                    precision: 2,
                    masked: false
                },
                paises: [],
                marcas: [],
                proprietarios: [],
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
            this.paises = new PaisService(this.$resource)
            this.marcas = new MarcaService(this.$resource)
            this.proprietarios = new ProprietarioService(this.$resource)

            this.paises
                .lista()
                .then(paises => this.paises = paises.list)

            this.marcas
                .lista()
                .then(marcas => this.marcas = marcas.list)

            this.proprietarios
                .lista()
                .then(proprietarios => this.proprietarios = proprietarios.list)

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
            'dropdown': Dropdown,
            'calendar': Calendar,
            Money
        },
        methods: {
            show() {
                this.$http.get(`api/veiculos/${this.id}`)
                    .then(response => {
                        this.veiculo = response.body
                    })
            },

            save () {
                this.submitted = true

                if(this.id) {
                    this._save = this.$http.put(`api/veiculos/${this.id}`, this.veiculo)
                } else {
                    this._save = this.$http.post('api/veiculos', this.veiculo)
                }

                this._save
                    .then(response => {
                        this.errors = response.body.errors ? response.body.errors: []
                        this.success = response.body.success
                        this.message = response.body.message
                        this.status = response.body.status

                        if(response.body.success) {
                            this.service.storage(response.body.message, response.body.status, '/veiculos')
                        }

                        this.submitted = false
                    })
            }
        },
        computed: {
            addSubtitle () {
                if(this.id) {
                    return 'Alterar veículo'
                }

                return 'Adicionar veículo'
            }
        }
    }
</script>