<template>
    <div>
        <heading icone="registered" titulo="Marca" subtitulo="Listagem de marcas de veículos" url="/marcas/create"
            label="Novo" color="blue" :status="status" :message="message"></heading>
        <search :total="params.total" @click.native="index">
            <div class="field">
                <input v-model="filters.descricao" type="text" placeholder="Nome">
            </div>
        </search>
        <data-grid :thead="thead" :params="params" @loadData="index" :colspan="5">
            <tr v-for="marca in marcas">
                <td>{{ marca.descricao }}</td>
                <td>{{ marca.created_at }}</td>
                <td>{{ marca.updated_at }}</td>
                <td>
                    <router-link class="ui icon button green" :to="`/marcas/${marca.id}/edit`">
                        <i class="write icon"></i>
                    </router-link>
                </td>
                <td>
                    <button class="ui icon button red" @click="destroy(marca)">
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
                marcas: [],
                params: {
                    total: 0,
                    per_page: 30,
                    current_page: 1,
                    column: 'descricao',
                    direction: 'asc'
                },
                thead: [
                    { title: 'Marcas', column: 'descricao', direction: 'desc', sortable: true },
                    { title: 'Criado', column: 'created_at', direction: 'desc', sortable: false, style: 'three wide' },
                    { title: 'Modificado', column: 'updated_at', direction: 'desc', sortable: false, style: 'three wide' },
                    { title: '', column: '', direction: '', sortable: false, style: 'two wide', columns: 2 }
                ],
                message: null,
                status: null,
                success: true,
                filters: {
                    descricao: ''
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
                        this.marcas = response.data.marcas.data
                        this.filters = response.data.filters
                        this.params = response.data.params
                    }
                })
            },

            destroy(marca) {
                $('.small.modal')
                    .modal({
                        onShow: function () {
                            $('.record-delete').empty().text(marca.descricao)
                        },
                        onApprove: function () {
                            this.$http.delete(`api/marcas/${marca.id}`)
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
                let descricao = this.filters.descricao === '' ? '' : `&descricao=${this.filters.descricao}`
                return `api/marcas${current_page}${per_page}${direction}${column}${descricao}`
            }
        }
    }
</script>