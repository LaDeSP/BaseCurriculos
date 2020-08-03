import axios from 'axios'


const updateUserFoto = async ({state}) => {
    return await axios.get(`getActualPhoto?token=${state.auth.token}`)
}
const deleteUserFoto = async ({state}) => {
    return await axios.post(`deletePhoto?token=${state.auth.token}`)
}

export default {
    updateUserFoto,
    deleteUserFoto
}