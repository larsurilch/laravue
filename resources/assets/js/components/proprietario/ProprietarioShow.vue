<template>
    <div>
        <heading icone="spy" titulo="Proprietário" subtitulo="Detalhes do proprietário"
                 url="/proprietarios" label="Voltar" color="violet" :status="status" :message="message"></heading>
        <div class="ui piled segment">
            <h4 class="ui horizontal divider header">{{ proprietario.nome }}</h4>
            <div class="ui vertically divided padded grid">
                <div class="four column row">
                    <div class="column"><b>Tipo:</b> {{ proprietario.tipo | person }}</div>
                    <div class="column"><b>Documento:</b> {{ proprietario.documento }}</div>
                    <div class="column"><b>Telefone principal:</b> {{ proprietario.fone_principal }}</div>
                    <div class="column"><b>Endereço:</b> {{ proprietario.endereco }}</div>
                </div>
                <div class="four column row">
                    <div class="column"><b>Complemento:</b> {{ proprietario.complemento }}</div>
                    <div class="column"><b>Bairro:</b> {{ proprietario.bairro }}</div>
                    <div class="column"><b>CEP:</b> {{ proprietario.cep }}</div>
                    <div class="column"><b>Cidade:</b> {{ proprietario.cidade.nome }}/{{ proprietario.cidade.uf }}</div>
                </div>
                <div class="four column row">
                    <div class="column"><b>Criado:</b> {{ proprietario.created_at }}</div>
                    <div class="column"><b>Modificado:</b> {{ proprietario.updated_at }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Heading from '../shared/header/Heading.vue'
    import Proprietario from '../../domain/proprietario/Proprietario'

    export default {
        data () {
            return {
                proprietario: new Proprietario(),
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
                this.$http.get(`api/proprietarios/${this.id}`)
                    .then(response => {
                        this.proprietario = response.body
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