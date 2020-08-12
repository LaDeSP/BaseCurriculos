import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../core/store'

Vue.use(VueRouter)

  const routes = [
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
    component: () => import(/* webpackChunkName: "Vagas"*/ '../views/Vagas')
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
    children: [
      { path: 'new', 
        name: 'new',
        component: () => import(/* webpackChunkName: "Agenda"*/ '../components/Forms/FormNovoAgendamento')
      }
    ]
  },
  {
    path: '/search',
    name: 'search',
    meta: {requiresAuth: true},
    component: () => import(/* webpackChunkName: "Convites"*/ '../views/Resultados')
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach((to, from, next) => {
  console.log('beforeEach', store.state, store.getters)
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
