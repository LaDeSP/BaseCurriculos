const auth_success = (state, {payload}) => {
    state.auth.status = 'success'
    state.auth.token = payload.token
    state.auth.user = payload.user
    
    /*DEPOIS VEJO SE VOU PRECISAR DISSO 
    if(payload.user.role === 'FISICA'){
        state.pessoaFisica.cpf = payload.cpf
    }else{
        state.pessoaJuridica.cnpj = payload.cnpj
        state.pessoaJuridica.ramo = payload.ramo
    }*/

    console.log('auth_success', payload.token)
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
    state.pessoaFisica.estadoCivil = payloadCurriculo.estadoCivil,
    state.pessoaFisica.cpf = payloadCurriculo.cpf
    state.pessoaFisica.area = payloadCurriculo.area  
    state.pessoaFisica.pretensao = payloadCurriculo.pretensao  
    state.pessoaFisica.qualificacoes = payloadCurriculo.qualificacoes  
    state.pessoaFisica.historicoProfissional = payloadCurriculo.historicoProfissional  
    state.pessoaFisica.objetivos = payloadCurriculo.objetivos  
    state.pessoaFisica.dataCompleted = payloadCurriculo.dataCompleted

    console.log('statefisica', state.pessoaFisica)
    
}

const allJuridicaData = (state, {payloadJuridica}) => {
    if(payloadJuridica.name != undefined){
        state.auth.user.name = payloadJuridica.name
    }
    
    state.pessoaJuridica.dataCompleted = payloadJuridica.dataCompleted

    if(payloadJuridica.cnpj != undefined){
        state.pessoaJuridica.cnpj = payloadJuridica.cnpj
        state.pessoaJuridica.ramo = payloadJuridica.ramo
    }
};
  
  export default {
    auth_success,
    auth_error,
    logout,
    contact,
    address,
    allFisicaData,
    allJuridicaData,
  };