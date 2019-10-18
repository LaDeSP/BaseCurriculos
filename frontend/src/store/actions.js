import axios from 'axios';
import * as Cookies from 'js-cookie'

  const juridica_uri = 'http://localhost:8000/api/pjuridicas'; 
  const fisica_uri = 'http://localhost:8000/api/pfisicas';
  const curriculos_uri = 'http://localhost:8000/api/curriculos';
  const vagas_uri = 'http://localhost:8000/api/vagas';

  const login = async ({commit}, user) => {
      
      await axios({ url: 'http://localhost:8000/api/login', data: user, method: 'POST' })
        .then(response => {
          
          const payload = {
            'path': response.data.foto,
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
      
      const dataCompleted = false;
      commit('logout');
      commit('dataCompleted', dataCompleted)
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
          'complemento': newCurriculo.complemento,
          'numero': newCurriculo.numero,
          'pais': newCurriculo.pais
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
        const dataCompleted = true;  
        commit('dataCompleted', dataCompleted);
      
        return response.data
      })
      .catch(error => {
        console.log(error)
      }) 

  };

  const completeJuridica = async ({commit, state}, completeJuridicaData) => {
  
    const token = state.auth.token;
    return await axios({ url: juridica_uri + '/data?token='+ token, data: completeJuridicaData, method: 'POST' })
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
          'complemento': completeJuridicaData.complemento,
          'numero': completeJuridicaData.numero,
        }

        let payloadJuridica = {
          'name': completeJuridicaData.name,
        } 
        commit('contact', {payloadContact})
        commit('address', {payloadAddress});
        commit('allJuridicaData', {payloadJuridica})
        const dataCompleted = true;  
        commit('dataCompleted', dataCompleted);
       
        return response.data
      }).catch(error => {
        console.log(error)
      })

  };

  const updateFisica = async({commit, state}, editCurriculo) => {
    
    const token = state.auth.token;
    const user_id = state.auth.user.id;
    return await axios({ url: curriculos_uri + '/' + user_id + '?token=' + token, data: editCurriculo, method: 'PUT' })
      .then(response => {
        
        let payloadContact = {
          'celular': editCurriculo.celular,
          'fixo': editCurriculo.fixo,
          'facebook': editCurriculo.facebook,
          'twitter': editCurriculo.twitter,
          'site': editCurriculo.site,
          'linkedin': editCurriculo.linkedin,
        }
       
        let payloadAddress = {
          'estado': editCurriculo.estado,
          'rua': editCurriculo.rua,
          'bairro': editCurriculo.bairro,
          'cidade': editCurriculo.cidade,
          'cep': editCurriculo.cep,
          'complemento': editCurriculo.complemento,
          'numero': editCurriculo.numero,
          'pais': editCurriculo.pais
        }
       
        let payloadCurriculo = {
          'nome': editCurriculo.nome,
          'nascimento': editCurriculo.nascimento,
          'genero': editCurriculo.genero,
          'estadoCivil': editCurriculo.estadoCivil,
          'objetivos': editCurriculo.objetivos,
          'pretensao': editCurriculo.pretensao,
          'qualificacoes': editCurriculo.qualificacoes,
          'escolaridade': editCurriculo.escolaridade,
          'area': editCurriculo.area,
          'historicoProfissional': editCurriculo.historicoProfissional,
        }
                
        commit('contact', {payloadContact})
        commit('address', {payloadAddress});
        commit('allFisicaData', {payloadCurriculo});
       
        return response.data
      })
      .catch(error => {
        console.log(error)
      }) 

  };

  const updateJuridica = async ({commit, state}, JuridicaData) => {
  
    const token = state.auth.token;
    const user_id = state.auth.user.id;
    return await axios({ url: juridica_uri + '/' + user_id + '?token='+ token, data: JuridicaData, method: 'PUT' })
      .then(response => {
        
        let payloadContact = {
          'celular': JuridicaData.celular,
          'fixo': JuridicaData.fixo,
          'facebook': JuridicaData.facebook,
          'twitter': JuridicaData.twitter,
          'site': JuridicaData.site,
          'linkedin': JuridicaData.linkedin,
        }
       
        let payloadAddress = {
          'estado': JuridicaData.estado,
          'rua': JuridicaData.rua,
          'bairro': JuridicaData.bairro,
          'cidade': JuridicaData.cidade,
          'cep': JuridicaData.cep,
          'complemento': JuridicaData.complemento,
          'numero': JuridicaData.numero,
          'pais': JuridicaData.pais
        }

        let payloadJuridica = {
          'name': JuridicaData.nome,
        } 
        console.log('payloadAddress', payloadAddress)
        commit('contact', {payloadContact})
        commit('address', {payloadAddress});
        commit('allJuridicaData', {payloadJuridica})
        console.log('response', response.data)

        return response.data
      }).catch(error => {
        console.log(error)
      })

  };
  
  const loadFisica = async ({commit, state}) => {
  
    const token = state.auth.token;
    const user_id = state.auth.user.id;
    return await axios({ url: curriculos_uri + '/' + user_id + '?token='+ token, method: 'GET' })
      .then(response => {
        
        let payloadContact = {
          'celular': response.data.fisica[0].contato.celular,
          'fixo': response.data.fisica[0].contato.fixo,
          'facebook': response.data.fisica[0].contato.facebook,
          'twitter': response.data.fisica[0].contato.twitter,
          'site': response.data.fisica[0].contato.site,
          'linkedin': response.data.fisica[0].contato.linkedin,
        }
       
        let payloadAddress = {
          'estado': response.data.fisica[0].endereco.estado,
          'rua': response.data.fisica[0].endereco.rua,
          'bairro': response.data.fisica[0].endereco.bairro,
          'cidade': response.data.fisica[0].endereco.cidade,
          'cep': response.data.fisica[0].endereco.cep,
          'numero': response.data.fisica[0].endereco.numero,
          'complemento': response.data.fisica[0].endereco.complemento,
        }

        let payloadCurriculo = {
          'nome': response.data.fisica[0].user.name,
          'cpf': response.data.fisica[0].cpf,
          'nascimento': response.data.fisica[0].data_nascimento,
          'genero': response.data.fisica[0].genero,
          'estadoCivil': response.data.fisica[0].estado_civil,
          'objetivos': response.data.curriculo[0].objetivos,
          'area': response.data.area,
          'area_id': response.data.area_id,
          'pretensao': response.data.curriculo[0].pretensao,
          'qualificacoes': response.data.curriculo[0].qualificacoes,
          'escolaridade': response.data.curriculo[0].escolaridade,
          'historicoProfissional': response.data.curriculo[0].historicoProfissional,
        } 
        
        commit('contact', {payloadContact})
        commit('address', {payloadAddress});
        commit('allFisicaData', {payloadCurriculo})
        const dataCompleted = true;  
        commit('dataCompleted', dataCompleted)

      }).catch(error => {
        //console.log(error)
      })

  };

  const loadJuridica = async ({commit, state}) => {
  
    const token = state.auth.token;
    const user_id = state.auth.user.id;
    return await axios({ url: juridica_uri + '/' + user_id + '?token='+ token, method: 'GET' })
      .then(response => {
        
        let payloadContact = {
          'celular': response.data.juridica[0].contato.celular,
          'fixo': response.data.juridica[0].contato.fixo,
          'facebook': response.data.juridica[0].contato.facebook,
          'twitter': response.data.juridica[0].contato.twitter,
          'site': response.data.juridica[0].contato.site,
          'linkedin': response.data.juridica[0].contato.linkedin,
        }
       
        let payloadAddress = {
          'estado': response.data.juridica[0].endereco.estado,
          'rua': response.data.juridica[0].endereco.rua,
          'bairro': response.data.juridica[0].endereco.bairro,
          'cidade': response.data.juridica[0].endereco.cidade,
          'cep': response.data.juridica[0].endereco.cep,
          'numero': response.data.juridica[0].endereco.numero,
          'complemento': response.data.juridica[0].endereco.complemento,
        }

        let payloadJuridica = {
          'nome': response.data.juridica[0].user.name,
          'cnpj': response.data.juridica[0].cnpj,
          'ramo': response.data.juridica[0].ramo,
        } 
        
        commit('contact', {payloadContact})
        commit('address', {payloadAddress});
        commit('allJuridicaData', {payloadJuridica})
        const dataCompleted = true;  
        commit('dataCompleted', dataCompleted)
        console.log('response',response.data.juridica)

      }).catch(error => {
        //console.log(error)
      })

  };

  const deleteFisica = async ({commit, state}) => {

    const token = state.auth.token;
    const user_id = state.auth.user.id
    return await axios({ url: fisica_uri + '/' + user_id + '?token='+ token, method: 'DELETE' })
    .then(response => {
       commit('logout');
       Cookies.remove('vuex');
       return response;
    })
    .catch(
        error => console.log(error)
    );
  }

   const deleteJuridica = async ({commit, state}) => {

    const token = state.auth.token;
    const user_id = state.auth.user.id
    return await axios({ url: juridica_uri + '/' + user_id + '?token='+ token, method: 'DELETE' })
    .then(response => {
       commit('logout');
       Cookies.remove('vuex');
       return response;
    })
    .catch(
        error => console.log(error)
    );
  }

  const createVaga = async ({commit, state}, NewVaga) => {
    const token = state.auth.token;
    return await axios({ url: vagas_uri + '?token=' + token, data: NewVaga, method: 'POST'})
    .then(response => {

      console.log('createVaga', response.data);
      return response.data
    }).catch(
      error => console.log(error)
    );
  }

  const updateVaga = async ({commit, state}, editVaga) => {
    const token = state.auth.token;
    return await axios({ url: vagas_uri + '/' + editVaga.vaga_id + '?token=' + token, data: NewVaga, method: 'POST'})
    .then(response => {

      console.log('response', response)
      //return response.data
    }).catch(
      error => console.log(error)
    );
  }

  const loadVagasJuridica = async ({commit, state}) => {
  
    const token = state.auth.token;
    return await axios({ url: vagas_uri + '?token='+ token, method: 'GET' })
      .then(response => {
        
        let payloadVagasJuridica = [];
        payloadVagasJuridica = response.data.vagas;
  
        commit('vagasJuridica', payloadVagasJuridica)
        
        return response.data
      }).catch(error => {
        console.log(error)
      })

  };

  const changeStatusVaga = async ({commit, state}, newStatus) => {
    const token = state.auth.token;
    return await axios({ url: vagas_uri + '/changeStatus' + '?token=' + token, data: newStatus, method: 'POST'})
    .then(response => {
      
      let payloadVagasJuridica = [];
      payloadVagasJuridica = response.data.vagaChanged;

      return response.data
    }).catch(
      error => console.log(error)
    );

  }

  const deleteVaga = async ({commit, state}, NewVaga) => {
    const token = state.auth.token;
    const user_id = state.auth.user.id;
    return await axios({ url: vagas_uri + '/' + user_id + '?token=' + token, data: NewVaga, method: 'POST'})
    .then(response => {

      let createVaga = { 
        vagasJuridica: response.data.vagas
      }

      console.log('createVaga', createVaga);
      console.log('response', response)
      //return response.data
    }).catch(
      error => console.log(error)
    );
  }

  export default {
    login,
    logout,
    newFisica,
    newJuridica,
    completeFisica,
    completeJuridica,
    updateFisica,
    updateJuridica,
    loadFisica,
    loadJuridica,
    deleteFisica,
    deleteJuridica,
    createVaga,
    updateVaga,
    loadVagasJuridica,
    changeStatusVaga,
    deleteVaga,

  
  };