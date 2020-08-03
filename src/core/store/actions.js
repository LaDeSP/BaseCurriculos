import {actionTypes, mutationTypes} from '../constants'
import api from '../api'

export default {
    async [actionTypes.LOGIN]({commit}, user){
        const response = await api.auth.login(user)
        console.log('heheheheh', response)
        const payload = {
            'path': response.data.foto, 
            'token': response.data.token,
            'user': response.data.user
        }
        commit(mutationTypes.AUTH_SUCCESS, payload)
        return response.data
    },
    async [actionTypes.LOGOUT]({commit}){
        await api.auth.logout()
        commit(mutationTypes.LOGOUT)
        commit(mutationTypes.SET_DATA_COMPLETED)
        Cookies.remove('vuex')
    },
    async [actionTypes.CREATE_PESSOA_FISICA]({commit, dispatch}, pessoaFisicaData){
        const response = await api.pessoaFisica.createPessoaFisica(pessoaFisicaData)
        await dispatch(actionTypes.LOGIN, response)
    },
    async [actionTypes.CREATE_PESSOA_JURIDICA]({commit, dispatch}, pessoaJuridicaData){
        const response = await api.pessoaFisica.createPessoaFisica(pessoaJuridicaData)
        await dispatch(actionTypes.LOGIN, response)
    },
    async [actionTypes.COMPLETE_PESSOA_FISICA]({commit}, completedPessoaFisicaData){
        const response = await api.pessoaFisica.completePessoaFisicaData(completedPessoaFisicaData)
        let contatoPayload, enderecoPayload, curriculoPayload
        contatoPayload = {
            'celular': completedPessoaFisicaData.celular,
            'fixo': completedPessoaFisicaData.fixo,
            'facebook': completedPessoaFisicaData.facebook,
            'twitter': completedPessoaFisicaData.twitter,
            'site': completedPessoaFisicaData.site,
            'linkedin': completedPessoaFisicaData.linkedin,
        }
        enderecoPayload = {
            'estado': completedPessoaFisicaData.estado,
            'rua': completedPessoaFisicaData.rua,
            'bairro': completedPessoaFisicaData.bairro,
            'cidade': completedPessoaFisicaData.cidade,
            'cep': completedPessoaFisicaData.cep,
            'complemento': completedPessoaFisicaData.complemento,
            'numero': completedPessoaFisicaData.numero,
            'pais': completedPessoaFisicaData.pais
        }
        curriculoPayload = {
            'nome': completedPessoaFisicaData.nome,
            'nascimento': completedPessoaFisicaData.nascimento,
            'genero': completedPessoaFisicaData.genero,
            'estadoCivil': completedPessoaFisicaData.estadoCivil,
            'objetivos': completedPessoaFisicaData.objetivos,
            'pretensao': completedPessoaFisicaData.pretensao,
            'qualificacoes': completedPessoaFisicaData.qualificacoes,
            'escolaridade': completedPessoaFisicaData.escolaridade,
            'area': completedPessoaFisicaData.area,
            'historicoProfissional': completedPessoaFisicaData.historicoProfissional
        }
        commit(mutationTypes.SET_CONTATO, contatoPayload)
        commit(mutationTypes.SET_ENDERECO, enderecoPayload)
        commit(mutationTypes.COMPLETE_FISICA_DATA, curriculoPayload)
        //QUASE CERTEZA DE QUE NAO PRECISO DE TUDO ISSO, SO PRECISO DE DATA COMPLETED...
        commit(mutationTypes.SET_DATA_COMPLETED)
        return response
    },
    async [actionTypes.COMPLETE_PESSOA_JURIDICA]({commit}, completedPessoaJuridicaData){
        const response = await api.pessoaJuridica.completePessoaJuridicaData(completedPessoaJuridicaData)
        let contatoPayload, enderecoPayload, pessoaJuridicaPayload
        contatoPayload = {
            'celular': completedPessoaJuridicaData.celular,
            'fixo': completedPessoaJuridicaData.fixo,
            'facebook': completedPessoaJuridicaData.facebook,
            'twitter': completedPessoaJuridicaData.twitter,
            'site': completedPessoaJuridicaData.site,
            'linkedin': completedPessoaJuridicaData.linkedin,
        }
        enderecoPayload = {
            'estado': completedPessoaJuridicaData.estado,
            'rua': completedPessoaJuridicaData.rua,
            'bairro': completedPessoaJuridicaData.bairro,
            'cidade': completedPessoaJuridicaData.cidade,
            'cep': completedPessoaJuridicaData.cep,
            'complemento': completedPessoaJuridicaData.complemento,
            'numero': completedPessoaJuridicaData.numero,
            'pais': completedPessoaJuridicaData.pais
        }
        pessoaJuridicaPayload = {
            'name': completeJuridicaData.name,
        } 
        commit(mutationTypes.SET_CONTATO, contatoPayload)
        commit(mutationTypes.SET_ENDERECO, enderecoPayload)
        commit(mutationTypes.COMPLETE_JURIDICA_DATA, pessoaJuridicaPayload)
        //QUASE CERTEZA DE QUE NAO PRECISO DE TUDO ISSO, SO PRECISO DE DATA COMPLETED...
        commit(mutationTypes.SET_DATA_COMPLETED)
        return response
    },
}