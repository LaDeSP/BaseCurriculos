import axios from 'axios'

const createAgendamento = async (state, agendamentoData) => {
    return await axios.post(`agenda?token=${state.auth.token}`, agendamentoData)
}
const getAgenda = async (state) => {
    return await axios.get(`agenda?token=${state.auth.token}`)
}
const updateAgendamento = async (state, updatedAgendamentoData) => {
    return await axios.put(`agenda/${updatedAgendamentoData.updateId}?token=${state.auth.token}`, updatedAgendamentoData)
}
const confirmAgendamento = async (state, candidaturaId) => {
    return await axios.post(`confirmAgenda?token=${state.auth.token}`, candidaturaId)
}
const cancelAgendamento = async (state, agendamento) => {
    return await axios.post(`cancelAgenda?token=${state.auth.token}`, agendamento)
}
export default {
    createAgendamento,
    getAgenda,
    updateAgendamento,
    confirmAgendamento,
    cancelAgendamento
}