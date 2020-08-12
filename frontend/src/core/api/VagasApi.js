import axios from 'axios'

const getAreas = async (state) => {
    return await axios.get(`areas?token=${state.auth.token}`)
}
const createVaga = async ({state}, vagaData) => {
    return await axios.post(`vagas?token=${state.auth.token}`, vagaData)
}
const getVagasDaPessoaJuridicaLogada = async ({state}) => {
    return await axios.get(`vagas?token=${state.auth.token}`)
}
const getVagasRecomendadas = async ({state}) => {
    return await axios.get(`buscaVagasRecomendadas?${state.auth.user.id}/token=${state.auth.token}`)
}
const getPorcentagemVagas = async ({state}) => {
    return await axios.get(`vagasPorcentagem?token=${state.auth.token}`)
}
const updateVaga = async ({state}, updatedVagaData) => {
    return await axios.put(`vagas/${updatedVagaData.vagaId}?token=${state.auth.token}`, updatedVagaData)
}
const updateVagaStatus = async ({state}, updatedVagaStatus) => {
    return await axios.post(`vagas/changeStatus?token=${state.auth.token}`, updatedVagaStatus)
}
const deleteVaga = async ({state}, vagaId) => {
    return await axios.delete(`vagas/${vagaId}?token=${state.auth.token}`)
}

export default {
    getAreas,
    createVaga,
    getVagasDaPessoaJuridicaLogada,
    getVagasRecomendadas,
    getPorcentagemVagas,
    updateVaga,
    updateVagaStatus,
    deleteVaga
}