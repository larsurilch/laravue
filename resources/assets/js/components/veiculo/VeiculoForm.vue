<template>
    <div>
        <heading icone="car" titulo="Veículo" :subtitulo="addSubtitle"
                 url="/veiculos" label="Voltar" color="violet" :status="status" :message="message"></heading>
        <form class="ui form" @submit.prevent="save">
            <div class="four fields">
                <form-error classe="required four wide" :field="errors.modelo">
                    <label>Modelo</label>
                    <input type="text" name="modelo" v-model="veiculo.modelo" autocomplete="off" v-focus>
                </form-error>
                <form-error classe="required six wide" :field="errors.proprietario_id">
                    <label>Proprietário:</label>
                    <input type="text" name="proprietario_id" v-model="veiculo.proprietario_id" autocomplete="off">
                </form-error>
                <form-error classe="required three wide" :field="errors.placa">
                    <label>Placa:</label>
                    <input type="text" name="placa" v-model="veiculo.placa" autocomplete="off">
                </form-error>
                <form-error classe="required three wide" :field="errors.ano">
                    <label>Ano:</label>
                    <input type="text" name="ano" v-model="veiculo.ano" autocomplete="off">
                </form-error>
            </div>
            <div class="five fields">
                <form-error classe="three wide" :field="errors.quilometragem">
                    <label>Quilometragem:</label>
                    <input type="text" name="quilometragem" v-model="veiculo.quilometragem" autocomplete="off">
                </form-error>
                <form-error classe="required three wide" :field="errors.combustivel">
                    <label>Combustível:</label>
                    <input type="text" name="combustivel" v-model="veiculo.combustivel" autocomplete="off">
                </form-error>
                <form-error classe="required four wide" :field="errors.marca_id">
                    <label>Marca:</label>
                    <input type="text" name="marca_id" v-model="veiculo.marca_id" autocomplete="off">
                </form-error>
                <form-error classe="required three wide" :field="errors.data_cotacao">
                    <label>Data da cotação:</label>
                    <input type="text" name="data_cotacao" v-model="veiculo.data_cotacao" autocomplete="off">
                </form-error>
                <form-error classe="three wide" :field="errors.preco">
                    <label>Preço:</label>
                    <input type="text" name="preco" v-model="veiculo.preco" autocomplete="off">
                </form-error>
            </div>
            <div class="two fields">
                <form-error classe="required four wide" :field="errors.pais_id">
                    <label>País:</label>
                    <input type="text" name="pais_id" v-model="veiculo.pais_id" autocomplete="off">
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
    import Veiculo from '../../domain/veiculo/Veiculo'
    import GlobalService from '../../domain/GlobalService'

    export default {
        data () {
            return {
                veiculo: new Veiculo(),
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