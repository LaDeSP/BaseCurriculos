import axios from 'axios'

const createCandidatura = async (state, vagaPayload) => {
    return await axios.post(`candidaturas?token=${state.auth.token}`, vagaPayload)
} 
const getCandidaturas = async (state) => {
    return await axios.get(`candidaturas?token=${state.auth.token}`)
}
const cancelCandidatura = async (state, candidaturaId) => {
    return await axios.delete(`candidaturas/${candidaturaId}?token=${state.auth.token}`)
}
const finalizarCandidatura = async (state, payload) => {
    return await axios.post(`finalizarCandidatura?token=${state.auth.token}`, payload)
}

export default {
    createCandidatura,
    getCandidaturas,
    cancelCandidatura,
    finalizarCandidatura
}