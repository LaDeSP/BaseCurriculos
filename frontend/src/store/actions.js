import axios from 'axios';

const login = ({commit}, user, instance) => {
    commit('auth_request')
    axios({ url: 'http://localhost:8000/api/login', data: user, method: 'POST' })
      .then(response => {
        commit('auth_success', response.data.token, response.data.user)
        commit('isLoggedIn')
      }).catch(err => {
        commit('auth_error')
      })
  
};
  
  export default {
    login,
  };