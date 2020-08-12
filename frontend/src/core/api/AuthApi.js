import axios from 'axios'

const login = async user => {
    return await axios.post('login', user)
}
const logout = async (state) => {
    console.log('state', state)
    return await axios.post(`logout?token=${state.auth.token}`)
}

export default {
    login,
    logout
}