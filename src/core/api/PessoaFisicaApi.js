import axios from 'axios'

const createPessoaFisica = async pessoaFisicaData => {
    return await axios.post('pfisicas', pessoaFisicaData)
}
const completePessoaFisicaData = async ({state}, completedPessoaFisicaData) => {
    return await axios.post(`curriculos?token=${state.auth.token}`, completedPessoaFisicaData)
}
const getPessoaFisicaData = async ({state}) => {
    return await axios.get(`curriculos/${state.auth.user.id}?token=${state.auth.token}`)
}
const updatePessoaFisica = async ({state}, updatedPessoaFisicaData) => {
    return await axios.put(`curriculos/${state.auth.user.id}?token=${state.auth.token}`, updatedPessoaFisicaData)
}
const updatePessoaFisicaUser = async ({state}, updatedPessoaFisicaUserData) => {
    return await axios.post(`updateDadosCadastroFisica?token=${state.auth.token}`, updatedPessoaFisicaUserData)
}

export default {
    createPessoaFisica,
    completePessoaFisicaData,
    getPessoaFisicaData,
    updatePessoaFisica,
    updatePessoaFisicaUser
}