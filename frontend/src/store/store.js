import Vuex from 'vuex';
import Vue from 'vue';
import createPersistedState from 'vuex-persistedstate'
import * as Cookies from 'js-cookie'

import actions from './actions';
import getters from './getters';
import mutations from './mutations';

Vue.use(Vuex);

export const store = new Vuex.Store({
  plugins: [
    createPersistedState({
      paths: ['auth'],
      storage: {
        getItem: key => Cookies.get(key),
        setItem: (key, value) =>
          Cookies.set(key, value, { expires: 3, secure: false }),
        removeItem: key => Cookies.remove(key),
      },
    }),
  ],
  state: {
   auth: {
     status: '',
     token: '',
     user: {}
   },
   pessoaFisica: {

    nascimento: '',
    genero: '',
    rua: '',
    bairro: '',
    cidade: '',
    cep: '',
    celular: '',
    fixo: '',
    facebook: '',
    twitter: '',
    linkedin:'',
    site: '',
    outraRede: '',
    objetivos: '',
    area: '',
    pretensao: '',
    qualificacoes: '',
    historicoProfissional: '',
    emailAlt: '',
    estadoCivil: '',
    pais: '',
    estado: '',
    escolaridade: '',
   },
   pessoaJuridica: {
    name: '',
    rua: '',
    bairro: '',
    cidade: '',
    cep: '',
    celular: '',
    fixo: '',
    facebook: '',
    twitter: '',
    site: '',
    outraRede: '',
    pais: '',
    estado: '',
    linkedin: '',
   }
  },

  actions,
  getters,
  mutations,
});