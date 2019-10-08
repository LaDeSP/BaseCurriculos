import axios from 'axios';
import * as Cookies from 'js-cookie'

  const juridica_uri = 'http://localhost:8000/api/pjuridicas'; 
  const fisica_uri = 'http://localhost:8000/api/pfisicas';

  const login = async ({commit}, user) => {
      
      await axios({ url: 'http://localhost:8000/api/login', data: user, method: 'POST' })
        .then(response => {
          
          const payload = {
            'token': response.data.token,
            'user': response.data.user
          }
        
          commit('auth_success', {payload})

        }).catch(error => {
          //commit('auth_error')
          console.log(error)
        })

        console.log('tokenhh', token)
    
  };

  const logout = ({commit}) => {
    commit('logout');
    Cookies.remove('vuex');
  }


  const newFisica = async ({commit}, newFisicaData) => {
      
    await axios({ url: fisica_uri, data: newFisicaData, method: 'POST' })
    .then(response => {
      
      const payload = {
        'token': response.data.token,
        'user': response.data.user
      }

      commit('auth_success', {payload})

    }).catch(error => {
      //commit('auth_error')
      console.log(error)
    })

  };


  const newJuridica = async ({commit}, newJuridicaData) => {
      
    await axios({ url: juridica_uri, data: newJuridicaData, method: 'POST' })
      .then(response => {
        
        const payload = {
          'token': response.data.token,
          'user': response.data.user
        }
      
        commit('auth_success', {payload})

      }).catch(error => {
        //commit('auth_error')
        console.log(error)
      })

  };

  const completeJuridica = async ({commit, state}, completeJuridicaData) => {
  
    const token = state.auth.token;
    await axios({ url: juridica_uri + '/data?token=' + token, data: completeJuridicaData, method: 'POST' })
      .then(response => {
        
        const payload = {
          'name': this.name,
          'rua': this.rua,
          'bairro': this.bairro,
          'cidade': this.cidade,
          'cep': this.cep,
          'celular': this.celular,
          'fixo': this.fixo,
          'facebook': this.facebook,
          'twitter': this.twitter,
          'site': this.site,
          'outraRede': this.outraRede,
          'pais': this.pais,
          'estado': this.estado,
          'linkedin': this.linkedin

        } 

        commit('allJuridicaData', {payload})

      }).catch(error => {
        console.log(error)
      })

  };
  
  export default {
    login,
    logout,
    newFisica,
    newJuridica,
    completeJuridica,
  };