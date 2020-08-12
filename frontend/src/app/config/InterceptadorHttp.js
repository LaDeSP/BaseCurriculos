import axios from 'axios' 
import router from '../../router' 
import store from '../../core/store'
import { NavigationUtils, LoadingScreen } from '../../core/utils'

const navigationUtils = new NavigationUtils(router),
	  loadingScreen = new LoadingScreen(store)

class InterceptadorHttp {
    async execute(){
        return new Promise((resolve) => {
            this.setInterceptadores()
           // this.setRequestHeader()
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
        loadingScreen.startLoadingScreen()
        return config
    }

    handleResponse(response){
        console.log('handle response', response)
        loadingScreen.stopLoadingScreen()
        return response
    }

    handleErrors(error){
        loadingScreen.stopLoadingScreen()
        console.error('deu ruim aqui', error)
    }
}

export default new InterceptadorHttp()