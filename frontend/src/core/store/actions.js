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
  async [actionTypes.CREATE_PESSOA_FISICA]({commit}, pessoaFisicaData){
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
  },
  async [actionTypes.CREATE_PESSOA_JURIDICA]({commit}, pessoaJuridicaData){
    const response = await api.pessoaJuridica.createPessoaJuridica(pessoaJuridicaData)
    return response.data
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
  async [actionTypes.COMPLETE_PESSOA_FISICA]({commit, state}, completedPessoaFisicaData){
    const response = await api.pessoaFisica.completePessoaFisicaData(completedPessoaFisicaData, state)
    if(!response.data.error){
      state.auth.user.name = response.data.username
      commit(mutationTypes.SET_DATA_COMPLETED, true)
    }
    return response.data
  },
  async [actionTypes.COMPLETE_PESSOA_JURIDICA]({commit, state}, completedPessoaJuridicaData){
    const response = await api.pessoaJuridica.completePessoaJuridicaData(state, completedPessoaJuridicaData)
    console.log('response do COMPLETE_PESSOA_JURIDICA', response)
    if(!response.data.error){
      state.auth.user.name = response.data.username
      commit(mutationTypes.SET_DATA_COMPLETED, true)
    }
    return response.data
  },
  async [actionTypes.UPDATE_PESSOA_FISICA]({commit, state}, updatedPessoaFisica){
    const response = await api.pessoaFisica.updatePessoaFisica(state, updatedPessoaFisica)
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
  },
  async [actionTypes.GET_AREAS]({state}){
    const response = await api.vagas.getAreas(state)
    return response.data 
  },
  async [actionTypes.GET_PESSOA_FISICA]({commit, state}){
    const response = await api.pessoaFisica.getPessoaFisicaData(state)
    if(response.data.curriculo.length > 0){
      commit(mutationTypes.SET_DATA_COMPLETED, true)
      commit(mutationTypes.PESSOA_FISICA_INFO, response.data.fisica[0])
      let payload = {
        curriculo: response.data.curriculo[0],
        area: {tipo: response.data.area, id: response.data.area_id}, 
        historicoProfissional: response.data.historicoProfissional
      }
      commit(mutationTypes.PESSOA_FISICA_CURRICULO, payload)
    }
    return response.data
  },
  async [actionTypes.GET_PESSOA_JURIDICA]({commit, state}){
    const response = await api.pessoaJuridica.getPessoaJuridicaData(state)
    console.log('GET_PESSOA_JURIDICA', response)
    if(response.data.juridica.contatos_id != null){
      commit(mutationTypes.SET_DATA_COMPLETED, true)
      commit(mutationTypes.PESSOA_FISICA_INFO, response.data.juridica[0])
    }
  },
  async [actionTypes.GET_CANDIDATURAS_FISICA]({commit, state}){
    const response = await api.candidaturas.getCandidaturas(state)
    commit(mutationTypes.SET_CANDIDATURAS_FISICA, response.data.candidaturas)
  },
  async [actionTypes.GET_VAGAS_RECOMENDADAS]({commit, state}){
    const response = await api.vagas.getVagasRecomendadas(state)
    commit(mutationTypes.SET_VAGAS, response.data)
  },
  async [actionTypes.GET_CONVITES]({commit, state}){
    const response = await api.convites.getConvites(state)
    commit(mutationTypes.SET_CONVITES, response.data.convites)
  },
  async [actionTypes.REQUEST_VAGA_DASH]({commit, state}, vagaPayload){
    const response = await api.candidaturas.createCandidatura(state, vagaPayload)
    commit(mutationTypes.SET_CANDIDATURAS_FISICA, response.data.candidaturas)
    commit(mutationTypes.SET_VAGAS, response.data.vagas)
  },
  async [actionTypes.CANCELAR_CANDIDATURA]({commit, state}, candidaturaId){
    const response = await api.candidaturas.deleteCandidatura(state, candidaturaId)
    console.log('CANCELAR_CANDIDATURA', response)
    let payloadCancelarCandidatura = {'candidaturaId': candidaturaId, 'role': state.auth.user.role}
    commit(mutationTypes.DELETE_CANDIDATURA_CANCELADA, payloadCancelarCandidatura)
  },
  async [actionTypes.CANCELAR_AGENDAMENTO]({commit, state}, agendamentoPayload){
    const response = await api.agendamento.cancelAgendamento(state, agendamentoPayload)
    console.log('CANCELAR_AGENDAMENTO', response)
  },
  async [actionTypes.CANCELAR_ENTREVISTA]({commit, state}, vagaPayload){
    const response = await api.agendamento.createCandidatura(state, vagaPayload)
    console.log('CANCELAR_ENTREVISTA', response)
  },
  async [actionTypes.CREATE_NOVO_AGENDAMENTO]({commit, state}, agendaPayload){
    const response = await api.agendamento.createAgendamento(state, agendaPayload)
    console.log('CREATE_NOVO_AGENDAMENTO', response)
  },
  async [actionTypes.GET_CONVITES]({commit, state}){
    const response = await api.convites.getConvites(state)
    console.log('GET_CONVITES', response)
    commit(mutationTypes.SET_CONVITES, response.data.convites)
  },
  async [actionTypes.GET_VAGAS_JURIDICAS]({commit, state}){
    const response = await api.vagas.getVagasDaPessoaJuridicaLogada(state)
    console.log('GET_VAGAS_JURIDICAS', response)
    return response.data
  },
  async [actionTypes.GET_JURIDICA_USERS]({commit, state}){
    const response = await api.pessoaJuridica.getJuridicaUsers(state)
    commit(mutationTypes.JURIDICA_USERS, response.data.usersJuridica)
    console.log('GET_JURIDICA_USERS', response)
  },
  async [actionTypes.HANDLE_USER_STATUS]({commit, state}, payload){
    const response = await api.account.handleUserAccount(state, payload)
    commit(mutationTypes.JURIDICA_USERS, response.data[0].usersJuridica)
    console.log('HANDLE_USER_STATUS', response)
  }
}