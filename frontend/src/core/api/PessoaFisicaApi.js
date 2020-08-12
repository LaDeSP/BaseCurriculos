import axios from 'axios'
import state from '@/core/store/state'

const createPessoaFisica = async pessoaFisicaData => {
    return await axios.post('pfisicas', pessoaFisicaData)
}
const completePessoaFisicaData = async (completedPessoaFisicaData, state) => {
    console.log('completed', completedPessoaFisicaData)
    console.log('state', state)
    return await axios.post(`curriculos?token=${state.auth.token}`, completedPessoaFisicaData)
}
const getPessoaFisicaData = async (state) => {
    return await axios.get(`curriculos/${state.auth.user.id}?token=${state.auth.token}`)
}
const updatePessoaFisica = async (state, updatedPessoaFisicaData) => {
    return await axios.put(`curriculos/${state.auth.user.id}?token=${state.auth.token}`, updatedPessoaFisicaData)
}
const updatePessoaFisicaUser = async (state, updatedPessoaFisicaUserData) => {
    return await axios.post(`updateDadosCadastroFisica?token=${state.auth.token}`, updatedPessoaFisicaUserData)
}

export default {
    createPessoaFisica,
    completePessoaFisicaData,
    getPessoaFisicaData,
    updatePessoaFisica,
    updatePessoaFisicaUser
}