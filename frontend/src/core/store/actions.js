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
  async [actionTypes.UPDATE_PESSOA_JURIDICA]({commit, state}, updatedPessoaJuridica){
    const response = await api.pessoaJuridica.updatePessoaJuridica(state, updatedPessoaJuridica)
    console.log('UPDATE_PESSOA_JURIDICA', response)
    if(response.data.updated.juridica[0].contatos_id != null){
      commit(mutationTypes.PESSOA_JURIDICA_INFO, response.data.updated.juridica[0])
      state.auth.user.name = response.data.updated.juridica[0].user.name
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
    if(response.data.juridica[0].contatos_id != null){
      commit(mutationTypes.SET_DATA_COMPLETED, true)
      commit(mutationTypes.PESSOA_JURIDICA_INFO, response.data.juridica[0])
    }
  },
  async [actionTypes.GET_CANDIDATURAS]({commit, state}){
    const response = await api.candidaturas.getCandidaturas(state)
    console.log('GET_CANDIDATURAS', response)
    let payloadCountCandidaturas = {
      'todasCandidaturas': response.data.countCandidaturas, 
      'candidaturasEmAgendamento': response.data.countCandidaturasEmAgendamento, 
      'candidaturasConfirmadas': response.data.countCandidaturasConfirmadas
    }
    if(response.data.vagasCandidaturas) {
      commit(mutationTypes.SET_VAGAS_COM_CANDIDATURAS, response.data.vagasCandidaturas)
    }
    commit(mutationTypes.SET_COUNTER_CANDIDATURAS, payloadCountCandidaturas)
    commit(mutationTypes.SET_CANDIDATURAS, response.data.candidaturas)
  },
  async [actionTypes.GET_VAGAS_RECOMENDADAS]({commit, state}){
    const response = await api.vagas.getVagasRecomendadas(state)
    commit(mutationTypes.SET_VAGAS, response.data)
  },
  async [actionTypes.GET_TODOS_CONVITES]({commit, state}){
    const response = await api.convites.getConvites(state)
    console.log('DESGRACADO')
    commit(mutationTypes.SET_CONVITES, response.data.convites)
    let payloadConvites = {
      'todosConvites': response.data.countConvites,
      'convitesAguardando': response.data.countConvitesAguardando,
      'convitesConfirmados': response.data.countConvitesConfirmados,
      'convitesNegados': response.data.countConvitesNegados 
    }
    commit(mutationTypes.SET_CONVITES, response.data.convites)
    commit(mutationTypes.SET_COUNTER_CONVITES, payloadConvites)
  },
  async [actionTypes.REQUEST_VAGA_DASH]({commit, state}, vagaPayload){
    const response = await api.candidaturas.createCandidatura(state, vagaPayload)
    commit(mutationTypes.SET_CANDIDATURAS, response.data.candidaturas)
    commit(mutationTypes.SET_VAGAS, response.data.vagas)
  },
  async [actionTypes.CANCELAR_CANDIDATURA]({commit, state}, candidaturaId){
    const response = await api.candidaturas.deleteCandidatura(state, candidaturaId)
    let payloadCancelarCandidatura = {'candidaturaId': candidaturaId, 'role': state.auth.user.role}
    commit(mutationTypes.DELETE_CANDIDATURA_CANCELADA, payloadCancelarCandidatura)
  },
  async [actionTypes.CANCELAR_AGENDAMENTO]({commit, state}, agendamentoPayload){
    const response = await api.agendamento.cancelAgendamento(state, agendamentoPayload)
  },
  async [actionTypes.CANCELAR_ENTREVISTA]({commit, state}, vagaPayload){
    const response = await api.agendamento.createCandidatura(state, vagaPayload)
  },
  async [actionTypes.CREATE_NOVO_AGENDAMENTO]({commit, state}, agendaPayload){
    const response = await api.agendamento.createAgendamento(state, agendaPayload)
    console.log('CREATE_NOVO_AGENDAMENTO', response)
    return response.data
  },
  async [actionTypes.GET_VAGAS_JURIDICAS]({commit, state}){
    const response = await api.vagas.getVagasDaPessoaJuridicaLogada(state)
    commit(mutationTypes.SET_COUNTER_VAGAS_ATIVAS, response.data.countVagas)
    commit(mutationTypes.SET_VAGAS, response.data.vagas)
    return response.data
  },
  async [actionTypes.GET_JURIDICA_USERS]({commit, state}){
    const response = await api.pessoaJuridica.getJuridicaUsers(state)
    commit(mutationTypes.JURIDICA_USERS, response.data.usersJuridica)
  },
  async [actionTypes.HANDLE_USER_STATUS]({commit, state}, payload){
    const response = await api.account.handleUserAccount(state, payload)
    commit(mutationTypes.JURIDICA_USERS, response.data[0].usersJuridica)
  },
  async [actionTypes.CREATE_NOVA_VAGA]({commit, state}, vagaData){
    const response = await api.vagas.createVaga(state, vagaData)
    return response.data
  },
  async [actionTypes.UPDATE_VAGA]({commit, state}, vagaData){
    const response = await api.vagas.updateVaga(state, vagaData)
    return response.data
  },
  async [actionTypes.UPDATE_VAGA_STATUS]({commit, state}, status){
    const response = await api.vagas.updateVagaStatus(state, status)
    commit(mutationTypes.SET_VAGAS, response.data.vagaChanged)
    return response.data
  },
  async [actionTypes.GET_AGENDA]({commit, state}, status){
    const response = await api.agendamento.getAgenda(state)
    commit(mutationTypes.SET_AGENDA, response.data.agenda)
    commit(mutationTypes.SET_COUNTER_AGENDA, response.data.countAgenda)
    return response.data
  },
  async [actionTypes.GET_PORCENTAGEM_VAGAS]({commit, state}, status){
    const response = await api.vagas.getPorcentagemVagas(state)
    commit(mutationTypes.SET_PROGRESS_BAR, response.data)
    console.log('GET_PORCENTAGEM_VAGAS', response)
    return response.data
  },
  async [actionTypes.UPDATE_USER_FISICA]({commit, state}, updatedUser){
    const response = await api.pessoaFisica.updatePessoaFisicaUser(state, updatedUser)
    console.log('UPDATE_USER_FISICA', response)
    if(!response.data.error){
      commit(mutationTypes.UPDATE_FISICA_USER_DATA, response.data)
    }
    return response.data
  },
  async [actionTypes.UPDATE_USER_JURIDICA]({commit, state}, updatedUser){
    const response = await api.pessoaJuridica.updatePessoaJuridicaUser(state, updatedUser)
    console.log('UPDATE_USER_JURIDICA', response)
    if(!response.data.error){
      commit(mutationTypes.UPDATE_JURIDICA_USER_DATA, response.data)
    }
    return response.data
  },
  async [actionTypes.GET_BUSCA_VAGAS]({commit, state}, keywords){
    const response = await api.buscas.searchVagas(state, keywords)
    console.log('GET_BUSCA_VAGAS', response)
    commit(mutationTypes.SET_RESULTADO, response.data) 
  },
  async [actionTypes.GET_BUSCA_CURRICULOS]({commit, state}, keywords){
    const response = await api.buscas.searchCurriculos(state, keywords)
    console.log('GET_BUSCA_CURRICULOS', response)
    commit(mutationTypes.SET_RESULTADO, response.data) 
  },
  async [actionTypes.CREATE_NOVO_CONVITE]({commit, state}, conviteData){
    const response = await api.convites.createConvite(state, conviteData)
    console.log('CREATE_NOVO_CONVITE', response)
    return response.data
  }
}