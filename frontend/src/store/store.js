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
      paths: ['auth', 'dataCompleted', 'upload'],
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
      linkedin: '',
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
      area: {
        nome: '',
        id: 0,
      },
      pretensao: '',
      qualificacoes: '',
      historicoProfissional: '',
      escolaridade: '',
     
   },
   pessoaJuridica: {
      cnpj: '',
      ramo: '',
   },
   upload:{
     path: '',
   },
   vagasJuridica: [],
   candidaturas: [],
   vagasCandidaturas: [],
   progressBar: [],
   vagasConvites: [],
   dataCompleted: false,
   hasVaga: false,
   count: {},
   countConvites: {}, 
   countVagas: 0,
   countAgenda: 0,
   resultado: [],
   agenda: [],
   convites: [],
   isFetching: true,
   
  },

  actions,
  getters,
  mutations,
});