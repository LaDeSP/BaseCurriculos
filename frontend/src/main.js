import Vue from 'vue'
import router from './routes.js'
import VueRouter from 'vue-router';
import VueFilterDateFormat from 'vue-filter-date-format'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueSession from 'vue-session'
import { store } from './store/store'
import './assets/validations';


Vue.use(VueFilterDateFormat)
Vue.use(VueRouter);
Vue.use(VueSession)
Vue.use(VueAxios, axios)

new Vue({
  store: store, 
  el: '#app',
  router: router,
  render: h => h(App)
})
