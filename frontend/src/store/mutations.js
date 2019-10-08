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
};

const allFisicaData = (state, {payload}) => {

}

const allJuridicaData = (state, {payload}) => {
    state.pessoaJuridica.name = payload.name
    state.pessoaJuridica.rua = payload.rua
    state.pessoaJuridica.bairro = payload.bairro
    state.pessoaJuridica.cidade = payload.cidade
    state.pessoaJuridica.cep = payload.cep
    state.pessoaJuridica.celular = payload.celular
    state.pessoaJuridica.fixo = payload.fixo
    state.pessoaJuridica.facebook = payload.facebook
    state.pessoaJuridica.twitter = payload.twitter
    state.pessoaJuridica.site = payload.site
    state.pessoaJuridica.outraRede = payload.outraRede
    state.pessoaJuridica.pais = payload.pais
    state.pessoaJuridica.estado = payload.estado
    state.pessoaJuridica.linkedin = payload.linkedin  
    
};
  
  export default {
    auth_success,
    auth_error,
    logout,
    allFisicaData,
    allJuridicaData,
  };