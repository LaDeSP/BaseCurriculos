import axios from 'axios'

const createPessoaJuridica = async pessoaJuridicaData => {
    return await axios.post('pjuridicas', pessoaJuridicaData)
}
const completePessoaJuridicaData = async (state, completedPessoaJuridicaData) => {
    return await axios.post(`pjuridicas/data?token=${state.auth.token}`, completedPessoaJuridicaData)
}
const getJuridicaUsers = async state => {
    return await axios.get(`users?token=${state.auth.token}`)
}
const getJuridicaPatrocinadoras = async () => {
    console.log('veio aki')
    return await axios.get(`patrocinadoras`)
}
const getPessoaJuridicaData = async (state) => {
    return await axios.get(`pjuridicas/${state.auth.user.id}?token=${state.auth.token}`)
}
const updatePessoaJuridica = async (state, updatedPessoaJuridicaData) => {
    return await axios.put(`pjuridicas/${state.auth.user.id}?token=${state.auth.token}`, updatedPessoaJuridicaData)
}
const updatePessoaJuridicaUser = async (state, updatedPessoaJuridicaUserData) => {
    return await axios.post(`updateDadosCadastroJuridica?token=${state.auth.token}`, updatedPessoaJuridicaUserData)
}

export default {
    createPessoaJuridica,
    completePessoaJuridicaData,
    getJuridicaUsers,
    getJuridicaPatrocinadoras,
    getPessoaJuridicaData,
    updatePessoaJuridica,
    updatePessoaJuridicaUser
}