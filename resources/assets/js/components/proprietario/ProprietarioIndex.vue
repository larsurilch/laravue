<template>
    <div>
        <heading icone="spy" titulo="Proprietário" subtitulo="Listagem de proprietários" url="/proprietarios/create"
                 label="Novo" color="blue" :status="status" :message="message"></heading>
        <search :total="params.total" @click.native="index">
            <div class="field">
                <input v-model="filters.nome" type="text" placeholder="Nome">
            </div>
        </search>
        <data-grid :thead="thead" :params="params" @loadData="index" :colspan="7">
            <tr v-for="proprietario in proprietarios">
                <td>{{ proprietario.nome }}</td>
                <td>{{ proprietario.tipo | person }}</td>
                <td>{{ proprietario.documento }}</td>
                <td>{{ proprietario.fone_principal }}</td>
                <td>
                    <router-link class="ui icon button violet" :to="`/proprietarios/${proprietario.id}`">
                        <i class="info icon"></i>
                    </router-link>
                </td>
                <td>
                    <router-link class="ui icon button green" :to="`/proprietarios/${proprietario.id}/edit`">
                        <i class="write icon"></i>
                    </router-link>
                </td>
                <td>
                    <button class="ui icon button red" @click="destroy(proprietario)">
                        <i class="trash icon"></i>
                    </button>
                </td>
            </tr>
        </data-grid>
    </div>
</template>

<script>
    import Heading from '../shared/header/Heading.vue'
    import Search from '../shared/header/Search.vue'
    import DataGrid from '../shared/data-grid/DataGrid.vue'
    import flashMessage from '../../mixins/flashMessage'

    export default {
        data () {
            return {
                proprietarios: [],
                params: {
                    total: 0,
                    per_page: 30,
                    current_page: 1,
                    column: 'nome',
                    direction: 'asc'
                },
                thead: [
                    { title: 'Proprietário', column: 'nome', direction: 'desc', sortable: true },
                    { title: 'Tipo', column: 'tipo', direction: 'desc', sortable: false },
                    { title: 'Documento', column: 'documento', direction: 'desc', sortable: false },
                    { title: 'Telefone', column: 'fone_principal', direction: 'desc', sortable: false },
                    { title: '', column: '', direction: '', sortable: false, style: 'two wide', columns: 3 }
                ],
                message: null,
                status: null,
                success: true,
                filters: {
                    nome: ''
                }
            }
        },
        mixins: [flashMessage],
        created () {
            this.index()
        },
        components: {
            'heading': Heading,
            'search': Search,
            'data-grid': DataGrid
        },
        methods: {
            index() {
                this.$http.get(this.buildURL()).then(response => {
                    if(response.body.message) {
                        this.message = response.body.message
                        this.status = response.body.status
                    } else {
                        this.proprietarios = response.data.proprietarios.data
                        this.filters = response.data.filters
                        this.params = response.data.params
                    }
                })
            },

            destroy(proprietario) {
                $('.small.modal')
                    .modal({
                        onShow: function () {
                            $('.record-delete').empty().text(proprietario.nome)
                        },
                        onApprove: function () {
                            this.$http.delete(`api/proprietarios/${proprietario.id}`)
                                .then(response => {
                                    this.success = response.body.success
                                    this.message = response.body.message
                                    this.status = response.body.status
                                    this.index()
                                })
                        }.bind(this)
                    }).modal('show')

                return false;
            },

            buildURL() {
                let current_page = `?page=${this.params.current_page}`
                let per_page = `&per_page=${this.params.per_page}`
                let direction = `&direction=${this.params.direction}`
                let column = `&column=${this.params.column}`
                let nome = this.filters.nome === '' ? '' : `&nome=${this.filters.nome}`
                return `api/proprietarios${current_page}${per_page}${direction}${column}${nome}`
            }
        }
    }
</script>