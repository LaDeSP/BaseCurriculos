const tipoPermissao = state => state.auth.user.role
const getUltimasCandidaturas = state => {
  return state.candidaturas.slice(0,3)
}
const getVagasAtivas = state => {
  return state.vagas.filter(vaga => {
    return vaga.status == 'ATIVA'
  })    
}
const getVagasInativas = state => {
  return state.vagas.filter(vaga => {
    return vaga.status == 'INATIVA'
  })
}
const getCandidaturasFiltradas = state => (status) => {
  return state.candidaturas.filter(filtered => {
      return filtered.status == status
  })
}
const getCandidaturasFinalizadas = state => (status) => {
  return state.candidaturas.filter(filtered => {
    console.log('dentro', filtered)
    return filtered.status == 'CONTRATADO' || filtered.status == 'RECUSADO'
  })
}
const getAgendaById = state => (candidaturaId) => {
    let agendaById = state.agenda.filter(filtered => {
        return filtered.candidatura_id == candidaturaId
    })
    return agendaById[0]
}
const getConvitesAguardando = state => {
  return state.convites.filter(filtered => {
      return filtered.resposta == 'AGUARDANDO'
  })
}
const getVagaById = state => (vagaId) => {
  return state.vagas.filter(filtered => {
      return filtered.id == vagaId
  })
}
const getVagasThatHaveCandidaturas = state => {
  return state.vagasComCandidaturas.filter(filtered => {
    switch (filtered.status) {
      case 'AGUARDANDO':
      case 'EM AGENDAMENTO':
        return filtered
    }
  })
}
const getCandidaturasDaVaga = state => (vagaId) => {
  let candidaturas = state.candidaturas.filter(filtered => {   
    if(filtered.vagas_id == vagaId){
      switch (filtered.status) {
        case 'AGUARDANDO':
        case 'EM AGENDAMENTO':
          return filtered
      }
    }
  })
  for(let value of candidaturas){
    Object.keys(value.curriculo.fisica.contato)
    .forEach((key) => (value.curriculo.fisica.contato[key] == null) && delete value.curriculo.fisica.contato[key])
  }
  return candidaturas
}
const getAgendaFiltrada = state => (status) => {
  return state.agenda.filter(filtered => {
      return filtered.candidatura.status == status
  })
}
const getVagasThatHaveConvites = state => {
  return state.vagasComConvites.filter(filtered => {
    console.log('filtered convite', filtered)
    switch (filtered.resposta) {
      case 'AGUARDANDO':
      case 'ACEITOU':
      case 'RECUSOU':
        return filtered
    }
  })
}
const getConvitesDaVaga = state => (vagaId) => {
  let convites = state.convites.filter(filtered => {  
    if(filtered.vagas_id == vagaId){
      if(filtered.resposta != 'CANCELADO'){
        return filtered
      }
    }
  })
  for(let value of convites){
    Object.keys(value.curriculo.fisica.contato)
    .forEach((key) => (value.curriculo.fisica.contato[key] == null) && delete value.curriculo.fisica.contato[key])
  }
  return convites
}

export default {
    tipoPermissao,
    getUltimasCandidaturas,
    getVagasAtivas,
    getVagasInativas,
    getCandidaturasFiltradas,
    getCandidaturasFinalizadas,
    getAgendaById,
    getConvitesAguardando,
    getVagaById,
    getVagasThatHaveCandidaturas,
    getCandidaturasDaVaga,
    getAgendaFiltrada,
    getVagasThatHaveConvites,
    getConvitesDaVaga

}