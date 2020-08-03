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
    component: () => import(/* webpackChunkName: "Login"*/ '../views/Dashboard')
  },
  {
    path: '/juridica',
    name: 'Juridica',
    component: () => import(/* webpackChunkName: "Login"*/ '../views/Juridica')
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
