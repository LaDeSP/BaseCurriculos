import axios from 'axios';
import VueRouter from 'vue-router';

//const token = localStorage.getItem('token');
//axios.defaults.headers.common['Authorization'] = token;

import Login from './components/Auth/Login.vue';
import Logout from './components/Auth/Logout.vue';

import NewJuridica from './components/Auth/NewJuridica.vue';
import NewFisica from './components/Auth/NewFisica.vue';
import NewCurriculo from  './components/Create/NewCurriculo.vue';
import NewJuridicaData from  './components/Create/NewJuridicaData.vue';
import NewArea from  './components/Create/NewArea.vue';
import NewVaga from  './components/Create/NewVaga.vue';
import NewAgenda from  './components/Create/NewAgenda.vue';

import Vagas from  './components/Lists/Vagas.vue';
import FisicaData from  './components/Lists/FisicaData.vue';
import JuridicaData from  './components/Lists/JuridicaData.vue';
import Candidatura from  './components/Lists/Candidatura.vue';
import DashFIS from './components/Dashboards/DashFisica.vue';
import DashJUR from './components/Dashboards/DashJuridica.vue';

import DeuRuim from './components/DeuRuim.vue';

import Home from './components/Home/Home.vue';

import Sobre from './components/Home/Sobre.vue';
import { store } from './store/store';

const routes = [
    {path: '', name:'home', component: Home, meta:{isHome: true}},
    {path: '/sobre', component: Sobre,meta:{isHome:true}},
    {path: '/login', name: 'login', component: Login, meta:{isHome:true}},
    {path: '/logout', name: 'logout', component: Logout},
    {path: '/new-juridica', component: NewJuridica},
    {path: '/new-fisica', component: NewFisica},
    {path: '/new-curriculo', name: 'new-curriculo', component: NewCurriculo},
    {path: '/new-agenda', name: 'new-agenda', component: NewAgenda},
    {path: '/add-juridica', name: 'add-juridica', component: NewJuridicaData},
    {path: '/new-area', component: NewArea},
    {path: '/new-vaga', name: 'new-vaga', component: NewVaga},
    {path: '/vagas', component: Vagas},
    {path: '/profile-fisica', component: FisicaData},
    {path: '/profile-juridica', component: JuridicaData},
    {path: '/profile-juridica', component: JuridicaData},
    {path: '/candidaturas', name: 'candidaturas', component: Candidatura},
    {path: '/dashboard-fisica', name: 'dashboard-fisica', component: DashFIS, meta: {requiresAuth: true}},
    {path: '/dashboard-juridica', name: 'dashboard-juridica', component: DashJUR, meta: {requiresAuth: true}},
    {path: '*', component: DeuRuim}

];

const router = new VueRouter({mode: 'history', routes: routes});

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)){
    if(store.getters.isLoggedIn){
      next()
      return
    }
    next('/')
  }else{
    next()
  }
})


/*router.beforeEach((to, from, next) => {
    if(to.meta.requiresAuth){
      const authUser = localStorage.getItem('role')
      if(!authUser || !authUser.token){
        next({name: 'login'})
      }else if(to.meta.adminAuth){
        const authUser = localStorage.getItem('role')
        if(authUser.data.role === 'ADMIN'){
          next()
        }else{
          next({name: 'login'})
        }
      }else if(to.meta.coorAuth){
        const authUser = localStorage.getItem('role')
        if(authUser.data.role === 'COORDENADOR'){
          next()
        }else{
          next({name: 'login'})
        }
      }else if(to.meta.superAuth){
        const authUser = localStorage.getItem('role')
        if(authUser.data.role === 'SUPERVISOR'){
          next()
        }else{
          next({name: 'login'})
        }
      }else if(to.meta.aluAuth){
        const authUser = localStorage.getItem('role')
        if(authUser.data.role === 'ALUNO'){
          next()
        }else{
          next({name: 'login'})
        }
      }
    }else{
      next()
    }
})

*/

export default router

