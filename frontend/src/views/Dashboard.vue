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
              <FormPessoaFisicaCurriculo :edicao="false"></FormPessoaFisicaCurriculo>  
            </template>
          </v-col>
        </template>
        <template v-else-if="tipoPermissao == 'JURIDICA'">
        <v-row align="center" justify="center">  
          <span class="pagina"><v-icon class="pagina">fas fa-home fa-lg</v-icon> Home</span>
          <TopCards></TopCards>
          <v-row justify="center">
            <v-col cols="10" lg="6" md="8" sm="8">
              <ProcessosEmAndamento></ProcessosEmAndamento>
            </v-col>
            <v-col cols="10" lg="6" md="8" sm="8">
              <StatusEntrevistas></StatusEntrevistas>
            </v-col>
          </v-row>
        </v-row>    
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

import {actionTypes} from '@/core/constants'
import {mapState, mapGetters} from 'vuex'

export default {
  components:{
    MinhasCandidaturas, MeusConvites, 
    VagasRecomendadas, ProcessosEmAndamento,
    StatusEntrevistas, TopCards, FormPessoaFisicaCurriculo
  },
  data(){
    return {
      notificacao: '',
      isLoaded: false
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
    setNotificacoes(){
      if(this.$route.params.cadastroFisicaSucesso){
        this.notificacao = 'Cadastro realizado com sucesso!'
      }else if(this.$route.params.cadastroCurriculoSucesso){
        this.notificacao = 'Seu currículo foi cadastrado com sucesso!'
      }
    },
    async loadUserData(){
      await this.$store.dispatch(actionTypes.GET_PESSOA_FISICA)
        .then(response => {
          this.isLoaded = true
        }).catch(error => console.log(error))
    }
  }
}
</script>

<style lang="stylus">
  .pagina 
    font-size 30px
</style>