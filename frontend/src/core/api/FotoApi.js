import axios from 'axios'

const updateUserPic = async (state) => {
    return await axios.get(`getActualPhoto?token=${state.auth.token}`)
}
const deleteUserPic = async (state) => {
    return await axios.post(`deletePhoto?token=${state.auth.token}`)
}

export default {
    updateUserPic,
    deleteUserPic
}