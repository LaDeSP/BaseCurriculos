import utils from './utilsVue'

export default { 
  install(Vue){
    Vue.mixin(utils)
  }
}