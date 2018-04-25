const state = {
    dataUser: '',
    isAuth: false
}

const mutations = {
    SET_DATA_USER (state, user) {
        state.dataUser = user
    },

    SET_IS_AUTH (state, authState) {
        state.isAuth = authState
    }
}

const actions = {
    setData: ({commit}, user) => {
        commit('SET_DATA_USER', user)
    },

    setAuthState: ({commit}, authState) => {
        commit('SET_IS_AUTH', authState)
    }
}

export default {
    state, mutations, actions
}