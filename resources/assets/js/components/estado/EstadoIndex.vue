<template>
    <div>
        <heading icone="flag" titulo="Estados" subtitulo="Listagem de Estados"></heading>
        <search :total="params.total" @click.native="index">
            <div class="field">
                <input v-model="filters.descricao" type="text" placeholder="Nome">
            </div>
            <div class="field">
                <input v-model="filters.sigla" type="text" placeholder="Sigla">
            </div>
        </search>
        <data-grid :thead="thead" :params="params" @loadData="index" :colspan="2">
            <tr v-for="estado in estados">
                <td>{{ estado.sigla }}</td>
                <td>{{ estado.descricao }}</td>
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
                estados: [],
                params: {
                    total: 0,
                    per_page: 30,
                    current_page: 1,
                    column: 'descricao',
                    direction: 'asc'
                },
                thead: [
                    { title: 'Sigla', column: 'sigla', direction: 'desc', sortable: true, style: 'eight wide' },
                    { title: 'Descrição', column: 'descricao', direction: 'desc', sortable: true, style: 'eight wide' }
                ],
                message: null,
                status: null,
                filters: {
                    sigla: '',
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
                        this.estados = response.data.estados.data
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
                let sigla = this.filters.sigla === '' ? '' : `&sigla=${this.filters.sigla}`
                return `api/estados${current_page}${per_page}${direction}${column}${descricao}${sigla}`
            }
        }
    }
</script>