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
            <ConvitesJuridica @handlePayload="getPayload"></ConvitesJuridica>
          </template> 
          <template v-else>
            <ConvitesJuridicaTab :vagaId="vagaId"></ConvitesJuridicaTab>
          </template>
        </template>
        <template v-else-if="tipoPermissao == 'FISICA'">
          <ConvitesFisica></ConvitesFisica>
        </template>
      </v-card>
    </v-col>
 </v-row>
</template>

<script>
import ConvitesJuridica from '@/components/Convites/ConvitesJuridica'
import ConvitesFisica from '@/components/Convites/ConvitesFisica'
import ConvitesJuridicaTab from '@/components/Convites/JuridicaComponents/ConvitesJuridicaTab'
import {actionTypes} from '@/core/constants'
import {mapState, mapGetters} from 'vuex'

export default {
  components: {ConvitesFisica, ConvitesJuridica, ConvitesJuridicaTab},
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
    await this.$store.dispatch(actionTypes.GET_TODOS_CONVITES)
    if(this.tipoPermissao == 'FISICA'){
      this.title = 'Convites'
      this.isLoaded = true
      this.candidaturasData = this.candidaturas
    }else if(this.tipoPermissao == 'JURIDICA'){
      this.title = 'Meus Convites'
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