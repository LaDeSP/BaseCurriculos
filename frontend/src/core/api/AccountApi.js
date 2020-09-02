import axios from 'axios'

const activateAccount = async (state) => {
    return await axios.post(`activate/${state.auth.user.id}/?token=${state.auth.token}`)
}
const deactivateAccount = async (state) => {
    console.log('deact', state)
    return await axios.delete(`deactivate/${state.auth.user.id}/?token=${state.auth.token}`)
}
const handleUserAccount = async (state, payload) => {
    return await axios.post(`userStatus?token=${state.auth.token}`, payload)
}
const forgotPassword = async (payload) => {
    return await axios.post(`reset-password`, payload)
}

export default {
    activateAccount,
    deactivateAccount,
    handleUserAccount,
    forgotPassword
}