import axios from 'axios'

const createCandidatura = async (state, vagaPayload) => {
    return await axios.post(`candidaturas?token=${state.auth.token}`, vagaPayload)
} 
const getCandidaturas = async (state) => {
    return await axios.get(`candidaturas?token=${state.auth.token}`)
}
const deleteCandidatura = async (state, candidaturaId) => {
    console.log('no api ', candidaturaId)
    return await axios.delete(`candidaturas/${candidaturaId}?token=${state.auth.token}`)
}
const recusarCandidatura = async (state, candidaturaId) => {
    return await axios.delete(`recusarCandidato/${candidaturaId}?token=${state.auth.token}`, candidaturaId)
}

export default {
    createCandidatura,
    getCandidaturas,
    deleteCandidatura,
    recusarCandidatura
   
}