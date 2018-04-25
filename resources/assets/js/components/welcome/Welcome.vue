<template>
    <div class="ui message">
        <h1 class="ui header">Seja bem-vindo, <strong>{{ UsuarioStore.dataUser.email }}</strong></h1>
        <p>O sistema CodeGeo Venda de Veículos permite fazer a gerência da sua loja. Através dele é possível controlar marcas,
        veículos e proprietários.</p>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        computed: mapState({
            UsuarioStore: state => state.UsuarioStore
        }),

        created () {
            this.setAuthenticatedUser()
        },

        methods: {
            setAuthenticatedUser () {
                this.$http.get('api/autenticado')
                    .then(response => {
                        this.$auth.setAuthenticatedUser(response.body)
                        this.getAuthenticatedUser()
                    })
            },

            getAuthenticatedUser () {
                const dataUser = this.$auth.getAuthenticatedUser()
                this.$store.dispatch('setData', dataUser)
            }
        }
    }
</script>