const isLoggedIn = state => !!state.auth.token;
const authStatus = state => state.auth.status;
const dataCompleted = state => state.dataCompleted; 
const typeUser = state => state.auth.user.role; 

const displayPessoaFisica = state => {

  let pessoaFisica = {
    nome: state.auth.user.name,
    nascimento: state.pessoaFisica.nascimento, 
    genero: state.pessoaFisica.genero,
    estadoCivil: state.pessoaFisica.estadoCivil, 
    cpf: state.pessoaFisica.cpf, 
    celular: state.contact.celular, 
    fixo: state.contact.fixo, 
    rua: state.address.rua, 
    bairro: state.address.bairro,
    cidade: state.address.cidade, 
    numero: state.address.numero,
    complemento: state.address.complemento, 
    cep: state.address.cep, 
    pais: state.address.pais, 
    estado: state.address.estado, 
   
  }
  Object.keys(pessoaFisica).forEach((key) => (pessoaFisica[key] == null) && delete pessoaFisica[key]);
  return pessoaFisica

}

const displayPessoaJuridica = state => {

  let pessoaJuridica = {
    razao: state.auth.user.name,
    cnpj: state.pessoaJuridica.cnpj, 
    ramo: state.pessoaJuridica.ramo, 
    celular: state.contact.celular, 
    fixo: state.contact.fixo, 
    rua: state.address.rua, 
    bairro: state.address.bairro,
    cidade: state.address.cidade, 
    numero: state.address.numero,
    complemento: state.address.complemento, 
    cep: state.address.cep, 
    estado: state.address.estado, 
    linkedin: state.contact.linkedin,
    facebook: state.contact.facebook,
    twitter: state.contact.twitter,
    site: state.contact.site,
  }

  Object.keys(pessoaJuridica).forEach((key) => (pessoaJuridica[key] == null) && delete pessoaJuridica[key]);
  
  return pessoaJuridica
 
}

const displayCurriculo = state => {
  
  let curriculo = {
    objetivos: state.pessoaFisica.objetivos,
    area: state.pessoaFisica.area.nome,
    area_id: state.pessoaFisica.area.id,
    pretensao: state.pessoaFisica.pretensao,
    escolaridade: state.pessoaFisica.escolaridade,
    qualificacoes: state.pessoaFisica.qualificacoes,
    historicoProfissional: state.pessoaFisica.historicoProfissional,
    linkedin: state.contact.linkedin,
    facebook: state.contact.facebook,
    twitter: state.contact.twitter,
    site: state.contact.site,
    
  }
   
  Object.keys(curriculo).forEach((key) => (curriculo[key] == null) && delete curriculo[key]);
  
  return curriculo

}

const displayVagasJuridica = state =>{
  return state.vagasJuridica
}

const displayVagasAtivas = state => {
  let vagas = state.vagasJuridica
  let vagasAtivas = vagas.filter(vaga => {
    return vaga.status === "ATIVA";
  });
  return vagasAtivas
}

const displayVagasInativas = state =>{
  let vagas = state.vagasJuridica 
  let vagasInativas = vagas.filter(vaga => {
    return vaga.status === "INATIVA";
  });
  return vagasInativas
}

const displayVagaById = (state) => (vaga_id) => {
  
    let vagas = state.vagasJuridica;
    let vagasById = vagas.filter((vagaById) => {return vagaById.id === vaga_id})
    return vagasById
  
}

const permissaoDoUsuario = state =>{
  return state.auth.user.role
}

const displayCandidaturas = state =>{
  let candidaturas = state.candidaturas;
 /* let candidaturasFiltered = candidaturas.filter((filtered) => {
    if(filtered.agenda){
      if(filtered.status == 'ENTREVISTA CANCELADA' && filtered.agenda[0].contraproposta ==  'JURIDICA'){
        return filtered.id >= 1
      }
    }
    if(filtered){
      return filtered.status != 'ENTREVISTA CANCELADA'
    }

  })*/
  return candidaturas
}

