import axios from 'axios'

const activateAccount = async ({state}) => {
    return await axios.post(`activate/${state.auth.user.id}/?token=${state.auth.token}`, completedPessoaFisicaData)
}
const deactivateAccount = async ({state}) => {
    return await axios.delete(`deactivate/${state.auth.user.id}/?token=${state.auth.token}`, completedPessoaFisicaData)
}

export default {
    activateAccount,
    deactivateAccount
}