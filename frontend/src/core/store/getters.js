const tipoPermissao = state => state.auth.user.role

const getUltimasCandidaturas = state => {
    return state.candidaturasFisica.slice(0,3)
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
    return state.candidaturasFisica.filter(filtered => {
        return filtered.status == status
    })
}

const getCandidaturasFinalizadas = state => (status) => {
    return state.candidaturasFisica.filter(filtered => {
        return filtered.status == 'CONTRATADO' || filtered.status == 'RECUSADO'
    })
}

const getAgendaById = state => (candidaturaId) => {
    return state.agenda.filter(filtered => {
        return filtered.candidatura_id == candidaturaId
    })
}

const getConvitesAguardando = state => {
    return state.convites.filter(filtered => {
        return filtered.resposta == 'AGUARDANDO'
    })
}

export default {
    tipoPermissao,
    getUltimasCandidaturas,
    getVagasAtivas,
    getVagasInativas,
    getCandidaturasFiltradas,
    getCandidaturasFinalizadas,
    getAgendaById,
    getConvitesAguardando

}