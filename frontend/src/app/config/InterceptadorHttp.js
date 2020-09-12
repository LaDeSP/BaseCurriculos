import axios from 'axios'
import router from '../../router'
import store from '../../core/store'
import {mutationTypes} from '@/core/constants'
import { NavigationUtils, LoadingScreen } from '../../core/utils'

const navigationUtils = new NavigationUtils(router),
      loadingScreen = new LoadingScreen(store)

class InterceptadorHttp {
  async execute(){
    return new Promise((resolve) => {
      this.setInterceptadores()
      this.setRequestHeader()
      resolve()
    })
  }

  setInterceptadores(){
    axios.interceptors.request.use(this.handleRequest, this.handleErrors)
    axios.interceptors.response.use(this.handleResponse, this.handleErrors)
  }

  setRequestHeader(){
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
  }

  handleRequest(config){
    console.log('handle request', config)
    if(config.method == 'get'){
      loadingScreen.startLoadingScreen()
    }
    return config
  }

  handleResponse(response){
    console.log('handle response', response)
    if(response.config.method == 'get'){
      loadingScreen.stopLoadingScreen()
    }
    return response
  }

  handleErrors(error){
    loadingScreen.stopLoadingScreen()
    console.log('deu ruim aqui', error.response)
    let errorPayload = {
        "status": error.response.status,
        "statusText": error.response.statusText,
        "errorData": error.response.data
    }
    if(errorPayload.status == 401){
        store.commit(mutationTypes.LOGOUT)
    }
    navigationUtils.goToError(errorPayload)
  }
}

export default new InterceptadorHttp()
