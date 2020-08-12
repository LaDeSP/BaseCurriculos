import {actionTypes, mutationTypes} from '../constants'
import router from '@/router'
import api from '../api'
import {NavigationUtils} from '@/core/utils'

const navigationUtils = new NavigationUtils(router)

export default {
  async [actionTypes.LOGIN]({commit}, user){
    const response = await api.auth.login(user)
    const payload = {
      'path': response.data.foto, 
      'token': response.data.token,
      'user': response.data.user
    }
    if(!response.data.error){
      commit(mutationTypes.LOGIN, payload)
      commit(mutationTypes.TIPO_PERMISSAO, response.data.user.role)
    }
    return response.data
  },
  async [actionTypes.LOGOUT]({commit, state}){
    let logout = await api.auth.logout(state)
    commit(mutationTypes.LOGOUT)
    commit(mutationTypes.SET_DATA_COMPLETED, false)
  },
  async [actionTypes.CREATE_PESSOA_FISICA]({commit, dispatch}, pessoaFisicaData){
    const response = await api.pessoaFisica.createPessoaFisica(pessoaFisicaData)
    const payload = {
        'path': response.data.foto, 
        'token': response.data.token,
        'user': response.data.user
      }
      if(!response.data.error){
        commit(mutationTypes.LOGIN, payload)
        commit(mutationTypes.TIPO_PERMISSAO, response.data.user.role)
      }
      return response.data
    //await dispatch(actionTypes.LOGIN, response)
  },
  async [actionTypes.CREATE_PESSOA_JURIDICA]({commit, dispatch}, pessoaJuridicaData){
    const response = await api.pessoaFisica.createPessoaFisica(pessoaJuridicaData)
    const payload = {
        'path': response.data.foto, 
        'token': response.data.token,
        'user': response.data.user
      }
      if(!response.data.error){
        commit(mutationTypes.LOGIN, payload)
        commit(mutationTypes.TIPO_PERMISSAO, response.data.user.role)
      }
      return response.data
    //await dispatch(actionTypes.LOGIN, response)
  },
  async [actionTypes.UPDATE_USER_PIC]({commit, state}){
    const response = await api.foto.updateUserPic(state)
    let picPath = response.data.foto 
    commit(mutationTypes.SET_NEW_USER_PIC, picPath)
    console.log('commit update user pic feito', state.upload)
  },
  async [actionTypes.DELETE_USER_PIC]({commit, state}){
    const response = await api.foto.deleteUserPic(state)
    let picPath = response.data.foto 
    commit(mutationTypes.SET_NEW_USER_PIC, picPath)
  },
  async [actionTypes.GET_AREAS]({state}){
    const response = await api.vagas.getAreas(state)
    return response.data 
  },
  async [actionTypes.COMPLETE_PESSOA_FISICA]({commit, state}, completedPessoaFisicaData){
    const response = await api.pessoaFisica.completePessoaFisicaData(completedPessoaFisicaData, state)
    if(!response.data.error){
      commit(mutationTypes.SET_DATA_COMPLETED, true)
    }
    return response.data
  },
  async [actionTypes.COMPLETE_PESSOA_JURIDICA]({commit}, completedPessoaJuridicaData){
    const response = await api.pessoaJuridica.completePessoaJuridicaData(completedPessoaJuridicaData)
    commit(mutationTypes.SET_CONTATO, contatoPayload)
    commit(mutationTypes.SET_ENDERECO, enderecoPayload)
    commit(mutationTypes.COMPLETE_JURIDICA_DATA, pessoaJuridicaPayload)
    //QUASE CERTEZA DE QUE NAO PRECISO DE TUDO ISSO, SO PRECISO DE DATA COMPLETED...
    commit(mutationTypes.SET_DATA_COMPLETED)
    return response
  },
  async [actionTypes.GET_PESSOA_FISICA]({commit, state}){
    const response = await api.pessoaFisica.getPessoaFisicaData(state)
    if(response.data.curriculo.length > 0){
      commit(mutationTypes.SET_DATA_COMPLETED, true)
      commit(mutationTypes.PESSOA_FISICA_INFO, response.data.fisica[0])
      let payload = {
        curriculo: response.data.curriculo[0],
        area: {tipo: response.data.area, id: response.data.area_id}
      }
      commit(mutationTypes.PESSOA_FISICA_CURRICULO, payload)
    }
    return response.data
  },
  async [actionTypes.UPDATE_PESSOA_FISICA]({commit, state}, updatedPessoaFisica){
    console.log('payload pro UPDATE_PESSOA_FISICA', updatedPessoaFisica)
    const response = await api.pessoaFisica.updatePessoaFisica(state, updatedPessoaFisica)
    console.log('UPDATE_PESSOA_FISICA', response)
    if(response.data.curriculo.length > 0){
      commit(mutationTypes.PESSOA_FISICA_INFO, response.data.fisica[0])
      state.auth.user.name = response.data.fisica.user.name
      let payload = {
        curriculo: response.data.curriculo[0],
        area: {tipo: response.data.area, id: response.data.area_id}
      }
      commit(mutationTypes.PESSOA_FISICA_CURRICULO, payload)
    }
    return response.data
  }
}