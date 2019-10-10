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
   contact: {
      celular: '',
      fixo: '',
      facebook: '',
      twitter: '',
      linkedin:'',
      site: '',
   },
   address: {
      rua: '',
      bairro: '',
      cidade: '',
      cep: '',
      pais: '',
      estado: '',
   },
   pessoaFisica: {
      cpf: '',
      nascimento: '',
      genero: '',
      estadoCivil: '',
      objetivos: '',
      area: '',
      pretensao: '',
      qualificacoes: '',
      historicoProfissional: '',
      escolaridade: '',
   },
   pessoaJuridica: {
      cnpj: '',
      ramo: '',
      dataCompleted: false,
   }
  },

  actions,
  getters,
  mutations,
});