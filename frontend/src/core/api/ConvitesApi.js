import axios from 'axios' 

const createConvite = async (state, conviteData) => {
    return await axios.post(`createConvite?token=${state.auth.token}`, conviteData)
}
const getConvites = async (state) => {
    return await axios.get(`getConvites?token=${state.auth.token}`)
}
const respostaConvite = async (state, resposta) => {
    return await axios.post(`respostaConvite?token=${state.auth.token}`, resposta)
}
const cancelConvite = async (state, convite) => {
    return await axios.post(`cancelarConvite?token=${state.auth.token}`, convite)
}

export default {
    createConvite,
    getConvites,
    respostaConvite,
    cancelConvite
}