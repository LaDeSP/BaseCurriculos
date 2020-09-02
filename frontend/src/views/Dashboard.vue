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
            <template v-if="isLoaded && dataCompleted">
              <MinhasCandidaturas></MinhasCandidaturas>
              <MeusConvites></MeusConvites>
              <VagasRecomendadas></VagasRecomendadas>
            </template>
             <template v-else-if="isLoaded && !dataCompleted">
              <h1 class="text-center justify-center">Complete seus dados para continuar!</h1>
              <FormPessoaFisicaCurriculo :edicao="false" @isDataCompleted="getDataFlag"></FormPessoaFisicaCurriculo>  
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
              <v-col cols="10" lg="10" md="6" sm="8">
                <h1 class="text-center justify-center">Complete seus dados para continuar!</h1>
                <FormPessoaJuridicaData @handleNotifSuccess="getNotifSuccess"></FormPessoaJuridicaData>
              </v-col>
            </template>
          </v-row>    
          <template v-if="isLoaded && dataCompleted && !hasVaga">
            <v-col cols="10" lg="10" md="6" sm="8">
              <FormCreateVaga :title="titlePrimeiraVaga"></FormCreateVaga>
            </v-col>
          </template>
        </template>
        <template v-else-if="tipoPermissao == 'MASTER'">
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
      hasVaga: false,
      isLoaded: false,
      titlePrimeiraVaga: 'Que tal cadastrar sua primeira vaga?'
    }
  },
  async created(){
    this.setNotificacoes()
    await this.loadUserData()
  },
  computed: {
    ...mapState(['dataCompleted']), 
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
          await this.$store.dispatch(actionTypes.GET_CANDIDATURAS)
          await this.$store.dispatch(actionTypes.GET_VAGAS_RECOMENDADAS)
          await this.$store.dispatch(actionTypes.GET_TODOS_CONVITES)
        }
        this.isLoaded = true
      }else if(this.tipoPermissao == 'JURIDICA'){
        await this.$store.dispatch(actionTypes.GET_PESSOA_JURIDICA)
        if(this.dataCompleted){
          await this.$store.dispatch(actionTypes.GET_VAGAS_JURIDICAS)
            .then(response => {
              if(response.vagas.length > 0) this.hasVaga = true 
            })
          await this.$store.dispatch(actionTypes.GET_CANDIDATURAS)
          await this.$store.dispatch(actionTypes.GET_AGENDA)
          await this.$store.dispatch(actionTypes.GET_TODOS_CONVITES)
          await this.$store.dispatch(actionTypes.GET_PORCENTAGEM_VAGAS)
        }
        this.isLoaded = true
      }      
    },
    async getDataFlag(value){
      if(value){
        this.notificacao = 'Seu currículo foi cadastrado com sucesso!'
        await this.$store.dispatch(actionTypes.GET_VAGAS_RECOMENDADAS)
      }
    },
    getNotifSuccess(value){
      console.log('get not if siuccess dash', value)
      this.notificacao = value
    }
  }
}
</script>

<style lang="stylus">
  .pagina 
    font-size 30px
  .trocaPagina
    padding 100px 0
    margin-right 0
  .pagination 
    display --webkit-box 
    display -ms-flexbox 
    display flex
    padding-left 0 
    list-style none 
    border-radius 0.35rem 
  .page-link 
    position relative 
    display block 
    padding 0.5rem 0.75rem 
    margin-left -1px 
    line-height 1.25 
    color #4e73df 
    background-color #fff 
    border 1px solid #dddfeb 
  .page-link:hover 
    z-index: 2 
    color #224abe 
    text-decoration none 
    background-color #eaecf4 
    border-color #dddfeb 
  .page-link:focus 
    z-index 2 
    outline 0 
    -webkit-box-shadow 0 0 0 0.2rem rgba(78, 115, 223, 0.25)
    box-shadow 0 0 0 0.2rem rgba(78, 115, 223, 0.25)
  .page-item:first-child .page-link 
    margin-left 0 
    border-top-left-radius 0.35rem 
    border-bottom-left-radius 0.35rem 
  .page-item:last-child .page-link 
    border-top-right-radius 0.35rem 
    border-bottom-right-radius 0.35rem 
  .page-item.active .page-link 
    z-index 1
    color #fff 
    background-color #4e73df 
    border-color: #4e73df 
  .page-item.disabled .page-link 
    color #858796 
    pointer-events none 
    cursor auto 
    background-color #fff 
    border-color #dddfeb 
  .pagination-lg .page-link 
    padding 0.75rem 1.5rem 
    font-size 1.25rem 
    line-height 1.5 
  .pagination-lg .page-item:first-child .page-link 
    border-top-left-radius 0.3rem 
    border-bottom-left-radius 0.3rem 
  .pagination-lg .page-item:last-child .page-link 
    border-top-right-radius 0.3rem 
    border-bottom-right-radius 0.3rem 
  .pagination-sm .page-link 
    padding 0.25rem 0.5rem 
    font-size 0.875rem
    line-height 1.5 
  .pagination-sm .page-item:first-child .page-link 
    border-top-left-radius 0.2rem 
    border-bottom-left-radius 0.2rem 
  .pagination-sm .page-item:last-child .page-link 
    border-top-right-radius 0.2rem 
    border-bottom-right-radius 0.2rem
</style>