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
          console.log(error)
        })    
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
        'user': response.data.user,
        'cpf': newFisicaData.cpf
      }

      commit('auth_success', {payload})

    }).catch(error => {
      console.log(error)
    })

  };

  const newJuridica = async ({commit}, newJuridicaData) => {
      
    await axios({ url: juridica_uri, data: newJuridicaData, method: 'POST' })
      .then(response => {
        
        const payload = {
          'token': response.data.token,
          'user': response.data.user,
          'cnpj': newJuridicaData.cnpj,
          'ramo': newJuridicaData.ramo,
        }
        commit('auth_success', {payload})

      }).catch(error => {
        console.log(error)
      })

  };

  const completeFisica = async({commit, state}, newCurriculo) => {
    
    const token = state.auth.token;
    
    await axios({ url: 'http://localhost:8000/api/curriculos?token=' + token, data: newCurriculo, method: 'POST' })
      .then(response => {
        
        let payloadContact = {
          'celular': newCurriculo.celular,
          'fixo': newCurriculo.fixo,
          'facebook': newCurriculo.facebook,
          'twitter': newCurriculo.twitter,
          'site': newCurriculo.site,
          'linkedin': newCurriculo.linkedin,
        }
       
        let payloadAddress = {
          'estado': newCurriculo.estado,
          'rua': newCurriculo.rua,
          'bairro': newCurriculo.bairro,
          'cidade': newCurriculo.cidade,
          'cep': newCurriculo.cep,
        }
       
        let payloadCurriculo = {
          'nome': newCurriculo.nome,
          'nascimento': newCurriculo.nascimento,
          'genero': newCurriculo.genero,
          'estadoCivil': newCurriculo.estadoCivil,
          'objetivos': newCurriculo.objetivos,
          'pretensao': newCurriculo.pretensao,
          'qualificacoes': newCurriculo.qualificacoes,
          'escolaridade': newCurriculo.escolaridade,
          'area': newCurriculo.area,
          'historicoProfissional': newCurriculo.historicoProfissional,
        }
                
        commit('contact', {payloadContact})
        commit('address', {payloadAddress});
        commit('allFisicaData', {payloadCurriculo});

      }).catch(error => {
        console.log(error)
      }) 

  };

  const completeJuridica = async ({commit, state}, completeJuridicaData) => {
  
    const token = state.auth.token;
    await axios({ url: juridica_uri + '/data?token=' + token, data: completeJuridicaData, method: 'POST' })
      .then(response => {
        
        let payloadContact = {
          'celular': completeJuridicaData.celular,
          'fixo': completeJuridicaData.fixo,
          'facebook': completeJuridicaData.facebook,
          'twitter': completeJuridicaData.twitter,
          'site': completeJuridicaData.site,
          'linkedin': completeJuridicaData.linkedin,
        }
       
        let payloadAddress = {
          'estado': completeJuridicaData.estado,
          'rua': completeJuridicaData.rua,
          'bairro': completeJuridicaData.bairro,
          'cidade': completeJuridicaData.cidade,
          'cep': completeJuridicaData.cep,
        }

        let payloadJuridica = {
          'name': completeJuridicaData.name,
        } 
        commit('contact', {payloadContact})
        commit('address', {payloadAddress});
        commit('allJuridicaData', {payloadJuridica})

        console.log(response);
      }).catch(error => {
        console.log(error)
      })

  };
  
  export default {
    login,
    logout,
    newFisica,
    newJuridica,
    completeFisica,
    completeJuridica,
   
  };