import Vue from 'vue'
import Vuex from 'vuex'
import state from './state'
import actions from './actions'
import mutations from './mutations'
import getters from './getters'
import SecureLS from 'secure-ls'
import createPersistedState from 'vuex-persistedstate'
let ls = new SecureLS({isCompression: true})

Vue.use(Vuex)

export default new Vuex.Store({
  plugins: [
    createPersistedState({
      key: 'bdc',
      paths: ['auth', 'dataCompleted', 'upload'],
      storage: {
        getItem: (key) => ls.get(key),
        setItem: (key, value) => ls.set(key, value),
        removeItem: (key) => ls.remove(key)
      }
    }),
  ],
  state, 
  getters, 
  mutations, 
  actions
})