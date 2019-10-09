const auth_success = (state, {payload}) => {
    state.auth.status = 'success'
    state.auth.token = payload.token
    state.auth.user = payload.user
    
    console.log('auth_usccess', payload.token)
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

const newFisica = (state, {payloadFisica}) => {
    state.pessoaFisica.cpf = payloadFisica.cpf
}

const allFisicaData = (state, {payloadCurriculo}) => {
    state.auth.user.name = payloadCurriculo.nome,
    state.pessoaFisica.nascimento = payloadCurriculo.nascimento, 
    state.pessoaFisica.genero = payloadCurriculo.genero,
    state.pessoaFisica.estadoCivil = payloadCurriculo.estadoCivil,
    state.pessoaFisica.area = payloadCurriculo.area  
    state.pessoaFisica.pretensao = payloadCurriculo.pretensao  
    state.pessoaFisica.qualificacoes = payloadCurriculo.qualificacoes  
    state.pessoaFisica.historicoProfissional = payloadCurriculo.historicoProfissional  
    state.pessoaFisica.objetivos = payloadCurriculo.objetivos  
    
}

const allJuridicaData = (state, {payload}) => {
    state.auth.user.name = payload.name
      
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