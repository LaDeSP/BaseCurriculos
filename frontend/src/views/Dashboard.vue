<template>
  <v-row align="center" justify="center">
      <v-col cols="10" lg="8" md="8" sm="10" xs="2">
        <span v-if="notificacao">
          <v-alert type="success">
            {{notificacao}}
          </v-alert>
        </span>
      </v-col>
        <template v-if="tipoPermissao == 'FISICA'">
          <v-col cols="10" lg="8" md="12" sm="12" xs="2">
            <template v-if="isLoaded && dataCompleted && refresh">
              <MinhasCandidaturas></MinhasCandidaturas>
              <MeusConvites></MeusConvites>
              <VagasRecomendadas></VagasRecomendadas>
            </template>
             <template v-else-if="isLoaded && !refresh">
              <h1 class="text-center justify-center">Complete seus dados para continuar!</h1>
              <FormPessoaFisicaCurriculo :toggle="true" :edicao="false" @data-completed="getDataFlag"></FormPessoaFisicaCurriculo>  
            </template>
          </v-col>
        </template>
        <template v-else-if="tipoPermissao == 'JURIDICA'">
          <v-row align="center" justify="center">  
            <template v-if="isLoaded && dataCompleted && hasVaga">
              <span class="pagina"><v-icon class="pagina">fas fa-home fa-lg</v-icon> Home</span>
              <TopCards></TopCards>
              <v-row justify="center">
                <v-col cols="10" lg="6" md="6" sm="8">
                  <ProcessosEmAndamento></ProcessosEmAndamento>
                </v-col>
                <v-col cols="10" lg="6" md="6" sm="8">
                  <StatusEntrevistas></StatusEntrevistas>
                </v-col>
              </v-row>
            </template>
            <template v-else-if="isLoaded && !dataCompleted">
              <v-col cols="10" lg="10" md="10" sm="8">
                <h1 class="text-center justify-center">Complete seus dados para continuar!</h1>
                <FormPessoaJuridicaData @handleNotifSuccess="getNotifSuccess"></FormPessoaJuridicaData>
              </v-col>
            </template>
          </v-row>    
          <template v-if="isLoaded && dataCompleted && !hasVaga">
            <v-col cols="10" lg="10" md="10" sm="10">
              <FormCreateVaga :title="titlePrimeiraVaga"></FormCreateVaga>
            </v-col>
          </template>
        </template>
        <template v-if="isLoaded && tipoPermissao == 'MASTER'">
          <TopCardsMaster></TopCardsMaster>
        </template>
  </v-row>
</template>

<script>
import MinhasCandidaturas from '../components/Dashboards/Fisica/MinhasCandidaturasDashFisica'
import MeusConvites from '../components/Dashboards/Fisica/MeusConvitesDashFisica'
import VagasRecomendadas from '../components/Dashboards/Fisica/VagasDashFisica'
import ProcessosEmAndamento from '@/components/Dashboards/Juridica/ProcessosEmAndamento'
import StatusEntrevistas from '@/components/Dashboards/Juridica/StatusEntrevistas'
import TopCards from '@/components/Dashboards/Juridica/TopCards'
import FormPessoaFisicaCurriculo from '@/components/Forms/FormPessoaFisicaCurriculo'
import FormPessoaJuridicaData from '@/components/Forms/FormPessoaJuridicaData'
import FormCreateVaga from '@/components/Forms/FormCreateVaga'
import TopCardsMaster from '@/components/Dashboards/Master/TopCardsMaster'

import {actionTypes} from '@/core/constants'
import {mapState, mapGetters, mapActions} from 'vuex'

export default {
  components:{
    MinhasCandidaturas, MeusConvites, 
    VagasRecomendadas, ProcessosEmAndamento,
    StatusEntrevistas, TopCards, FormPessoaFisicaCurriculo, 
    FormPessoaJuridicaData, TopCardsMaster, FormCreateVaga
  },
  data(){
    return {
      notificacao: '',
      isLoaded: false,
      refresh: false,
      titlePrimeiraVaga: 'Que tal cadastrar sua primeira vaga?'
    }
  },
  async created(){
    this.setNotificacoes()
    await this.loadUserData()
  },
  computed: {
    ...mapState(['auth', 'dataCompleted', 'hasVaga']), 
    ...mapGetters(['tipoPermissao'])
  }, 
  methods: {
    async setNotificacoes(){
      if(this.$route.params.cadastroFisicaSucesso){
        this.notificacao = 'Cadastro realizado com sucesso!'
      }else if(this.$route.params.cadastroCurriculoSucesso){
        this.notificacao = 'Seu currículo foi cadastrado com sucesso!'
      }else if(this.$route.params.cadastroJuridicaSucesso){
        this.notificacao = 'Cadastro de Pessoa Jurídica realizado com sucesso!'
      }else if(this.$route.params.cadastroJuridicaDataSucesso){
        this.notificacao = 'Dados cadastrados com sucesso!'
      }
    },
    async loadUserData(){
      if(this.tipoPermissao == 'FISICA'){
        console.log('tipo permissao fisica if')
        await this.$store.dispatch(actionTypes.GET_PESSOA_FISICA)
        if(this.dataCompleted){
          console.log('no if, created, data completed, fisica')
          await this.$store.dispatch(actionTypes.GET_CANDIDATURAS)
          await this.$store.dispatch(actionTypes.GET_VAGAS_RECOMENDADAS)
          await this.$store.dispatch(actionTypes.GET_TODOS_CONVITES)
          this.refresh = true
        }
      }else if(this.tipoPermissao == 'JURIDICA'){
        await this.$store.dispatch(actionTypes.GET_PESSOA_JURIDICA)
        if(this.dataCompleted){
          await this.$store.dispatch(actionTypes.GET_VAGAS_JURIDICAS)
          await this.$store.dispatch(actionTypes.GET_CANDIDATURAS)
          await this.$store.dispatch(actionTypes.GET_AGENDA)
          await this.$store.dispatch(actionTypes.GET_TODOS_CONVITES)
          await this.$store.dispatch(actionTypes.GET_PORCENTAGEM_VAGAS)
        }
      }   
      console.log('this tipo permissao', this.tipoPermissao)   
      this.isLoaded = true
    },
    async getDataFlag(value){
      console.log('get data flag', value)
      if(value){
        console.log('gerDaraFkag', value, this.$store.state.auth)
        this.notificacao = 'Seu currículo foi cadastrado com sucesso!'
        await this.$store.dispatch(actionTypes.GET_VAGAS_RECOMENDADAS)
        this.refresh = true
      }
    },
    getNotifSuccess(value){
      console.log('get not if siuccess dash', value)
      this.notificacao = value
    }
  }
}
</script>

