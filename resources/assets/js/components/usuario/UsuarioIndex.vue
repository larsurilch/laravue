<template>
    <div>
        <heading icone="users" titulo="Usuários" subtitulo="Listagem de usuários" url="/usuarios/create"
                 label="Novo" color="blue" :status="status" :message="message" :verify="permission('usuarios.store')"></heading>
        <search :total="params.total" @click.native="index">
            <div class="three wide field">
                <input v-model="filters.perfil" type="text" placeholder="Perfil">
            </div>
            <div class="four wide field">
                <input v-model="filters.email" type="text" placeholder="E-mail">
            </div>
            <div class="two wide field">
                <select v-model="filters.ativo">
                    <option value="">Ativo</option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>
        </search>
        <data-grid :thead="thead" :params="params" @loadData="index" :colspan="7">
            <tr v-for="usuario in usuarios">
                <td>{{ usuario.email }}</td>
                <td>{{ usuario.perfil }}</td>
                <td>{{ usuario.ativo ? 'Sim' : 'Não' }}</td>
                <td>{{ usuario.created_at }}</td>
                <td>{{ usuario.updated_at }}</td>
                <td>
                    <router-link v-if="permission('usuarios.update')" class="ui icon button green" :to="`/usuarios/${usuario.id}/edit`">
                        <i class="write icon"></i>
                    </router-link>
                </td>
                <td>
                    <button v-if="permission('usuarios.destroy')" class="ui icon button red" @click="destroy(usuario)">
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
                usuarios: [],
                params: {
                    total: 0,
                    per_page: 30,
                    current_page: 1,
                    column: 'usuarios.email',
                    direction: 'asc'
                },
                thead: [
                    { title: 'E-mail', column: 'usuarios.email', direction: 'desc', sortable: true },
                    { title: 'Perfil', column: 'perfis.descricao', direction: 'desc', sortable: true },
                    { title: 'Ativo', column: 'usuarios.ativo', direction: 'desc', sortable: true },
                    { title: 'Criado', column: 'created_at', direction: 'desc', sortable: false, style: 'three wide' },
                    { title: 'Modificado', column: 'updated_at', direction: 'desc', sortable: false, style: 'three wide' },
                    { title: '', column: '', direction: '', sortable: false, style: 'two wide', columns: 2 }
                ],
                message: null,
                status: null,
                success: true,
                filters: {
                    perfil: '',
                    email: '',
                    ativo: ''
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
                    this.usuarios = response.data.usuarios.data
                    this.filters = response.data.filters
                    this.params = response.data.params
                })
            },

            destroy(usuario) {
                $('.small.modal')
                    .modal({
                        onShow: function () {
                            $('.record-delete').empty().text(usuario.email)
                        },
                        onApprove: function () {
                            this.$http.delete(`api/usuarios/${usuario.id}`)
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
                let perfil = this.filters.perfil === '' ? '' : `&perfil=${this.filters.perfil}`
                let email = this.filters.email === '' ? '' : `&email=${this.filters.email}`
                let ativo = this.filters.ativo === '' ? '' : `&ativo=${this.filters.ativo}`
                return `api/usuarios${current_page}${per_page}${direction}${column}${perfil}${email}${ativo}`
            }
        }
    }
</script>