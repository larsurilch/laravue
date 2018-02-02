<template>
    <div>
        <heading icone="car" titulo="Veículo" subtitulo="Detalhes do veículo"
                 url="/veiculos" label="Voltar" color="violet" :status="status" :message="message"></heading>
        <div class="ui piled segment">
            <h4 class="ui horizontal divider header">{{ veiculo.modelo }}</h4>
            <div class="ui vertically divided padded grid">
                <div class="four column row">
                    <div class="column"><b>Proprietário:</b> {{ veiculo.proprietario_id }}</div>
                    <div class="column"><b>Placa:</b> {{ veiculo.placa }}</div>
                    <div class="column"><b>Ano:</b> {{ veiculo.ano }}</div>
                    <div class="column"><b>Quilometragem:</b> {{ veiculo.quilometragem }}</div>
                </div>
                <div class="four column row">
                    <div class="column"><b>Combustível:</b> {{ veiculo.combustivel }}</div>
                    <div class="column"><b>Marca:</b> {{ veiculo.marca_id }}</div>
                    <div class="column"><b>Data da cotação:</b> {{ veiculo.data_cotacao }}</div>
                    <div class="column"><b>Preço:</b> {{ veiculo.preco }}</div>
                </div>
                <div class="four column row">
                    <div class="column"><b>País:</b> {{ veiculo.pais_id }}</div>
                    <div class="column"><b>Descrição:</b> {{ veiculo.descricao }}</div>
                    <div class="column"><b>Criado:</b> {{ veiculo.created_at }}</div>
                    <div class="column"><b>Modificado:</b> {{ veiculo.updated_at }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Heading from '../shared/header/Heading.vue'
    import Veiculo from '../../domain/veiculo/Veiculo'

    export default {
        data () {
            return {
                veiculo: new Veiculo(),
                id: this.$route.params.id,
                message: null,
                status: null,
            }
        },
        created () {
            this.show()
        },
        components: {
            'heading': Heading
        },
        methods: {
            show() {
                this.$http.get(`api/veiculos/${this.id}`)
                    .then(response => {
                        this.veiculo = response.body
                    })
            }
        }
    }
</script>

<style scoped>
    h4 {
        margin: 10px 0 30px !important;
    }
</style>