import axios from 'axios'

const searchVagas = async (state, keywords) => {
    return await axios.get(`buscaVagas/${keywords}?token=${state.auth.token}`)
}
const searchAvancadoVagas = async (state, search) => {
    if (search.keywords == '') search.keywords = 'undefined'
    if (search.cargo == '') search.cargo = 'undefined'
    if (search.beneficio == '') search.beneficio = 'undefined'
    if (search.jornada == '') search.jornada = 'undefined'
    if (search.requisitos == '') search.requisitos = 'undefined'
    if (search.area == '') search.area = 'undefined'
    //acho que isso aqui seria melhor como um post
    return await axios.get(`
        buscaVagasAvancadas/${search.keywords}/${search.cargo}/${search.beneficio}/${search.jornada}/${search.requisitos}/${search.area}?token=${state.auth.token}
    `)
}
const searchCurriculos = async (state, keywords) => {
    return await axios.get(`buscaCurriculos/${keywords}?token=${state.auth.token}`)
}
const searchAvancadoCurriculos = async (state, search) => {
    if (search.keywords == '') search.keywords = 'undefined'
    if (search.escolaridade == '') search.escolaridade = 'undefined'
    if (search.objetivos == '') search.objetivos = 'undefined'
    if (search.historicoProfissional == '') search.historicoProfissional = 'undefined'
    if (search.cidade == '') search.cidade = 'undefined'
    if (search.nome == '') search.nome = 'undefined'
    if (search.area == '') search.area = 'undefined'
    //acho que isso aqui seria melhor como um post
    return await axios.get(`buscaCurriculosAvancadas/${search.keywords}/${search.escolaridade}/${search.objetivos}/${search.historicoProfissional}/${search.cidade}/${search.nome}/${search.area}?token=${state.auth.token}`)
    
}

export default {
    searchVagas,
    searchAvancadoVagas,
    searchCurriculos,
    searchAvancadoCurriculos
}