<template>
    <div>
        <heading icone="flag" titulo="País" subtitulo="Listagem de países do mundo"></heading>
        <search :total="params.total" @click.native="index">
            <div class="field">
                <input v-model="filters.descricao" type="text" placeholder="Nome">
            </div>
        </search>
        <data-grid :thead="thead" :params="params" @loadData="index">
            <tr v-for="pais in paises">
                <td>{{ pais.descricao }}</td>
            </tr>
        </data-grid>
    </div>
</template>

<script>
    import Heading from '../shared/header/Heading.vue'
    import Search from '../shared/header/Search.vue'
    import DataGrid from '../shared/data-grid/DataGrid.vue'

    export default {
        data () {
            return {
                paises: [],
                params: {
                    total: 0,
                    per_page: 30,
                    current_page: 1,
                    column: 'descricao',
                    direction: 'asc'
                },
                thead: [
                    { title: 'País', column: 'descricao', direction: 'desc', sortable: true }
                ],
                message: null,
                status: null,
                filters: {
                    descricao: ''
                }
            }
        },
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
                        this.paises = response.data.paises.data
                        this.filters = response.data.filters
                        this.params = response.data.params
                    }
                })
            },
            buildURL() {
                let current_page = `?page=${this.params.current_page}`
                let per_page = `&per_page=${this.params.per_page}`
                let direction = `&direction=${this.params.direction}`
                let column = `&column=${this.params.column}`
                let descricao = this.filters.descricao === '' ? '' : `&descricao=${this.filters.descricao}`
                return `api/paises${current_page}${per_page}${direction}${column}${descricao}`
            }
        }
    }
</script>