import Login from './components/authentication/Login.vue'

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
import PerfilIndex from './components/perfil/PerfilIndex.vue'
import PerfilForm from './components/perfil/PerfilForm.vue'

export const routes = [
    {
        path: '/login',
        component: Login,
        meta: {
            forGuest: true
        }
    },
    {
        path: '/welcome',
        component: Welcome,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/paises',
        component: PaisIndex,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/estados',
        component: EstadoIndex,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/cidades',
        component: CidadeIndex,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/marcas',
        component: MarcaIndex,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/marcas/create',
        component: MarcaForm,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/marcas/:id/edit',
        component: MarcaForm,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/proprietarios',
        component: ProprietarioIndex,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/proprietarios/create',
        component: ProprietarioForm,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/proprietarios/:id/edit',
        component: ProprietarioForm,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/proprietarios/:id',
        component: ProprietarioShow,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/veiculos',
        component: VeiculoIndex,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/veiculos/create',
        component: VeiculoForm,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/veiculos/:id/edit',
        component: VeiculoForm,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/veiculos/:id',
        component: VeiculoShow,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/perfis',
        component: PerfilIndex,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/perfis/create',
        component: PerfilForm,
        meta: {
            forAuth: true
        }
    },
    {
        path: '/perfis/:id/edit',
        component: PerfilForm,
        meta: {
            forAuth: true
        }
    },
    {
        path: '*',
        component: Login,
        meta: {
            forGuest: true
        }
    }
];