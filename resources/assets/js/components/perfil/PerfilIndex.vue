<template>
    <div>
        <heading icone="lock" titulo="Perfis" subtitulo="Listagem de perfis" url="/perfis/create"
                 label="Novo" color="blue" :status="status" :message="message" :verify="permission('perfis.store')"></heading>
        <search :total="params.total" @click.native="index">
            <div class="field">
                <input v-model="filters.descricao" type="text" placeholder="Nome">
            </div>
        </search>
        <data-grid :thead="thead" :params="params" @loadData="index" :colspan="5">
            <tr v-for="perfil in perfis">
                <td>{{ perfil.descricao }}</td>
                <td>{{ perfil.created_at }}</td>
                <td>{{ perfil.updated_at }}</td>
                <td>
                    <router-link v-if="permission('perfis.update')" class="ui icon button green" :to="`/perfis/${perfil.id}/edit`">
                        <i class="write icon"></i>
                    </router-link>
                </td>
                <td>
                    <button v-if="permission('perfis.destroy')" class="ui icon button red" @click="destroy(perfil)">
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
                perfis: [],
                params: {
                    total: 0,
                    per_page: 30,
                    current_page: 1,
                    column: 'descricao',
                    direction: 'asc'
                },
                thead: [
                    { title: 'Descrição', column: 'descricao', direction: 'desc', sortable: true },
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
            index() {
                this.$http.get(this.buildURL()).then(response => {
                    if(response.body.message) {
                        this.message = response.body.message
                        this.status = response.body.status
                    } else {
                        this.perfis = response.data.perfis.data
                        this.filters = response.data.filters
                        this.params = response.data.params
                    }
                })
            },

            destroy(perfil) {
                $('.small.modal')
                    .modal({
                        onShow: function () {
                            $('.record-delete').empty().text(perfil.descricao)
                        },
                        onApprove: function () {
                            this.$http.delete(`api/perfis/${perfil.id}`)
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
                return `api/perfis${current_page}${per_page}${direction}${column}${descricao}`
            }
        }
    }
</script>