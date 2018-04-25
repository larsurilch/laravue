<template>
    <div id="app">
        <navbar></navbar>
        <div class="ui main container">
            <router-view></router-view>
        </div>
        <modal></modal>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import Navbar from './components/shared/navbar/Navbar.vue'
    import Modal from './components/shared/modal/Modal.vue'

    export default {
        components: {
            'navbar': Navbar,
            'modal': Modal
        },

        computed: mapState({
            UsuarioStore: state => state.UsuarioStore
        }),

        created () {
            this.checkIsAuthenticated()
            this.getAuthenticatedUser()
        },

        methods: {
            checkIsAuthenticated () {
                const authState = this.$auth.isAuthenticated()
                this.$store.dispatch('setAuthState', authState)
            },

            getAuthenticatedUser () {
                const dataUser = this.$auth.getAuthenticatedUser()
                this.$store.dispatch('setData', dataUser)
            }
        }
    }
</script>

<style scoped>
    #app {
        padding: 55px 0 30px;
    }
</style>