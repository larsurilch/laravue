<template>
    <div>
        <heading icone="flag" titulo="Cidades" subtitulo="Listagem de cidades brasileiras"></heading>
        <search :total="params.total" @click.native="index">
            <div class="field">
                <input v-model="filters.nome" type="text" placeholder="Nome">
            </div>
            <div class="field">
                <input v-model="filters.uf" type="text" placeholder="UF">
            </div>
        </search>
        <data-grid :thead="thead" :params="params" @loadData="index" :colspan="2">
            <tr v-for="cidade in cidades">
                <td>{{ cidade.nome }}</td>
                <td>{{ cidade.uf }}</td>
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
                cidades: [],
                params: {
                    total: 0,
                    per_page: 30,
                    current_page: 1,
                    column: 'nome',
                    direction: 'asc'
                },
                thead: [
                    { title: 'Cidade', column: 'nome', direction: 'desc', sortable: true, style: 'eight wide' },
                    { title: 'UF', column: 'uf', direction: 'desc', sortable: true, style: 'eight wide' }
                ],
                message: null,
                status: null,
                filters: {
                    nome: '',
                    uf: ''
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
                        this.cidades = response.data.cidades.data
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
                let nome = this.filters.nome === '' ? '' : `&nome=${this.filters.nome}`
                let uf = this.filters.uf === '' ? '' : `&uf=${this.filters.uf}`
                return `api/cidades${current_page}${per_page}${direction}${column}${nome}${uf}`
            }
        }
    }
</script>