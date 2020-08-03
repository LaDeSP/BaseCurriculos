import {mutationTypes} from '../constants'

export default {
    [mutationTypes.SET_LOADING_SCREEN](state, status){
        state.isLoading = status
    },
    [mutationTypes.AUTH_SUCCESS](state, {payload}){
        state.auth.status = 'success'
        state.auth.token = payload.token
        state.auth.user = payload.user
        state.upload.path = payload.path
    },
    [mutationTypes.AUTH_ERROR](state){
        state.auth.status = 'error'
    },
    [mutationTypes.LOGOUT](state){
        state.auth.user = {},
        state.auth.status = ''
        state.auth.token = ''
    },
    [mutationTypes.SET_DATA_COMPLETED](state){
        state.dataCompleted = !state.dataCompleted
    },
    [mutationTypes.SET_CONTATO](state, contatoPayload){
        state.contact.celular = contatoPayload.celular
        state.contact.fixo = contatoPayload.fixo
        state.contact.facebook = contatoPayload.facebook
        state.contact.twitter = contatoPayload.twitter
        state.contact.site = contatoPayload.site
        state.contact.linkedin = contatoPayload.linkedin  
    },
    [mutationTypes.SET_ENDERECO](state, enderecoPayload){
        state.address.rua = enderecoPayload.rua
        state.address.bairro = enderecoPayload.bairro
        state.address.cidade = enderecoPayload.cidade
        state.address.numero = enderecoPayload.numero
        state.address.complemento = enderecoPayload.complemento
        state.address.cep = enderecoPayload.cep
        state.address.pais = enderecoPayload.pais
        state.address.estado = enderecoPayload.estado
    },
    [mutationTypes.COMPLETE_FISICA_DATA](state, pessoaFisicaPayload){
        state.auth.user.name = pessoaFisicaPayload.nome
        state.pessoaFisica.nascimento = pessoaFisicaPayload.nascimento
        state.pessoaFisica.genero = pessoaFisicaPayload.genero
        state.pessoaFisica.estadoCivil = pessoaFisicaPayload.estadoCivil
        state.pessoaFisica.cpf = pessoaFisicaPayload.cpf
        state.pessoaFisica.area.nome = pessoaFisicaPayload.area  
        state.pessoaFisica.area.id = pessoaFisicaPayload.area_id  
        state.pessoaFisica.pretensao = pessoaFisicaPayload.pretensao  
        state.pessoaFisica.qualificacoes = pessoaFisicaPayload.qualificacoes  
        state.pessoaFisica.historicoProfissional = pessoaFisicaPayload.historicoProfissional  
        state.pessoaFisica.objetivos = pessoaFisicaPayload.objetivos  
        state.pessoaFisica.escolaridade = pessoaFisicaPayload.escolaridade
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
    }
}