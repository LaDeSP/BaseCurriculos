const isLoggedIn = state => !!state.auth.token;
const authStatus = state => state.auth.status;
const dataCompleted = state => state.dataCompleted; 

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

const displayVagaById = (state) => (vaga_id) => {
  
    let vagas = state.vagasJuridica;
    let vagasById = vagas.filter((vagaById) => {return vagaById.id === vaga_id})
    return vagasById
  
}

const permissaoDoUsuario = state =>{
  return state.auth.user.role
}

const displayCandidaturas = state =>{
  return state.candidaturas
}


const displayCandidaturasByVaga = (state) => (vaga_id) => {
  
  let candidaturas = state.candidaturas;
  let candidaturasByVaga = candidaturas.filter((candidaturasByVaga) => {return candidaturasByVaga.vagas_id === vaga_id})
  return candidaturasByVaga

}

const displayCandidatoById = (state) => (candidato_id) => {
  
  let candidaturas = state.candidaturas;
  let candidatoById = candidaturas.filter((candidatoById) => {return candidatoById.id === candidato_id})
  let deleteNull = candidatoById[0].curriculo.fisica.contato;
  Object.keys(deleteNull).forEach((key) => (deleteNull[key] == null) && delete deleteNull[key]);

  return candidatoById

}

const displayResultados = state =>{
  return state.resultado
}


export default {
  isLoggedIn,
  authStatus,
  dataCompleted,
  displayPessoaFisica,
  displayPessoaJuridica, 
  displayCurriculo,
  displayVagasJuridica,
  displayVagaById,
  permissaoDoUsuario,
  displayCandidaturas,
  displayCandidaturasByVaga,
  displayResultados,
  displayCandidatoById,

};