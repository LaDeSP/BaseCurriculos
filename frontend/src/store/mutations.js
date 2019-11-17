const auth_success = (state, {payload}) => {
    state.auth.status = 'success'
    state.auth.token = payload.token
    state.auth.user = payload.user
    state.upload.path = payload.path

    //console.log('auth_success', payload.token)
};

const auth_error = (state) => {
    state.status = 'error'
};

const logout = (state) => {
    state.status = ''
    state.token = ''
}

const contact = (state, {payloadContact}) => {
    state.contact.celular = payloadContact.celular
    state.contact.fixo = payloadContact.fixo
    state.contact.facebook = payloadContact.facebook
    state.contact.twitter = payloadContact.twitter
    state.contact.site = payloadContact.site
    state.contact.linkedin = payloadContact.linkedin  
}

const address = (state, {payloadAddress}) => {
    state.address.rua = payloadAddress.rua
    state.address.bairro = payloadAddress.bairro
    state.address.cidade = payloadAddress.cidade
    state.address.numero = payloadAddress.numero
    state.address.complemento = payloadAddress.complemento
    state.address.cep = payloadAddress.cep
    state.address.pais = payloadAddress.pais
    state.address.estado = payloadAddress.estado
}

const allFisicaData = (state, {payloadCurriculo}) => {

    state.auth.user.name = payloadCurriculo.nome
    state.pessoaFisica.nascimento = payloadCurriculo.nascimento
    state.pessoaFisica.genero = payloadCurriculo.genero
    state.pessoaFisica.estadoCivil = payloadCurriculo.estadoCivil
    state.pessoaFisica.cpf = payloadCurriculo.cpf
    state.pessoaFisica.area.nome = payloadCurriculo.area  
    state.pessoaFisica.area.id = payloadCurriculo.area_id  
    state.pessoaFisica.pretensao = payloadCurriculo.pretensao  
    state.pessoaFisica.qualificacoes = payloadCurriculo.qualificacoes  
    state.pessoaFisica.historicoProfissional = payloadCurriculo.historicoProfissional  
    state.pessoaFisica.objetivos = payloadCurriculo.objetivos  
    state.pessoaFisica.escolaridade = payloadCurriculo.escolaridade
    
}

const allJuridicaData = (state, {payloadJuridica}) => {
    if(payloadJuridica.name != undefined){
        state.auth.user.name = payloadJuridica.name
    }

    if(payloadJuridica.cnpj != undefined){
        state.pessoaJuridica.cnpj = payloadJuridica.cnpj
        state.pessoaJuridica.ramo = payloadJuridica.ramo
    }
};

const dataCompleted = (state, dataCompleted) => {
    state.dataCompleted = dataCompleted;
}

const vagasJuridica = (state, payloadVagasJuridica) => { 
    state.vagasJuridica = payloadVagasJuridica
}

const deleteVaga = (state, payloadVagaId) => {
    let index = state.vagasJuridica.findIndex(vaga => vaga.id === payloadVagaId);
    state.vagasJuridica.splice(index, 1);
}  

const newFoto = (state, payloadPath) => {
    state.upload.path = payloadPath
}

const candidaturas = (state, payloadCandidaturas) => { 
    state.candidaturas = payloadCandidaturas
}

const vagasCandidaturas = (state, payloadVagasCandidaturas) => { 
    state.vagasCandidaturas = payloadVagasCandidaturas
}

const buscaVagas = (state, payloadBuscaVagas) => { 
    state.resultado = payloadBuscaVagas
}

const agenda = (state, payloadAgenda) => { 
    state.agenda = payloadAgenda
}

const cancelAgenda = (state, payloadAgendaId) => {
    if(payloadAgendaId.role == 'FISICA'){
        let index = state.candidaturas.findIndex(candidatura => candidatura.id === payloadAgendaId.candidatura_id);
        state.candidaturas.splice(index, 1);
    }else{
        let index = state.agenda.findIndex(agenda => agenda.id === payloadAgendaId.agenda_id);
        state.agenda.splice(index, 1);
    }
    
}  

const deleteCandidatura = (state, payloadDeleteCandidatura) => {
    if(payloadDeleteCandidatura.role == 'FISICA'){
        let index = state.candidaturas.findIndex(candidatura => candidatura.id === payloadDeleteCandidatura.candidatura_id);
        state.candidaturas.splice(index, 1);
    }else{
        let index = state.agendas.findIndex(agenda => agenda.candidatura_id === payloadDeleteCandidatura.candidatura_id);
        state.candidaturas.splice(index, 1);
    }
}

const countVagasJuridica = (state, payloadCountVagas) => {
    state.countVagas = payloadCountVagas
}

const countCandidaturas = (state, payloadCountCandidaturas) => {
    if(payloadCountCandidaturas.countCandidaturas != null){
        state.countCandidaturas = payloadCountCandidaturas.countCandidaturas
    }
    if(payloadCountCandidaturas.countCandidaturasConfirmadas != null){
        state.countCandidaturasConfirmadas = payloadCountCandidaturas.countCandidaturasConfirmadas
    }
    if(payloadCountCandidaturas.countCandidaturasAguardando != null){
        state.countCandidaturasAguardando = payloadCountCandidaturas.countCandidaturasAguardando
    }
    if(payloadCountCandidaturas.countCandidaturas && payloadCountCandidaturas.countCandidaturasConfirmadas == null){
        state.countCandidaturasAguardando = payloadCountCandidaturas
    }
   console.log('mut', payloadCountCandidaturas)
}

  export default {
    auth_success,
    auth_error,
    logout,
    contact,
    address,
    allFisicaData,
    allJuridicaData,
    dataCompleted,
    vagasJuridica,
    deleteVaga,
    newFoto,
    candidaturas,
    vagasCandidaturas,
    buscaVagas,
    agenda,
    cancelAgenda,
    deleteCandidatura,
    countVagasJuridica,
    countCandidaturas,
    
  };