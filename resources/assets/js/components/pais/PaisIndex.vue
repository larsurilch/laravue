<template>
    <div>
        <h2 class="ui header floated left">
            <i class="flag icon"></i>
            <div class="content">
                País
                <div class="sub header">Listagem de países do mundo</div>
            </div>
        </h2>
        <div class="ui divider clearing"></div>
        <div class="ui form">
            <div class="fields">
                <div class="field">
                    <input v-model="filters.descricao" type="text" placeholder="Nome">
                </div>
                <div class="field">
                    <button class="ui labeled icon button" @click="index">
                        <i class="search icon"></i>
                        Pesquisar
                    </button>
                </div>
            </div>
        </div>
        <div class="ui divider"></div>
        <div v-if="params.total === 0" class="ui yellow message">Não há informações registradas no sistema.</div>
        <div v-else>
            <p>Total de registros cadastrados: {{ params.total }}</p>
        </div>
        <div v-if="params.total !== 0">
            <table class="ui striped table">
                <thead>
                    <tr>
                        <th v-for="item in thead">
                            <div v-if="item.sortable" @click="sort(item.column)" class="th-order">
                                {{ item.title }}
                                <span v-if="params.column === item.column">
                                    <span v-if="params.direction === item.direction">&#x25B2;</span>
                                    <span v-else>&#x25BC;</span>
                                </span>
                            </div>
                            <div v-else>
                                {{ item.title }}
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="pais in paises">
                        <td>{{ pais.descricao }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>
                            <div class="ui grid">
                                <div class="three column row ui form">
                                    <div class="column inline field">
                                        <label>Exibir</label>
                                        <select v-model="params.per_page" @change="index">
                                            <option>15</option>
                                            <option>30</option>
                                            <option>45</option>
                                        </select>
                                        <label>registros</label>
                                    </div>
                                    <div class="column inline field">
                                        <div class="ui center aligned grid field">
                                            <label class="current_page">Página atual</label>
                                            <input type="text" class="two wide field" v-model="params.current_page" @keyup.enter="index">
                                            <label class="current_page"> de {{ params.last_page }}</label>
                                        </div>
                                    </div>
                                    <div class="column inline field">
                                        <div class="ui right floated pagination menu">
                                            <a href="#" class="icon item" @click.prevent="prev">
                                                <i class="left chevron icon"></i>
                                            </a>
                                            <a href="#" class="icon item" @click.prevent="next">
                                                <i class="right chevron icon"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
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
        methods: {
            sort(column) {
                if(column === this.params.column) {
                    if(this.params.direction === 'desc') {
                        this.params.direction = 'asc'
                    } else {
                        this.params.direction = 'desc'
                    }
                } else {
                    this.params.column = column
                    this.params.direction = 'asc'
                }
                this.index()
            },
            next() {
                if(this.params.next_page_url) {
                    this.params.current_page++
                    this.index()
                }
            },
            prev() {
                if(this.params.prev_page_url) {
                    this.params.current_page--
                    this.index()
                }
            },
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

<style scoped>
    .th-order {
        cursor: pointer;
    }
    .current_page {
        margin-top: 10px !important;
    }
</style>