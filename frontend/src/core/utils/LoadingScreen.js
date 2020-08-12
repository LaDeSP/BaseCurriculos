import {mutationTypes} from '../constants'

export default class LoadingScreen {
    constructor(store){
        this.store = store
    }

    startLoadingScreen(){
        this.store.commit(mutationTypes.SET_LOADING_SCREEN, true)
    }

    stopLoadingScreen(){
        this.store.commit(mutationTypes.SET_LOADING_SCREEN, false)
    }
}