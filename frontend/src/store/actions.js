import axios from 'axios';

const login = ({commit}, user) => {
    
    axios({ url: 'http://localhost:8000/api/login', data: user, method: 'POST' })
      .then(response => {
        
        const authData = {
          'token': response.data.token,
          'user': response.data.user
        }
       
        commit('auth_success', {authData})

      }).catch(error => {
        //commit('auth_error')
        console.log(error)
      })
  
};
  
  export default {
    login,
  };