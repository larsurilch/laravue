import Vue from 'vue'
import Vuex from 'vuex'

import UsuarioStore from './domain/usuario/UsuarioStore'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        UsuarioStore
    },
    strict: debug
})