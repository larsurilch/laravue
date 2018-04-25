<template>
    <div>
        <heading icone="car" titulo="Veículo" subtitulo="Listagem de veículos"
                 url="/veiculos/create" label="Novo" color="blue" :status="status" :message="message" :verify="permission('veiculos.store')"></heading>
        <search :total="params.total" @click.native="index">
            <div class="four wide field">
                <input v-model="filters.modelo" type="text" placeholder="Modelo">
            </div>
            <div class="four wide field">
                <input v-model="filters.marca" type="text" placeholder="Marca">
            </div>
        </search>
        <data-grid :thead="thead" :params="params" @loadData="index" :colspan="7">
            <tr v-for="veiculo in veiculos">
                <td>{{ veiculo.marca }}</td>
                <td>{{ veiculo.modelo }}</td>
                <td>{{ veiculo.placa }}</td>
                <td>{{ veiculo.ano }}</td>
                <td>
                    <router-link v-if="permission('veiculos.show')" class="ui icon button violet" :to="`/veiculos/${veiculo.id}`">
                        <i class="info icon"></i>
                    </router-link>
                </td>
                <td>
                    <router-link v-if="permission('veiculos.update')" class="ui icon button green" :to="`/veiculos/${veiculo.id}/edit`">
                        <i class="write icon"></i>
                    </router-link>
                </td>
                <td>
                    <button v-if="permission('veiculos.destroy')" class="ui icon red button" @click="destroy(veiculo)">
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
    import permission from '../../mixins/permission'

    export default {
        data () {
            return {
                veiculos: [],
                params : {
                    total: 0,
                    per_page: 30,
                    current_page: 1,
                    column: 'veiculos.modelo',
                    direction: 'desc'
                },
                thead: [
                    { title: 'Marca', column: 'marcas.descricao', direction: 'desc', sortable: true },
                    { title: 'Modelo', column: 'veiculos.modelo', direction: 'desc', sortable: true },
                    { title: 'Placa', column: 'veiculos.placa', direction: 'desc', sortable: true },
                    { title: 'Ano', column: 'veiculos.ano', direction: 'desc', sortable: true },
                    { title: '', column: '', direction: '', sortable: false, style: 'two wide', columns: 3 }
                ],
                message: null,
                status: null,
                success: true,
                filters: {
                    modelo: '',
                    marca: ''
                }
            }
        },
        mixins: [flashMessage, permission],
        created () {
            this.index()
        },
        components: {
            'heading': Heading,
            'search': Search,
            'data-grid': DataGrid
        },
        methods: {
            index () {
                this.$http.get(this.buildURL()).then(response => {
                    this.veiculos = response.data.veiculos.data
                    this.filters = response.data.filters
                    this.params = response.data.params
                })
            },

            destroy (veiculo) {
                $('.small.modal')
                    .modal({
                        onShow: function(){
                            $('.record-delete').empty().text(veiculo.modelo)
                        },
                        onApprove: function(){
                            this.$http.delete(`api/veiculos/${veiculo.id}`)
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
                let modelo = this.filters.modelo === '' ? '' : `&modelo=${this.filters.modelo}`
                let marca = this.filters.marca === '' ? '' : `&marca=${this.filters.marca}`
                return `api/veiculos${current_page}${per_page}${column}${direction}${modelo}${marca}`
            }
        }
    }
</script>