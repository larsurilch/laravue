import Welcome from './components/welcome/Welcome.vue'
import PaisIndex from './components/pais/PaisIndex.vue'

export const routes = [
    {
        path: '*',
        component: Welcome
    },
    {
        path: '/welcome',
        component: Welcome
    },
    {
        path: '/paises',
        component: PaisIndex
    }
]