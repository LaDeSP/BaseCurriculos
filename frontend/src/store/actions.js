import axios from 'axios';
import * as Cookies from 'js-cookie'

  const login = async ({commit}, user) => {
      
      await axios({ url: 'http://localhost:8000/api/login', data: user, method: 'POST' })
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

  const logout = ({commit}) => {
    commit('logout');
    Cookies.remove('vuex');
  }


  const newFisica = async ({commit}, payload) => {
      
    await axios({ url: 'http://localhost:8000/api/pfisicas', data: payload, method: 'POST' })
      .then(response => {
        
        const newFisicaData = {
          'token': response.data.token,
          'user': response.data.user
        }
      
        commit('auth_success', {newFisicaData})

      }).catch(error => {
        //commit('auth_error')
        console.log(error)
      })

  };


  const newJuridica = async ({commit}, payload) => {
      
    await axios({ url: 'http://localhost:8000/api/pjuridicas', data: payload, method: 'POST' })
      .then(response => {
        
        const newJuridicaData = {
          'token': response.data.token,
          'user': response.data.user
        }
      
        commit('auth_success', {newJuridicaData})

      }).catch(error => {
        //commit('auth_error')
        console.log(error)
      })

  };
  
  export default {
    login,
    logout,
    newFisica,
    newJuridica,
  };