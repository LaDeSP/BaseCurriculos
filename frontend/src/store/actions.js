import axios from 'axios';
import * as Cookies from 'js-cookie'

  const juridica_uri = 'http://localhost:8000/api/pjuridicas'; 
  const fisica_uri = 'http://localhost:8000/api/pfisicas';
  const curriculos_uri = 'http://localhost:8000/api/curriculos';
  const vagas_uri = 'http://localhost:8000/api/vagas';
  const candidaturas_uri = 'http://localhost:8000/api/candidaturas';
  const agenda_uri = 'http://localhost:8000/api/agenda';

  const login = async ({commit}, user) => {
      
      return await axios({ url: 'http://localhost:8000/api/login', data: user, method: 'POST' })
        .then(response => {
          
          const payload = {
            'path': response.data.foto,
            'token': response.data.token,
            'user': response.data.user
          } 
          commit('auth_success', {payload})

          return response.data
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
      
    return await axios({ url: fisica_uri, data: newFisicaData, method: 'POST' })
    .then(response => {
      
      const payload = {
        'token': response.data.token,
        'user': response.data.user,
        'path': response.data.foto,
      }
      commit('auth_success', {payload})
      return response.data

    }).catch(error => {
      console.log(error)
    })

  };

  const newJuridica = async ({commit}, newJuridicaData) => {
      
    return await axios({ url: juridica_uri, data: newJuridicaData, method: 'POST' })
      .then(response => {
        
        const payload = {
          'token': response.data.token,
          'user': response.data.user,
          'path': response.data.foto,
        }
        commit('auth_success', {payload})
        return response.data
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
        
       // commit('contact', {payloadContact})
        //commit('address', {payloadAddress});
        //commit('allFisicaData', {payloadCurriculo});
       // const dataCompleted = true;  
        //commit('dataCompleted', dataCompleted);
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
        commit('contact', {payloadContact})
        commit('address', {payloadAddress});
        commit('allJuridicaData', {payloadJuridica})

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

      }).catch(error => {
        //console.log(error)
      })

  };

  const deactivateAccount = async ({commit, state}) => {

    const token = state.auth.token;
    const user_id = state.auth.user.id
    return await axios({ url: 'http://localhost:8000/api/deactivate' + '/' + user_id + '?token='+ token, method: 'DELETE' })
    .then(response => {
       commit('logout');
       Cookies.remove('vuex');
       return response;
    })
    .catch(
        error => console.log(error)
    );
  };

  const activateAccount = async ({commit, state}) => {

    const token = state.auth.token;
    const user_id = state.auth.user.id
    console.log('iuser', user_id);
    return await axios({ url: 'http://localhost:8000/api/activate' + '/' + user_id + '?token='+ token, method: 'POST' })
    .then(response => {
       //commit('logout');
       console.log('response activate', response);
       return response;
    })
    .catch(
        error => console.log(error)
    );
  };

  const createVaga = async ({commit, state}, newVaga) => {
    const token = state.auth.token;
    return await axios({ url: vagas_uri + '?token=' + token, data: newVaga, method: 'POST'})
    .then(response => {

      return response.data
    }).catch(
      error => console.log(error)
    );
  };

  const updateVaga = async ({commit, state}, editVaga) => {
    const token = state.auth.token;
    return await axios({ url: vagas_uri + '/' + editVaga.vaga_id + '?token=' + token, data: editVaga, method: 'PUT'})
    .then(response => {

      return response.data
    }).catch(
      error => console.log(error)
    );
  };

  const requestVaga = async ({commit, state}, requestVaga) => {
    const token = state.auth.token;
    return await axios({ url: candidaturas_uri + '?token=' + token, data: requestVaga, method: 'POST'})
    .then(response => {

      let payloadVagasJuridica = [];
      payloadVagasJuridica = response.data.vagas;
      commit('vagasJuridica', payloadVagasJuridica)

      return response.data
    }).catch(
      error => console.log(error)
    );
  
  };

  const requestVagaDash = async ({commit, state}, requestVaga) => {
    const token = state.auth.token;
    return await axios({ url: candidaturas_uri + '?token=' + token, data: requestVaga, method: 'POST'})
    .then(response => {
      
      let payloadCandidaturas = [];
      payloadCandidaturas = response.data.candidaturas;
      commit('candidaturas', payloadCandidaturas)
      
      return response.data
    }).catch(
      error => console.log(error)
    );
  
  };

  const loadVagasJuridica = async ({commit, state}) => {
  
    const token = state.auth.token;
    return await axios({ url: vagas_uri + '?token='+ token, method: 'GET' })
      .then(response => {
        
        let payloadVagasJuridica = [];
        payloadVagasJuridica = response.data.vagas;
        commit('vagasJuridica', payloadVagasJuridica)
        commit('countVagasJuridica', response.data.countVagas)

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

      commit('vagasJuridica', payloadVagasJuridica)
      return response.data
    }).catch(
      error => console.log(error)
    );

  };

  const deleteVaga = async ({commit, state}, vaga_id) => {
    const token = state.auth.token;
    return await axios({ url: vagas_uri + '/' + vaga_id + '?token=' + token, method: 'DELETE'})
    .then(response => {
      commit('deleteVaga', vaga_id);
      //return response.data
    }).catch(
      error => console.log(error)
    );
  };

  const updateFoto = async ({commit, state}) => {
  
    const token = state.auth.token;
    return await axios({ url: 'http://localhost:8000/api/getActualPhoto?token='+ token, method: 'GET' })
      .then(response => {

        let payloadPath = response.data.foto;
        commit('newFoto', payloadPath)

      }).catch(error => {
        console.log(error)
      })

  };

  const deleteUserPhoto = async ({commit, state}) => {
  
    const token = state.auth.token;
    return await axios({ url: 'http://localhost:8000/api/deletePhoto?token='+ token, method: 'POST' })
      .then(response => {

        let payloadPath = response.data.foto;
        commit('newFoto', payloadPath)

      }).catch(error => {
        console.log(error)
      })

  };

  const loadArea = async ({commit, state}) => {
    const token = state.auth.token;
    return await axios({ url: 'http://localhost:8000/api/areas?token=' + token, method: 'GET' })
      .then(response => {

        //let payloadPath = response.data.path;
        //commit('newFoto', payloadPath)
        
        return response.data
      }).catch(error => {
        console.log(error)
      })
  };

  const loadCandidaturas = async ({commit, state}) => {
  
    const token = state.auth.token;
    return await axios({ url: candidaturas_uri + '?token='+ token, method: 'GET' })
      .then(response => {
        
        let payloadVagasCandidaturas = [];
        payloadVagasCandidaturas = response.data.vagasCandidaturas;

        let payloadCandidaturas = [];
        payloadCandidaturas = response.data.candidaturas;

        let payloadCountCandidaturas = {
          'candidaturas': response.data.countCandidaturas,
          'candidaturasEmAgendamento': response.data.countCandidaturasEmAgendamento,
          'candidaturasConfirmadas':  response.data.countCandidaturasConfirmadas,
        }
  

          if(payloadVagasCandidaturas){
            commit('vagasCandidaturas', payloadVagasCandidaturas)
          }

          if(payloadCandidaturas){
            commit('candidaturas', payloadCandidaturas)
          }

          commit('countCandidaturas', payloadCountCandidaturas)

        return response.data
      }).catch(error => {
        console.log(error)
      })
    };

    const deleteCandidatura = async ({commit, state}, candidatura_id) => {

      const token = state.auth.token;
      return await axios({ url: candidaturas_uri + '/' + candidatura_id + '?token='+ token, method: 'DELETE' })
      .then(response => {
         let payloadDeleteCandidatura = {
           'candidatura_id': candidatura_id,
           'role': response.data.role
         }
         commit('deleteCandidatura', payloadDeleteCandidatura);
         return response;
      })
      .catch(
          error => console.log(error)
      );
    };

    const searchVagas = async ({commit, state}, keywords) => {
  
      const token = state.auth.token;
      return await axios({ url: 'http://localhost:8000/api/buscaVagas/' + keywords + '?token='+ token, method: 'GET' })
        .then(response => {
          let payloadResultados = [];

          payloadResultados = response.data;
          commit('buscaVagas', payloadResultados)
          return response.data
        }).catch(error => {
          console.log(error)
        })
    };

    const searchVagasAvancadas = async ({commit, state}, pesquisa) => {
  
      const token = state.auth.token;
      if (pesquisa.keywords==''){
        pesquisa.keywords='undefined';
      }
      if (pesquisa.cargo==''){
        pesquisa.cargo='undefined';
      }
      if (pesquisa.beneficio==''){
        pesquisa.beneficio='undefined';
      }
      if (pesquisa.jornada==''){
        pesquisa.jornada='undefined';
      }
      if (pesquisa.requisitos==''){
        pesquisa.requisitos='undefined';
      }
      if (pesquisa.area==''){
        pesquisa.area='undefined';
      }
      return await axios({ url: 'http://localhost:8000/api/buscaVagasAvancadas/' + pesquisa.keywords + '/' + pesquisa.cargo + '/' + pesquisa.beneficio + '/' + pesquisa.jornada + '/' + pesquisa.requisitos + '/' + pesquisa.area + '?token='+ token, method: 'GET' })
        .then(response => {
          let payloadResultados = [];

          payloadResultados = response.data;
          commit('buscaVagas', payloadResultados)
          return response.data
        }).catch(error => {
          console.log(error)
        })
    };

    const searchCurriculos = async ({commit, state}, keywords) => {
  
      const token = state.auth.token;
      return await axios({ url: 'http://localhost:8000/api/buscaCurriculos/' + keywords + '?token='+ token, method: 'GET' })
        .then(response => {
          let payloadResultados = [];

          payloadResultados = response.data;
          commit('buscaVagas', payloadResultados)
          return response.data
        }).catch(error => {
          console.log(error)
        })
    };

    const searchCurriculosAvancadas = async ({commit, state}, pesquisa) => {
  
      const token = state.auth.token;
      if (pesquisa.keywords==''){
        pesquisa.keywords='undefined';
      }
      if (pesquisa.escolaridade==''){
        pesquisa.escolaridade='undefined';
      }
      if (pesquisa.objetivos==''){
        pesquisa.objetivos='undefined';
      }
      if (pesquisa.historicoProfissional==''){
        pesquisa.historicoProfissional='undefined';
      }
      if (pesquisa.cidade==''){
        pesquisa.cidade='undefined';
      }
      if (pesquisa.nome==''){
        pesquisa.nome='undefined';
      }
      if (pesquisa.area==''){
        pesquisa.area='undefined';
      }
      return await axios({ url: 'http://localhost:8000/api/buscaCurriculosAvancadas/' + pesquisa.keywords + '/' + pesquisa.escolaridade + '/' + pesquisa.objetivos + '/' + pesquisa.historicoProfissional + '/' + pesquisa.cidade + '/' + pesquisa.nome + '/' + pesquisa.area + '?token='+ token, method: 'GET' })
        .then(response => {
          let payloadResultados = [];

          payloadResultados = response.data;
          commit('buscaVagas', payloadResultados)
          return response.data
        }).catch(error => {
          console.log(error)
        })
    };

    const getVagasRecomendadas = async ({commit, state}) => {
  
      const token = state.auth.token;
      const userId = state.auth.user.id;
      return await axios({ url: 'http://localhost:8000/api/buscaVagasRecomendadas/' + userId + '?token=' + token, method: 'GET' })
        .then(response => {
          let payloadVagasJuridica = [];

          payloadVagasJuridica = response.data;
          commit('vagasJuridica', payloadVagasJuridica)
          return response.data
        }).catch(error => {
          console.log(error)
        })
    };
   
  const newAgenda = async ({state, commit}, newAgendaData) => {
    
    const token = state.auth.token;
    return await axios({ url: agenda_uri + '?token=' + token, data: newAgendaData, method: 'POST' })
    .then(response => {

      if(response.data.countCandidaturasEmAgendamento){
        
        let payloadCountCandidaturas = {
          'candidaturas': state.count.candidaturas,
          'candidaturasEmAgendamento': response.data.countCandidaturasEmAgendamento,
          'candidaturasConfirmadas':  state.count.candidaturasConfirmadas,
        }
        commit('countCandidaturas', payloadCountCandidaturas);
      }
  
      return response.data

    }).catch(error => {
      console.log(error)
    })

  };

  const loadAgenda = async ({commit, state}) => {
  
    const token = state.auth.token;
    return await axios({ url: agenda_uri + '?token='+ token, method: 'GET' })
      .then(response => {
        
        let payloadAgenda = [];
        payloadAgenda = response.data.agenda;
        commit('agenda', payloadAgenda)

        return response.data
      }).catch(error => {
        console.log(error)
      })
    };

    const updateAgenda = async({commit, state}, newAgendaData) => {
    
      const token = state.auth.token;
      return await axios({ url: agenda_uri + '/'+ newAgendaData.update_id + '?token=' + token, data: newAgendaData, method: 'PUT' })
        .then(response => {
          
         
          return response.data
        })
        .catch(error => {
          console.log(error)
        }) 
  
    };

  const confirmAgenda = async ({state, commit}, candidatura_id) => {
    
      const token = state.auth.token;
      return await axios({ url: 'http://localhost:8000/api/confirmAgenda?token=' + token, data: candidatura_id, method: 'POST' })
      .then(response => {

        let payloadAgenda = [];
        payloadAgenda = response.data.agenda;
        commit('agenda', payloadAgenda)
        if(response.data.candidaturas){
          commit('candidaturas', response.data.candidaturas) 
        }
        
        return response.data
      }).catch(error => {
        console.log(error)
      })
  
  };
    
  const cancelAgenda = async ({commit, state}, cancelAgenda) => {

    const token = state.auth.token;
    return await axios({ url: 'http://localhost:8000/api/cancelAgenda?token=' + token, data: cancelAgenda, method: 'POST' })
    .then(response => {
    
       let payloadAgendaId = { 
         'role': response.data.role,
         'agenda_id': response.data.agenda_id,
         'candidatura_id': cancelAgenda.candidatura_id
       }
    
        commit('cancelAgenda', payloadAgendaId);
      

       return response;
    })
    .catch(
        error => console.log(error)
    );
  };

  const getVagasPorcentagem = async ({commit, state}) => {

    const token = state.auth.token;
    return await axios({ url: 'http://localhost:8000/api/vagasPorcentagem?token=' + token, method: 'GET' })
    .then(response => {
      
      let payloadProgressBar = [];
      payloadProgressBar = response.data;
      commit('progressBar', payloadProgressBar);
       return response;
    })
    .catch(
        error => console.log(error)
    );
  };

  const updateUserFisica = async({commit, state}, attUserFisica) => {
    
    const token = state.auth.token;
    return await axios({ url: 'http://localhost:8000/api/updateDadosCadastroFisica?token='+token, data: attUserFisica, method: 'POST' })
      .then(response => {
        if(!response.data.error){
          let payloadUserFisica = [];
          payloadUserFisica = response.data;
          commit('attUserFisica', payloadUserFisica);
        }
        return response.data
      })
      .catch(error => {
        console.log(error)
      }) 

  };

  const updateUserJuridica = async({commit, state}, attUserJuridica) => {
    
    const token = state.auth.token;
    return await axios({ url: 'http://localhost:8000/api/updateDadosCadastroJuridica?token='+token, data: attUserJuridica, method: 'POST' })
      .then(response => {
        if(!response.data.error){
          let payloadUserJuridica = [];
          payloadUserJuridica = response.data;
          commit('attUserJuridica', payloadUserJuridica);
        }
        return response.data
      })
      .catch(error => {
        console.log(error)
      }) 

  };

  const requestConvite = async ({commit, state}, requestConvite) => {
    const token = state.auth.token;
    return await axios({ url:'http://localhost:8000/api/createConvite?token='+token, data: requestConvite, method: 'POST'})
    .then(response => {

     

      return response.data
    }).catch(
      error => console.log(error)
    );
  
  };

  const getConvites = async ({commit, state}) => {

    const token = state.auth.token;
    return await axios({ url: 'http://localhost:8000/api/getConvites?token=' + token, method: 'GET' })
    .then(response => {

      let payloadVagasConvites = [];
      payloadVagasConvites = response.data.vagasConvites;

      let payloadConvites = [];
      payloadConvites = response.data.convites;

      let payloadCountConvites = {
        'convites': response.data.countConvites,
        'convitesAguardando': response.data.countConvitesAguardando,
        'convitesConfirmados':  response.data.countConvitesConfirmados,
        'convitesNegados': response.data.countConvitesNegados,
      }

      
      if(payloadVagasConvites){
        commit('vagasConvites', payloadVagasConvites)
      }

      if(payloadConvites){
        commit('attConvites', payloadConvites);
      }

      commit('countConvites', payloadCountConvites)
      
      
      
       return response;
    })
    .catch(
        error => console.log(error)
    );
  };

  const respondeConvite = async ({commit, state}, respostaConvite) => {
    const token = state.auth.token;
    return await axios({ url:'http://localhost:8000/api/respostaConvite?token='+token, data: respostaConvite, method: 'POST'})
    .then(response => {
      let payloadConvites = [];
      payloadConvites = response.data.convites.original.convites;
      commit('attConvites', payloadConvites);
     

      return response.data
    }).catch(
      error => console.log(error)
    );
  
  };

  const cancelaConvite = async ({commit, state}, cancelConvite) => {
    const token = state.auth.token;
    
    return await axios({ url:'http://localhost:8000/api/cancelarConvite?token='+token, data: cancelConvite, method: 'POST'})
    .then(response => {
      let payloadConvites = [];
      payloadConvites = response.data.convites.original.convites;
      commit('attConvites', payloadConvites);
     

      return response.data
    }).catch(
      error => console.log(error)
    );
  
  };

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
    deactivateAccount,
    activateAccount,
    createVaga,
    updateVaga,
    requestVaga,
    requestVagaDash,
    loadVagasJuridica,
    changeStatusVaga,
    deleteVaga,
    updateFoto,
    deleteUserPhoto,
    loadArea,
    loadCandidaturas,
    deleteCandidatura,
    searchVagas,
    searchVagasAvancadas,
    searchCurriculos,
    searchCurriculosAvancadas,
    getVagasRecomendadas,
    newAgenda,
    loadAgenda,
    updateAgenda,
    confirmAgenda,
    cancelAgenda,
    getVagasPorcentagem,
    updateUserFisica,
    updateUserJuridica,
    requestConvite,
    getConvites,
    respondeConvite,
    cancelaConvite
  
  };