const displayCandidaturasAguardando = state =>{
  let candidaturas = state.candidaturas;
  let candidaturasFiltered = candidaturas.filter((filtered) => {
    return filtered.status == 'AGUARDANDO'
  })
  return candidaturasFiltered
}

const displayCandidaturasEmAgendamento = state =>{
  let candidaturas = state.candidaturas;
  let candidaturasFiltered = candidaturas.filter((filtered) => {
    return filtered.status == 'EM AGENDAMENTO'
  })
  return candidaturasFiltered
}

const displayCandidaturasConfirmadas = state =>{
  let candidaturas = state.candidaturas;
  let candidaturasFiltered = candidaturas.filter((filtered) => {
    return filtered.status == 'ENTREVISTA CONFIRMADA'
  })
  return candidaturasFiltered
}


const displayCandidaturasCanceladas = state =>{
  let candidaturas = state.candidaturas;
  let candidaturasFiltered = candidaturas.filter((filtered) => {
    return filtered.status == 'ENTREVISTA CANCELADA'
  })
  return candidaturasFiltered
}


const displayCandidaturasFinalizadas = state =>{
  let candidaturas = state.candidaturas;
  let candidaturasFiltered = candidaturas.filter((filtered) => {
    return filtered.status == 'CONTRATADO' || filtered.status == 'RECUSADO'
  })
  return candidaturasFiltered
}



const displayVagasThatHaveCandidaturas = (state) => {

  let vagasCandidaturas = state.vagasCandidaturas;
  let vagasThatHaveCandidaturas = vagasCandidaturas.filter((filtered) => {
  
    if(filtered.status != 'ENTREVISTA CANCELADA' && filtered.status != 'CONTRATADO' && filtered.status != 'RECUSADO'){
      return filtered.id >= 1
    }
   
  })
  
  return vagasThatHaveCandidaturas

}

const displayCandidaturasByVaga = (state) => (vaga_id) => {
  
  let candidaturas = state.candidaturas;
  let candidaturasByVaga = candidaturas.filter((candidaturasByVaga) => {
    
    return candidaturasByVaga.vagas_id === vaga_id && candidaturasByVaga.status != 'ENTREVISTA CANCELADA' && candidaturasByVaga.status != 'CONTRATADO' && candidaturasByVaga.status != 'RECUSADO'
  })
  
  return candidaturasByVaga

}

const displayCandidatoById = (state) => (candidato_id) => {
  
  let candidaturas = state.candidaturas;
  let candidatoById = candidaturas.filter((candidatoById) => {
    return candidatoById.id === candidato_id
  })
  let deleteNull = candidatoById[0].curriculo.fisica.contato;
  Object.keys(deleteNull).forEach((key) => (deleteNull[key] == null) && delete deleteNull[key]);

  return candidatoById

}

const displayResultados = state =>{
  return state.resultado
}

const displayAgenda = (state) => {
  
  let agenda = state.agenda
  /*let agendaFiltered = agenda.filter((filtered) => {
    if(filtered.contraproposta == 'FISICA' && filtered.candidatura.status == 'ENTREVISTA CANCELADA'){
      return filtered.id >= 1
    }else{
      return filtered.candidatura.status == 'ENTREVISTA CANCELADA' 
    }

  }) */
  return agenda

}

const displayEntrevistasEmAgendamento = (state) => {
  let agenda = state.agenda
  let emAgendamento = agenda.filter((filtered) => {
    return filtered.candidatura.status == 'EM AGENDAMENTO'
  })
  return emAgendamento
}

const displayEntrevistasConfirmadas = (state) => {
  let agenda = state.agenda
  let confirmada = agenda.filter((filtered) => {
    return filtered.candidatura.status == 'ENTREVISTA CONFIRMADA'
  })
  return confirmada
}

const displayEntrevistasCanceladas = (state) => {
  let agenda = state.agenda
  let cancelada = agenda.filter((filtered) => {
    return filtered.candidatura.status == 'ENTREVISTA CANCELADA'
  })
  return cancelada
}


