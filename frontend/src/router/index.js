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
    path: '/profile',
    name: 'profile',
    meta: {requiresDataCompleted: true},
    component: () => import(/* webpackChunkName: "Profile"*/ '../views/Profile')
  },
   {
    path: '/settings',
    name: 'settings',
    meta: {requiresDataCompleted: true},
    component: () => import(/* webpackChunkName: "Settings"*/ '../components/Dashboards/Configuracoes')
  },
  {
    path: '/candidaturas',
    name: 'candidaturas',
    meta: {requiresDataCompleted: true},
    component: () => import(/* webpackChunkName: "Candidaturas"*/ '../views/Candidaturas')
  },
  {
    path: '/vagas',
    name: 'vagas',
    meta: {requiresAuthJuridica: true},
    component: () => import(/* webpackChunkName: "Vagas"*/ '../views/Vagas'),
  },
  {
    path: '/vagas/create',
    name: 'createVaga',
    meta: {requiresAuthJuridica: true},
    component: () => import(/* webpackChunkName: "CreateVaga"*/ '../components/Forms/FormCreateVaga'),
  },
  {
    path: '/vagas/edit/:vagaId',
    name: 'editVaga',
    meta: {requiresAuthJuridica: true},
    component: () => import(/* webpackChunkName: "EditVaga"*/ '../components/Forms/FormCreateVaga'),
  },
  {
    path: '/convites',
    name: 'convites',
    meta: {requiresDataCompleted: true},
    component: () => import(/* webpackChunkName: "Convites"*/ '../views/Convites')
  },
  {
    path: '/agenda',
    name: 'agenda',
    meta: {requiresAuthJuridica: true},
    component: () => import(/* webpackChunkName: "Agenda"*/ '../views/Agenda'),
  },
  {
    path: '/agenda/new/:newCandidaturaId',
    name: 'newAgenda',
    meta: {requiresAuthJuridica: true},
    component: () => import(/* webpackChunkName: "NewAgenda"*/ '../components/Forms/FormNovoAgendamento'),
  },
  {
    path: '/agenda/edit/:editCandidaturaId',
    name: 'editAgenda',
    meta: {requiresDataCompleted: true},
    component: () => import(/* webpackChunkName: "EditAgenda"*/ '../components/Forms/FormNovoAgendamento'),
  },
  {
    path: '/search',
    name: 'search',
    meta: {requiresDataCompleted: true},
    component: () => import(/* webpackChunkName: "Resultados"*/ '../views/Resultados')
  },
  {
    path: '/new-user',
    name: 'newJuridicaUser',
    meta: {requiresAuthMaster: true},
    component: () => import(/* webpackChunkName: "NewJuridicaUser"*/ '../components/Forms/FormCreateUserJuridica')
  },
  {
    path: '/accountStatus',
    name: 'accountStatus',
    meta: {requiresInactiveAccount: true},
    component: () => import(/* webpackChunkName: "AccountStatus"*/ '@/views/AccountStatus')
  },
  { 
    path: '/reset-password', 
    name: 'reset-password', 
    component: () => import(/* webpackChunkName: "AccountStatus"*/ '@/views/ForgotPassword'),
    meta: {showOnlyIfNoAuth: true} 
  },
  { 
    path: '/reset-password/:token', 
    name: 'reset-password-form', 
    component: () => import(/* webpackChunkName: "AccountStatus"*/ '@/views/ResetPasswordForm'),
    meta: {showOnlyIfNoAuth: true}
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
      if(store.state.auth.user.deleted_at == null){
        next()
        return
      }else{
        console.log('deleted not null')
        next('/accountStatus')
      }
    }else{
      console.log('not logged in')
      next('/')
    } 
  }else if(to.matched.some(record => record.meta.requiresDataCompleted)){
    if(store.state.auth.isLoggedIn){
      if(store.state.auth.user.deleted_at == null){
        if(store.state.dataCompleted){
          console.log('deleted null e dataCompleted true')
          next()
          return
        }else{
          console.log('data completed false')
          next('/dashboard')
        }
      }else{
        console.log('deleted not null')
        next('/accountStatus')
      }
    }else{
      next('/')
    }
  }else if(to.matched.some(record => record.meta.showOnlyIfNoAuth)){
    if(store.state.auth.isLoggedIn){
      next('/dashboard')
      return
    }
    next()
  }else if(to.matched.some(record => record.meta.requiresInactiveAccount)){
    if(store.state.auth.isLoggedIn){
      if(store.state.auth.user.deleted_at != null){
        next()
      }else{
        next('/dashboard')
      }
    }else{
      next('/')
    }
  }else if(to.matched.some(record => record.meta.requiresAuthMaster)){
    if(store.state.auth.isLoggedIn && store.state.auth.user.role === 'MASTER'){
      next()
      return
    }
    if(store.state.auth.isLoggedIn){
      next('/dashboard')
      return
    }
    next('/')
  }else if(to.matched.some(record => record.meta.requiresAuthJuridica)){
    console.log('isloggedin', store.state.auth.isLoggedIn, 'tipo', store.state.auth.user.role, 'data', store.state.dataCompleted)
    if(store.state.auth.isLoggedIn && store.state.auth.user.role ==='JURIDICA' && store.state.dataCompleted){
      next()
      return
    }
    if(store.state.auth.isLoggedIn){
      next('/dashboard')
      return
    }
    next('/')
  }else if(to.matched.some(record => record.meta.requiresAuthFisica)){
    if(store.state.auth.isLoggedIn && store.state.auth.user.role ==='FISICA' && store.state.dataCompleted){
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
