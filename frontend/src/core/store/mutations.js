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
        state.candidaturas = []
        state.convites = []
        state.vagas = []
        state.counter = {}
    },
    [mutationTypes.AUTH_ERROR](state){
        state.auth.status = 'error'
    },
    [mutationTypes.UPDATE_AUTH_USER](state, payload){
        state.auth.user = payload
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
    [mutationTypes.SET_VAGAS_COM_CANDIDATURAS](state, vagasComCandidaturas){
        state.vagasComCandidaturas = vagasComCandidaturas
    },
    [mutationTypes.SET_CONVITES](state, payload){
        state.convites = payload
    },
    [mutationTypes.SET_VAGAS_COM_CONVITES](state, vagasComConvites){
        state.vagasComConvites = vagasComConvites
    },
    [mutationTypes.SET_COUNTER_CONVITES](state, payload){
        state.counter.convites = payload
    },
    [mutationTypes.SET_CANDIDATURAS](state, payload){
        state.candidaturas = payload
    },
    [mutationTypes.SET_PROGRESS_BAR](state, payload){
        state.progressBar = payload
    },
    [mutationTypes.SET_VAGAS](state, payload){
        state.vagas = payload
    },
    [mutationTypes.SET_AGENDA](state, payload){
        state.agenda = payload
    },
    [mutationTypes.SET_COUNTER_AGENDA](state, payload){
        console.log('VEIO NO MUT DO COUNTER')
        state.counter.agenda = payload
    },
    [mutationTypes.SET_COUNTER_VAGAS_ATIVAS](state, payload){
        state.counter.vagasAtivas = payload
    },
    [mutationTypes.SET_COUNTER_CANDIDATURAS](state, payload){
        state.counter.candidaturas = payload
    },
    [mutationTypes.DELETE_CANDIDATURA_CANCELADA](state, payload){
        if(payload.role == 'FISICA'){
            let index = state.candidaturas.findIndex(candidatura => candidatura.id == payload.candidaturaId)
            state.candidaturas.splice(index, 1)
        }else{
            let index = state.agendas.findIndex(agenda => agenda.candidatura_id == payload.candidaturaId)
            state.candidaturas.splice(index, 1)
        }
    },
    [mutationTypes.JURIDICA_USERS](state, payload){
        state.juridicaUsers = payload
    },
    [mutationTypes.UPDATE_FISICA_USER_DATA](state, payload){
        state.pessoaFisicaInfo.cpf = payload.cpf 
        state.auth.user.email = payload.email
    },
    [mutationTypes.UPDATE_JURIDICA_USER_DATA](state, payload){
        state.pessoaJuridicaInfo.cnpj = payload.cnpj
        state.auth.user.email = payload.email
    },
    [mutationTypes.SET_RESULTADO](state, payload){
        state.resultado = payload
    },
}