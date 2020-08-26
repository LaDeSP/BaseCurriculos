<template>
 <v-row align="center" justify="center" v-if="isLoaded">
    <v-col cols="12" lg="12" md="12" sm="10">
      <template v-if="toggle">
        <v-btn class="mr-1" @click="toggle = false">
          <v-icon class="pr-1">mdi-arrow-left-circle</v-icon> Voltar
        </v-btn>
      </template>
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-card justify="center" align="center">
        <v-card-title class="text-center justify-center py-6">
          <h1>{{title}}</h1>
        </v-card-title>
        <template v-if="tipoPermissao == 'JURIDICA'">
          <template v-if="!toggle">
            <CandidaturasJuridica @handlePayload="getPayload"></CandidaturasJuridica>
          </template> 
          <template v-else>
            <CandidatosJuridicaTab :vagaId="vagaId"></CandidatosJuridicaTab>
          </template>
        </template>
        <template v-else-if="tipoPermissao == 'FISICA'">
          <CandidaturasFisica></CandidaturasFisica>
        </template>
      </v-card>
    </v-col>
 </v-row>
</template>

<script>
import CandidaturasJuridica from '@/components/Candidaturas/CandidaturasJuridica'
import CandidaturasFisica from '@/components/Candidaturas/CandidaturasFisica'
import CandidatosJuridicaTab from '@/components/Candidaturas/JuridicaComponents/CandidatosJuridicaTab'
import {actionTypes} from '@/core/constants'
import {mapState, mapGetters} from 'vuex'
import ModalAlert from '../components/Utils/ModalAlert'
import ModalDetalhes from '../components/Utils/ModalDetalhes'

export default {
  components: {CandidaturasFisica, ModalAlert, ModalDetalhes, CandidaturasJuridica, CandidatosJuridicaTab},
  data(){
    return{
      isLoaded: false,
      title: '',
      tab: null, 
      toggle: false,
      candidaturasData: [],
      statusCandidatura: '',
      verAgendamento: {
        'buttonText': 'Ver Agendamento',
        'title': 'Detalhes do Agendamento',
        'action': 'ver agendamento'
      },
      cancelarCandidatura: {
        'title': 'Cancelar Candidatura',
        'action': 'cancelar candidatura'
      },
      cancelarEntrevista: {
        'title': 'Cancelar Entrevista',
        'action': 'cancelar entrevista'
      },
      active: 'TODAS'
    }
  },
  async created(){
    await this.$store.dispatch(actionTypes.GET_CANDIDATURAS)
    if(this.tipoPermissao == 'FISICA'){
      this.title = 'Minhas Candidaturas'
      this.toggle = true
      this.isLoaded = true
      this.candidaturasData = this.candidaturas
    }else if(this.tipoPermissao == 'JURIDICA'){
      this.title = 'Candidaturas'
      this.isLoaded =true
    }
  },
  computed: {
    ...mapState(['candidaturas']),
    ...mapGetters([
      'tipoPermissao', 'getCandidaturasFiltradas', 'getCandidaturasFinalizadas',
      'getVagasAtivas', 'getVagasThatHaveCandidaturas'
    ]),
    getCandidaturas(){
      if(this.active == 'TODAS'){
        return this.candidaturas
      }else if(status == 'FINALIZADAS'){
        return this.getCandidaturasFinalizadas(this.active)
      }else{
        return this.getCandidaturasFiltradas(this.active)
      }
    }
  },
  methods: {
    getPayload(payload){
      this.vagaId = payload.vagaId 
      this.toggle = payload.toggle
    }
  }
}
</script>

<style lang="stylus" scoped>
  .dados 
    font-size 15px
</style>