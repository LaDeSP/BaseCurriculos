import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../core/store'

Vue.use(VueRouter)

  const routes = [
  {
    path: '*',
    component: () => import(/* webpackChunkName: "NotFound"*/ '../views/NotFound')
  },
  {
    path: '/error',
    component: () => import(/* webpackChunkName: "Error"*/ '../views/Error')
  },
  {
    path: '/',
    name: 'home',
    meta:{isHome: true, showOnlyIfNoAuth: true},
    component: () => import(/* webpackChunkName: "Home"*/ '../views/Home')
  },
  {
    path: '/sobre',
    name: 'sobre',
    meta: {isSobre: true, showOnlyIfNoAuth: true},
    component: () => import(/* webpackChunkName: "Sobre"*/ '../views/Sobre')
  },
  {
    path: '/login',
    name: 'login',
    meta: {isLogin: true, showOnlyIfNoAuth: true},
    component: () => import(/* webpackChunkName: "Login"*/ '../components/Auth/Login')
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "Dashboard"*/ '../views/Dashboard')
  },
  {
    path: '/juridica',
    name: 'juridica',
    component: () => import(/* webpackChunkName: "Juridica"*/ '../views/Juridica')
  },
  {
    path: '/loading',
    name: 'loadingScreen',
    component: () => import(/* webpackChunkName: "LoadingScreen"*/ '../views/LoadingScreen')
  },
  {
    path: '/profile',
    name: 'profile',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "Profile"*/ '../views/Profile')
  },
   {
    path: '/settings',
    name: 'settings',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "Settings"*/ '../components/Dashboards/Configuracoes')
  },
  {
    path: '/candidaturas',
    name: 'candidaturas',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "Candidaturas"*/ '../views/Candidaturas')
  },
  {
    path: '/vagas',
    name: 'vagas',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "Vagas"*/ '../views/Vagas'),
  },
  {
    path: '/vagas/create',
    name: 'createVaga',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "CreateVaga"*/ '../components/Forms/FormCreateVaga'),
  },
  {
    path: '/vagas/edit/:vagaId',
    name: 'editVaga',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "EditVaga"*/ '../components/Forms/FormCreateVaga'),
  },
  {
    path: '/canjur',
    name: 'canjur',
    component: () => import(/* webpackChunkName: "CandidaturasJuridica"*/ '../components/Candidaturas/CandidaturasJuridica')
  },
  {
    path: '/convites',
    name: 'convites',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "Convites"*/ '../views/Convites')
  },
  {
    path: '/agenda',
    name: 'agenda',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "Agenda"*/ '../views/Agenda'),
  },
  {
    path: '/agenda/new/:newCandidaturaId',
    name: 'newAgenda',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "NewAgenda"*/ '../components/Forms/FormNovoAgendamento'),
  },
  {
    path: '/agenda/edit/:editCandidaturaId',
    name: 'editAgenda',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "EditAgenda"*/ '../components/Forms/FormNovoAgendamento'),
  },
  {
    path: '/search',
    name: 'search',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "Resultados"*/ '../views/Resultados')
  },
  {
    path: '/new-user',
    name: 'newJuridicaUser',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "NewJuridicaUser"*/ '../components/Forms/FormCreateUserJuridica')
  },
  {
    path: '/manage-users',
    name: 'manageJuridicaUsers',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "ManageJuridicaUsers"*/ '../components/Display/ManageJuridicaUsers')
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach((to, from, next) => {
  console.log('beforeEach', store.state)
  if(to.matched.some(record => record.meta.requiresAuth)){
    if(store.state.auth.isLoggedIn){
      next()
      return
    }
    next('/')
  }else if(to.matched.some(record => record.meta.showOnlyIfNoAuth)){
    if(store.state.auth.isLoggedIn){
      next('/dashboard')
      return
    }
    next()
  }else if(to.matched.some(record => record.meta.requiresAuthJuridica)){
    if(store.state.auth.isLoggedIn && store.state.tipoPermissao ==='JURIDICA'){
      next()
      return
    }
    if(store.state.auth.isLoggedIn){
      next('/dashboard')
      return
    }
    next('/')
  }else if(to.matched.some(record => record.meta.requiresAuthFisica)){
    if(store.state.auth.isLoggedIn && store.state.tipoPermissao ==='FISICA'){
      next()
      return
    }
    if(store.state.auth.isLoggedIn){
      next('/dashboard')
      return
    }
    next('/')
  }else{
    next()
  }
})

export default router
