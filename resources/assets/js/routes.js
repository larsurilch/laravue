import Welcome from './components/welcome/Welcome.vue'
import PaisIndex from './components/pais/PaisIndex.vue'
import EstadoIndex from './components/estado/EstadoIndex.vue'
import CidadeIndex from './components/cidade/CidadeIndex.vue'
import MarcaIndex from './components/marca/MarcaIndex.vue'
import MarcaForm from './components/marca/MarcaForm.vue'

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
    },
    {
        path: '/estados',
        component: EstadoIndex
    },
    {
        path: '/cidades',
        component: CidadeIndex
    },
    {
        path: '/marcas',
        component: MarcaIndex
    },
    {
        path: '/marcas/create',
        component: MarcaForm
    },
    {
        path: '/marcas/:id/edit',
        component: MarcaForm
    }
]