const displayEntrevistasFinalizadas = (state) => {
  let agenda = state.agenda
  let finalizada = agenda.filter((filtered) => {
    return filtered.candidatura.status == 'CONTRATADO' || filtered.candidatura.status == 'RECUSADO'
  })
  return finalizada
}

const displayAgendaById = (state) => (candidato_id) => {
  
  let agenda = state.agenda;

  let agendaById = agenda.filter((filtered) => {
    return filtered.candidatura_id == candidato_id
  })

  return agendaById

}

const progressBar = state =>{
  return state.progressBar
}

const displayConvites = state =>{
  return state.convites
}

const displayVagasThatHaveConvites = (state) => {

  let vagasConvites = state.vagasConvites;
  let vagasThatHaveConvites = vagasConvites.filter((filtered) => {
  
    if(filtered.status != 'RECUSOU' && filtered.status != 'ACEITOU' && filtered.status != 'AGUARDANDO'){
      return filtered.id >= 1
    }
   
  })
  
  return vagasThatHaveConvites

}

const displayConvitesByVaga = (state) => (vaga_id) => {
  
  let convites = state.convites;
  let convitesByVaga = convites.filter((convitesByVaga) => {
    
    return convitesByVaga.vagas_id === vaga_id && convitesByVaga.status != 'CANCELADO'
  })
  
  return convitesByVaga

}

const displayCandidatoByIdConvite = (state) => (candidato_id) => {
  
  let convites = state.convites;
  let candidatoById = convites.filter((candidatoById) => {
    return candidatoById.id === candidato_id
  })
  let deleteNull = candidatoById[0].curriculo.fisica.contato;
  Object.keys(deleteNull).forEach((key) => (deleteNull[key] == null) && delete deleteNull[key]);

  return candidatoById

}

const displayVagasNaoCandidatadas = (state) => (curriculo) => {
  let vagas = state.vagasJuridica;
  let candidaturas = curriculo.candidatura;
  let vagasIdDasCandidaturas = [];

  for (var i=0; i<candidaturas.length; i++){
    vagasIdDasCandidaturas.push(candidaturas[i].vagas_id);
  }
 
  let vagasNaoCandidatadas = vagas;
  Object.keys(vagasNaoCandidatadas).forEach((key) => (vagasIdDasCandidaturas.includes(vagasNaoCandidatadas[key].id)) && delete vagasNaoCandidatadas[key]);
  let vagasIdDasCandidaturasFinal = [];

  for (i=0; i<vagasNaoCandidatadas.length; i++){
    if(!(vagasNaoCandidatadas[i]==undefined)){
      vagasIdDasCandidaturasFinal.push(vagasNaoCandidatadas[i])
    }
  }

  return vagasIdDasCandidaturasFinal
}

export default {
  isLoggedIn,
  authStatus,
  dataCompleted,
  displayPessoaFisica,
  displayPessoaJuridica, 
  displayCurriculo,
  displayVagasJuridica,
  displayVagasAtivas,
  displayVagasInativas,
  displayVagaById,
  permissaoDoUsuario,
  displayCandidaturas,
  displayCandidaturasAguardando,
  displayCandidaturasEmAgendamento,
  displayCandidaturasConfirmadas,
  displayCandidaturasCanceladas,
  displayCandidaturasFinalizadas,
  displayVagasThatHaveCandidaturas,
  displayCandidaturasByVaga,
  displayResultados,
  displayCandidatoById,
  displayAgenda,
  displayEntrevistasEmAgendamento,
  displayEntrevistasConfirmadas,
  displayEntrevistasCanceladas,
  displayEntrevistasFinalizadas,
  displayAgendaById,
  progressBar,
  typeUser,
  displayConvites,
  displayVagasThatHaveConvites,
  displayConvitesByVaga,
  displayCandidatoByIdConvite,
  displayVagasNaoCandidatadas


};