import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './core/store'
import vuetify from './plugins/vuetify'
import VueFilterDateFormat from 'vue-filter-date-format'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueFormWizard from 'vue-form-wizard'
import config from './app/config'
import './assets/validations'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import './styles/variables.scss'
//import '../css/app.css'

axios.defaults.baseURL = 'http://localhost:8000/api/'
Vue.config.productionTip = false
Vue.use(VueFilterDateFormat)
Vue.use(VueFormWizard)
Vue.use(VueAxios, axios)

new Vue({
  router,
  store,
  vuetify,
  async created(){
    await config.interceptadorHttp.execute()
  }, 
  render: h => h(App)
}).$mount('#app')
