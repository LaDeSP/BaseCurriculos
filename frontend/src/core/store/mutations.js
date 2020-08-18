import {mutationTypes} from '../constants'

export default {
    [mutationTypes.SET_LOADING_SCREEN](state, status){
        state.isLoading = status
    },
    [mutationTypes.LOGIN](state, payload){
        state.auth.isLoggedIn = true
        state.auth.token = payload.token 
        state.auth.user = payload.user
        state.upload.path = payload.path
    },
    [mutationTypes.LOGOUT](state){
        state.auth = {}
        state.upload.path = ''
        state.dataCompleted = false
    },
    [mutationTypes.AUTH_ERROR](state){
        state.auth.status = 'error'
    },
    [mutationTypes.TIPO_PERMISSAO](state, payload){
        state.tipoPermissao = payload
    },
    [mutationTypes.SET_DATA_COMPLETED](state, payload){
        state.dataCompleted = payload
    },
    [mutationTypes.SET_NEW_USER_PIC](state, payload){
        state.upload.path = payload
    },
    [mutationTypes.PESSOA_FISICA_INFO](state, pessoaFisicaPayload){
        state.pessoaFisicaInfo = pessoaFisicaPayload
    },
    [mutationTypes.PESSOA_JURIDICA_INFO](state, pessoaJuridicaPayload){
        state.pessoaJuridicaInfo = pessoaJuridicaPayload
    },
    [mutationTypes.PESSOA_FISICA_CURRICULO](state, pessoaFisicaCurriculoPayload){
        state.pessoaFisicaCurriculo = pessoaFisicaCurriculoPayload
    },
    [mutationTypes.COMPLETE_JURIDICA_DATA](state, pessoaJuridicaPayload){
        if(payloadJuridica.name != undefined) state.auth.user.name = pessoaJuridicaPayload.name
        if(pessoaJuridicaPayload.cnpj != undefined){
            state.pessoaJuridica.cnpj = pessoaJuridicaPayload.cnpj
            state.pessoaJuridica.ramo = pessoaJuridicaPayload.ramo
        }
    },
    [mutationTypes.SET_VAGAS_PESSOA_JURIDICA](state, vagasDaPessoaJuridica){
        state.vagasJuridica = vagasDaPessoaJuridica
    },
    [mutationTypes.SET_CONVITES](state, payload){
        state.convites = payload
    },
    [mutationTypes.SET_CANDIDATURAS_FISICA](state, payload){
        state.candidaturasFisica = payload
    },
    [mutationTypes.SET_VAGAS](state, payload){
        state.vagas = payload
    },
    [mutationTypes.DELETE_CANDIDATURA_CANCELADA](state, payload){
        if(payload.role == 'FISICA'){
            let index = state.candidaturasFisica.findIndex(candidatura => candidatura.id == payload.candidaturaId)
            state.candidaturasFisica.splice(index, 1)
        }else{
            let index = state.agendas.findIndex(agenda => agenda.candidatura_id == payload.candidaturaId)
            state.candidaturas.splice(index, 1)
        }
    },
    [mutationTypes.JURIDICA_USERS](state, payload){
        state.juridicaUsers = payload
    },
}