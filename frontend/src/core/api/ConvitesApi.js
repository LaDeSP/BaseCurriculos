import axios from 'axios' 

const createConvite = async (state, conviteData) => {
    return await axios.post(`createConvite?token=${state.auth.token}`, conviteData)
}
const getConvites = async (state) => {
    return await axios.get(`getConvites?token=${state.auth.token}`)
}
const confirmConvite = async (state, confirmedConvite) => {
    return await axios.post(`respostaConvite?token=${state.auth.token}`, confirmedConvite)
}
const cancelConvite = async (state, convite) => {
    return await axios.post(`cancelarConvite?token=${state.auth.token}`, convite)
}

export default {
    createConvite,
    getConvites,
    confirmConvite,
    cancelConvite
}