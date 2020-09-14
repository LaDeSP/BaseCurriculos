<template>
<v-card-text justify="center" align="center">
  <template v-if="!toggle">
    <template v-if="getVagasThatHaveConvites.length == 0">
      <span class="aviso">Não há nenhum convite.</span>
    </template>
    <template v-else>
      <v-row class="my-5" justify="center">
        <v-col class="d-flex flex-column" cols="12" lg="6" md="6" sm="12" v-for="value in pageOfItems" :key="value.id">
          <v-card class="py-2 flex d-flex flex-column">
            <v-card-title class="primary--text text-center justify-center">
              <h3>{{value.vaga.titulo}}</h3>
            </v-card-title>
            <v-card-text class="black--text" align="left">
              <strong>Cargo:</strong> {{value.vaga.cargo}} <br/>
              <strong>Descrição:</strong> {{value.vaga.descricao}} <br/>
            </v-card-text>
            <v-card-actions class="justify-center text-center"> 
              <v-btn @click="verCandidatos(value.vagas_id)" color="primary">
                Ver Candidatos
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
      <v-row align="center" justify="center">
        <v-col cols="12" md="6">
          <template v-if="getVagasThatHaveConvites.length > 4">
            <jw-pagination 
              :items="getVagasThatHaveConvites"
              @changePage="onChangePage"
              :pageSize="4"
              :labels="customLabels"
            ></jw-pagination>
          </template>
          <template v-else>
            <span style="display: none" >
              <jw-pagination 
                :items="getVagasThatHaveConvites" 
                @changePage="onChangePage"
                :pageSize="4" 
                :labels="customLabels"
              ></jw-pagination>
            </span>
          </template>
        </v-col>
      </v-row>
    </template>
  </template>
  
</v-card-text>
</template>

<script>
import {actionTypes} from '@/core/constants'
import {mapState, mapGetters} from 'vuex'
import ModalAlert from '@/components/Utils/ModalAlert'
import ModalDetalhes from '@/components/Utils/ModalDetalhes'

const customLabels = {
  previous: "Anterior",
  next: "Próxima"
}

export default {
  components: {ModalAlert, ModalDetalhes},
  data(){
    return{
      isLoaded: false,
      title: '',
      toggle: false,
      tab: null, 
      pageOfItems: [],
      customLabels,
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
      active: 'TODAS',
      vagaId: 0
    }
  },
  async created(){
    this.title = 'Candidaturas'
  },
  computed: {
    ...mapState(['candidaturas', 'vagasComConvites']),
    ...mapGetters([
      'tipoPermissao', 'getCandidaturasFiltradas', 'getCandidaturasDaVaga',
      'getCandidaturasFinalizadas', 'getVagasThatHaveConvites'
    ]),
    getCandidaturas(){
      if(this.active == 'TODAS'){
        return this.candidaturas
      }else if(status == 'FINALIZADAS'){
        return this.getCandidaturasFinalizadas(this.active)
      }else{
        return this.getCandidaturasFiltradas(this.active)
      }
    },
    candidaturasDaVaga(){
      return this.getCandidaturasDaVaga(this.vagaId)
    }
  },
  methods: {
    onChangePage(pageOfItems) {
      this.pageOfItems = pageOfItems
    },
    verCandidatos(vagaId){
      let payload = {vagaId: vagaId, toggle: true}
      this.$emit('handlePayload', payload)
    }
  }
}
</script>
