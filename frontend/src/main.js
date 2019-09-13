import Vue from 'vue'
import VueRouter from 'vue-router';
import VueFilterDateFormat from 'vue-filter-date-format'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueSession from 'vue-session'
import { extend } from 'vee-validate';
import { required, email } from 'vee-validate/dist/rules';
import { ValidationProvider } from 'vee-validate';

extend('required', {
  ...required,
  message: 'This field is required'
});
extend('email', {...email, message: 'Email válido please'} );
extend('secret', {
  validate: value => value === 'example',
  message: 'This is not the magic word'
});
Vue.component('ValidationProvider', ValidationProvider);

Vue.use(VueFilterDateFormat)
Vue.use(VueRouter);
Vue.use(VueSession)
Vue.use(VueAxios, axios)
const token = localStorage.getItem('token');
axios.defaults.headers.common['Authorization'] = token;

import App from './App.vue'
import Login from './components/Auth/Login.vue';
import Logout from './components/Auth/Logout.vue';

import NewJuridica from './components/Auth/NewJuridica.vue';
import NewFisica from './components/Auth/NewFisica.vue';
import NewCurriculo from  './components/Create/NewCurriculo.vue';
import NewJuridicaData from  './components/Create/NewJuridicaData.vue';
import NewArea from  './components/Create/NewArea.vue';
import NewVaga from  './components/Create/NewVaga.vue';

import Vagas from  './components/Lists/Vagas.vue';
import FisicaData from  './components/Lists/FisicaData.vue';


import DeuRuim from './components/DeuRuim.vue';

const routes = [
    {path: '', component: Login},
    {path: '/login', name: 'login', component: Login},
    {path: '/logout', name: 'logout', component: Logout},
    //CADASTROS
    {path: '/new-juridica', component: NewJuridica},
    {path: '/new-fisica', component: NewFisica},
    {path: '/new-curriculo', name: 'new-curriculo', component: NewCurriculo},
    {path: '/add-juridica', component: NewJuridicaData},
    {path: '/new-area', component: NewArea},
    {path: '/new-vaga', name: 'new-vaga', component: NewVaga},
    {path: '/vagas', component: Vagas},
    {path: '/profile-fisica', component: FisicaData},
    {path: '*', component: DeuRuim}
];

const router = new VueRouter({mode: 'history', routes: routes});


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

new Vue({
  el: '#app',
  router: router,
  render: h => h(App)
})
