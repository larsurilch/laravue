import Welcome from './components/welcome/Welcome.vue'
import PaisIndex from './components/pais/PaisIndex.vue'
import EstadoIndex from './components/estado/EstadoIndex.vue'
import CidadeIndex from './components/cidade/CidadeIndex.vue'
import MarcaIndex from './components/marca/MarcaIndex.vue'
import MarcaForm from './components/marca/MarcaForm.vue'
import ProprietarioIndex from './components/proprietario/ProprietarioIndex.vue'
import ProprietarioForm from './components/proprietario/ProprietarioForm.vue'
import ProprietarioShow from './components/proprietario/ProprietarioShow.vue'
import VeiculoIndex from './components/veiculo/VeiculoIndex.vue'
import VeiculoForm from './components/veiculo/VeiculoForm.vue'
import VeiculoShow from './components/veiculo/VeiculoShow.vue'

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
    },
    {
        path: '/proprietarios',
        component: ProprietarioIndex
    },
    {
        path: '/proprietarios/create',
        component: ProprietarioForm
    },
    {
        path: '/proprietarios/:id/edit',
        component: ProprietarioForm
    },
    {
        path: '/proprietarios/:id',
        component: ProprietarioShow
    },
    {
        path: '/veiculos',
        component: VeiculoIndex
    },
    {
        path: '/veiculos/create',
        component: VeiculoForm
    },
    {
        path: '/veiculos/:id/edit',
        component: VeiculoForm
    },
    {
        path: '/veiculos/:id',
        component: VeiculoShow
    }
];