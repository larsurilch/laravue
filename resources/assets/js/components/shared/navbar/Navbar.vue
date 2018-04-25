<template>
    <div class="ui fixed inverted menu" v-if="UsuarioStore.isAuth">
        <router-link to="/" class="header item">CodeGeo</router-link>
        <div class="ui simple dropdown item">
            Locais <i class="dropdown icon"></i>
            <div class="menu">
                <router-link v-if="permission('paises.index')" to="/paises" class="item">Países</router-link>
                <router-link v-if="permission('estados.index')" to="/estados" class="item">Estados</router-link>
                <router-link v-if="permission('cidades.index')" to="/cidades" class="item">Cidades</router-link>
            </div>
        </div>
        <div class="ui simple dropdown item">
            Básico <i class="dropdown icon"></i>
            <div class="menu">
                <router-link v-if="permission('marcas.index')" to="/marcas" class="item">Marcas</router-link>
            </div>
        </div>
        <router-link v-if="permission('proprietarios.index')" to="/proprietarios" class="item">Proprietários</router-link>
        <router-link v-if="permission('veiculos.index')" to="/veiculos" class="item">Veículos</router-link>
        <div class="ui simple dropdown item">
            Segurança <i class="dropdown icon"></i>
            <div class="menu">
                <router-link v-if="permission('perfis.index')" to="/perfis" class="item">Perfis</router-link>
            </div>
        </div>
        <div class="right menu">
            <a class="ui item" @click.prevent="deleteAuthenticatedUser">{{ UsuarioStore.dataUser.email }} - Desconectar</a>
        </div>
    </div>
</template>

<script>
    import permission from '../../../mixins/permission'
    import GlobalService from '../../../domain/GlobalService'

    export default {
        mixins: [permission],

        created () {
            this.getAuthenticatedUser()

            this.service = new GlobalService(this.$router)
        },

        methods: {
            deleteAuthenticatedUser () {
                this.$http.post('api/logout', { id: this.UsuarioStore.dataUser.id })
                    .then(response => {
                        this.service.storage(response.body.message, response.body.status, '/login')
                    })

                this.$auth.destroyToken()
                this.$store.dispatch('setAuthState', false)
            },

            getAuthenticatedUser () {
                const dataUser = this.$auth.getAuthenticatedUser()
                this.$store.dispatch('setData', dataUser)
            }
        }
    }
</script>