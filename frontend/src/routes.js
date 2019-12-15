import axios from 'axios';
import VueRouter from 'vue-router';
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
import Profile from './components/Lists/Profile.vue';
import FisicaData from  './components/Lists/FisicaData.vue';
import JuridicaData from  './components/Lists/JuridicaData.vue';
import Candidatura from  './components/Lists/Candidatura.vue';
import Agenda from  './components/Lists/Agenda.vue';

const Dashboard = () => import('./components/Dashboards/Dashboard.vue');

import DashFIS from './components/Dashboards/DashFisica.vue';
import DashJUR from './components/Dashboards/DashJuridica.vue';

import DeuRuim from './components/DeuRuim.vue';

import Home from './components/Home/Home.vue';

import Sobre from './components/Home/Sobre.vue';

import { store } from './store/store';

import Buscas from './components/Lists/Buscas'
import ContaDesativada from './components/Auth/ContaDesativada.vue';

import Config from './components/Lists/Config.vue';

import Convites from './components/Lists/Convites.vue';
import Refresh from './components/Auth/Refresh.vue'

const routes = [
    {path: '', name:'home', component: Home, meta:{isHome: true, requiresNotAuth: true}},
    {path: '/sobre', component: Sobre,meta:{isHome:true}},
    {path: '/login', name: 'login', component: Login, meta:{isHome:true, requiresNotAuth:true}},
    {path: '/logout', name: 'logout', component: Logout, meta: {requiresAuth: true}},
    {path: '/new-juridica', name:'cadastro-juridica', component: NewJuridica, meta: {requiresNotAuth: true}},
    {path: '/new-fisica', name:'cadastro-fisica', component: NewFisica, meta: {requiresNotAuth: true}},
    {path: '/new-curriculo', name: 'new-curriculo', component: NewCurriculo,  meta: {requiresAuthFisica: true}},
    {path: '/new-agenda', name: 'new-agenda', component: NewAgenda,  meta: {requiresAuthJuridica: true}},
    {path: '/add-juridica', name: 'add-juridica', component: NewJuridicaData,  meta: {requiresAuthJuridica: true}},
    {path: '/new-area', component: NewArea},
    {path: '/new-vaga', name: 'new-vaga', component: NewVaga,  meta: {requiresAuthJuridica: true}},
    {path: '/vagas', name: 'vagas', component: Vagas,  meta: {requiresAuth: true}},
    {path: '/profile', name: 'profile', component: Profile, meta: {requiresAuth: true}},
    {path: '/profile-fisica', name: 'profile-fisica', component: FisicaData, meta: {requiresAuthFisica: true}},
    {path: '/profile-juridica', name: 'profile-juridica', component: JuridicaData, meta: {requiresAuthJuridica: true}},
    {path: '/candidaturas', name: 'candidaturas', component: Candidatura, meta: {requiresAuth: true}},
    {path: '/dashboard', name: 'dashboard', component: Dashboard, meta: {requiresAuth: true}},
    {path: '/dashboard-fisica', name: 'dashboard-fisica', component: DashFIS, meta: {requiresAuthFisica: true}},
    {path: '/dashboard-juridica', name: 'dashboard-juridica', component: DashJUR, meta: {requiresAuthJuridica: true}},
    {path: '/buscas', name: 'buscas', component: Buscas, meta: {requiresAuth: true}},
    {path: '/agenda', name: 'agenda', component: Agenda, meta: {requiresAuth: true}},
    {path: '/agenda/:id', component: NewAgenda, props: true, meta: {requiresAuth: true}},
    {path: '/reativar', name: 'conta-desativada', component: ContaDesativada, meta:{isDesativada: true}},
    {path: '/config', name: 'config', component: Config, meta:{requiresAuth: true}},
    {path: '/convites', name: 'convites', component: Convites, meta:{requiresAuth: true}},
    {path: '/refresh', component: Refresh},
    {path: '*', component: DeuRuim}

];


/*

let subscribers = [];

axios.interceptors.response.use(response => {
  return response;
}, err => {
  const {
    config, 
    response: {status, data}
  } = err;

  const originalRequest = config;

  if(data.message === 'Error fetching Token'){
    router.push({name: 'login'});
    return Promise.reject(false);
 }

  if(status === 401 && data.message === 'Token Expired'){
    if(!isRefreshing) {
      isRefreshing = true;
      store.dispatch("refreshToken")
      .then(({status}) => {
        if(status === 200 || status === 204){
          isRefreshing = false;
          subscribers = [];
        }
      })
      .catch(error => {
        console.error(error);
      });
    }

    const requestSubscribers = new Promise(resolve => {
      subscribeTokenRefresh(() => {
        resolve(axios(originalRequest));
      });
    });

    onRefreshed();
    
    return requestSubscribers;
  }
 
});

function subscribeTokenRefresh(cb){
  subscribers.push();
}

function onRefreshed(){
  subscribers.map(cb => cb());
}

subscribers = [];
*/
const router = new VueRouter({mode: 'history', routes: routes});

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)){
    if(store.getters.isLoggedIn){
      next()
      return
    }
    next('/')
  }
  else if(to.matched.some(record => record.meta.requiresNotAuth)){
    if(store.getters.isLoggedIn){
      next('/dashboard')
      return
    }
    next()
  }
  else if(to.matched.some(record => record.meta.requiresAuthJuridica)){
    if(store.getters.isLoggedIn && store.getters.typeUser==='JURIDICA'){
      next()
      return
    }
    if(store.getters.isLoggedIn){
      next('/dashboard')
      return
    }
    next('/')
  }
  else if(to.matched.some(record => record.meta.requiresAuthFisica)){
    if(store.getters.isLoggedIn && store.getters.typeUser==='FISICA'){
      next()
      return
    }
    if(store.getters.isLoggedIn){
      next('/dashboard')
      return
    }
    next('/')
  }
  else{
    next()
  }
})

let isRefreshingToken = store.state.isRefreshingToken;

/*axios.interceptors.response.use(response => {
  return response;
}, error => {
 
  if(error.response.status === 401 && error.response.statusText === 'Unauthorized') { 
    if(!isRefreshingToken) {
      store.commit('isRefreshingToken')
     // store.commit('logout'); //se precisar, assim que token expirar dá logout no user
      //router.push('/login');
    store.dispatch("refreshToken")
      .then((res) => {
          console.log('no inter', res);
          store.commit('isRefreshingToken')
        })
      .catch(error => {
        console.error(error);
      });
    
    }
  }
})*/



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

