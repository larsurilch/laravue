import {mapState} from 'vuex'

export default {
    computed: mapState({
        UsuarioStore: state => state.UsuarioStore
    }),

    methods: {
        permission (url) {
            if(this.UsuarioStore.dataUser.acl)
                return this.UsuarioStore.dataUser.acl.includes(url) || this.UsuarioStore.dataUser.acl.includes('*')
        }
    }
}