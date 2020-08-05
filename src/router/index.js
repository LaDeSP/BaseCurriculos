import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

  const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import(/* webpackChunkName: "Home"*/ '../views/Home'),
    meta: {isHome: true}
  },
  {
    path: '/sobre',
    name: 'Sobre',
    component: () => import(/* webpackChunkName: "Sobre"*/ '../views/Sobre'),
    meta: {isSobre: true}
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import(/* webpackChunkName: "Login"*/ '../components/Auth/Login'),
    meta: {isLogin: true}
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import(/* webpackChunkName: "Dashboard"*/ '../views/Dashboard')
  },
  {
    path: '/juridica',
    name: 'Juridica',
    component: () => import(/* webpackChunkName: "Juridica"*/ '../views/Juridica')
  },
  {
    path: '/loading',
    name: 'LoadingScreen',
    component: () => import(/* webpackChunkName: "LoadingScreen"*/ '../views/LoadingScreen')
  },
  {
    path: '/profile',
    name: 'Profile',
    component: () => import(/* webpackChunkName: "Profile"*/ '../views/Profile')
  },
   {
    path: '/settings',
    name: 'Settings',
    component: () => import(/* webpackChunkName: "Settings"*/ '../components/Dashboards/Configuracoes')
  },
  {
    path: '/candidaturas',
    name: 'Candidaturas',
    component: () => import(/* webpackChunkName: "Candidaturas"*/ '../views/Candidaturas')
  },
  {
    path: '/vagas',
    name: 'Vagas',
    component: () => import(/* webpackChunkName: "Vagas"*/ '../views/Vagas')
  },
  {
    path: '/canjur',
    name: 'canjur',
    component: () => import(/* webpackChunkName: "Vagas"*/ '../components/Candidaturas/CandidaturasJuridica')
  },
  {
    path: '/convites',
    name: 'convites',
    component: () => import(/* webpackChunkName: "Vagas"*/ '../views/Convites')
  },
  {
    path: '/agenda',
    name: 'agenda',
    component: () => import(/* webpackChunkName: "Vagas"*/ '../views/Agenda'),
    children: [
      {
        path: 'new',
        name: 'new-agenda',
        component: () => import(/* webpackChunkName: "Vagas"*/ '../components/Forms/FormNovoAgendamento'),
      }
    ]
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
