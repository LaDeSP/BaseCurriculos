import axios from 'axios'

const createCandidatura = async (state, vagaPayload) => {
    return await axios.post(`candidaturas?token=${state.auth.token}`, vagaPayload)
} 
const getCandidaturas = async (state) => {
    return await axios.get(`candidaturas?token=${state.auth.token}`)
}
const finalizarCandidatura = async (state, payload) => {
    return await axios.post(`finalizarCandidatura?token=${state.auth.token}`, payload)
}
const recusarCandidatura = async (state, candidaturaId) => {
    return await axios.delete(`recusarCandidato/${candidaturaId}?token=${state.auth.token}`, candidaturaId)
}

export default {
    createCandidatura,
    getCandidaturas,
    finalizarCandidatura,
    recusarCandidatura
   
}