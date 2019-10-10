import axios from 'axios';
import * as Cookies from 'js-cookie'

  const juridica_uri = 'http://localhost:8000/api/pjuridicas'; 
  const fisica_uri = 'http://localhost:8000/api/pfisicas';
  const curriculos_uri = 'http://localhost:8000/api/curriculos';

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

  const logout = async ({commit, state}) => {
     
    const token = state.auth.token;
    await axios({ url: 'http://localhost:8000/api/logout?token=' + token, method: 'POST' })
    .then(response => {
      
      commit('logout');
      Cookies.remove('vuex');

    }, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
    .catch(error => {
      console.log(error)
    })

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
    return await axios({ url: curriculos_uri + '?token=' + token, data: newCurriculo, method: 'POST' })
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
          
        return response.data
        //commit('contact', {payloadContact})
        //commit('address', {payloadAddress});
        //commit('allFisicaData', {payloadCurriculo});

      })
      .catch(error => {
        console.log(error)
      }) 

  };

  const editFisica = async({commit, state}, editCurriculo) => {
    
    const token = state.auth.token;
    
    await axios({ url: curriculos_uri + '?token=' + token, data: editCurriculo, method: 'PUT' })
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

      })
      .catch(error => {
        console.log(error)
      }) 

  };

  const completeJuridica = async ({commit, state}, completeJuridicaData) => {
  
    const token = state.auth.token;
    await axios({ url: juridica_uri + '/data?token='+ token, data: completeJuridicaData, method: 'POST' })
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
          'dataCompleted': true
        } 
        commit('contact', {payloadContact})
        commit('address', {payloadAddress});
        commit('allJuridicaData', {payloadJuridica})

      }).catch(error => {
        console.log(error)
      })

  };

  const editJuridica = async ({commit, state}, JuridicaData) => {
  
    const token = state.auth.token;
    await axios({ url: juridica_uri + '?token='+ token, data: JuridicaData, method: 'PUT' })
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
          'dataCompleted': true
        } 
        commit('contact', {payloadContact})
        commit('address', {payloadAddress});
        commit('allJuridicaData', {payloadJuridica})

      }).catch(error => {
        console.log(error)
      })

  };
  
  const loadFisica = async ({commit, state}) => {
  
    const token = state.auth.token;
    const user_id = state.auth.user.id;
    await axios({ url: curriculos_uri + '/' + user_id + '?token='+ token, method: 'GET' })
      .then(response => {
        
        let payloadContact = {
          'celular': response.data.celular,
          'fixo': response.data.fixo,
          'facebook': response.data.facebook,
          'twitter': response.data.twitter,
          'site': response.data.site,
          'linkedin': response.data.linkedin,
        }
       
        let payloadAddress = {
          'estado': response.data.estado,
          'rua': response.data.rua,
          'bairro': response.data.bairro,
          'cidade': response.data.cidade,
          'cep': response.data.cep,
        }

        let payloadFisica = {
          'nome': response.data.name,
          'cpf': response.data.cpf,
          'nascimento': response.data.nascimento,
          'genero': response.data.genero,
          'estadoCivil': response.data.estadoCivil,
          'dataCompleted': true
        } 
        //commit('contact', {payloadContact})
        //commit('address', {payloadAddress});
        //commit('allFisicaData', {payloadFisica})
        console.log(payloadFisica)
        
      }).catch(error => {
        console.log(error)
      })

  };

  const loadJuridica = async ({commit, state}) => {
  
    const token = state.auth.token;
    const user_id = state.auth.user.id;
    await axios({ url: juridica_uri + '/' + user_id + '?token='+ token, method: 'GET' })
      .then(response => {
        
        let payloadContact = {
          'celular': response.data.celular,
          'fixo': response.data.fixo,
          'facebook': response.data.facebook,
          'twitter': response.data.twitter,
          'site': response.data.site,
          'linkedin': response.data.linkedin,
        }
       
        let payloadAddress = {
          'estado': response.data.estado,
          'rua': response.data.rua,
          'bairro': response.data.bairro,
          'cidade': response.data.cidade,
          'cep': response.data.cep,
        }

        let payloadJuridica = {
          'name': response.data.name,
          'cnpj': response.data.cnpj,
          'ramo': response.data.ramo,
          'dataCompleted': true
        } 
        commit('contact', {payloadContact})
        commit('address', {payloadAddress});
        commit('allJuridicaData', {payloadJuridica})
        
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
    editFisica,
    editJuridica,
    loadFisica,
    loadJuridica,
   
  };