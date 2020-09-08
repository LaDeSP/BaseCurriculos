<template>
  <v-tabs
    v-model="tab"
    centered
    color="basil"
    grow
    show-arrows
  >
    <v-tab href="#tab-1" class="info lighten-3" @click="active = 'TODAS'">Todas</v-tab>
    <v-tab href="#tab-2" class="amber lighten-3" @click="active = 'AGUARDANDO'">Aguardando</v-tab>
    <v-tab href="#tab-3" class="amber lighten-1" @click="active = 'EM AGENDAMENTO'">Em Agendamento</v-tab>
    <v-tab href="#tab-4" class="light-green lighten-1" @click="active = 'ENTREVISTA CONFIRMADA'">Entrevista Confirmada</v-tab>
    <v-tab href="#tab-5" class="red lighten-1" @click="active = 'ENTREVISTA CANCELADA'">Entrevista Cancelada</v-tab>
    <v-tab href="#tab-6" class="indigo lighten-1" @click="active = 'FINALIZADAS'">Finalizadas</v-tab>
    <v-tabs-items v-model="tab">
      <v-tab-item
        v-for="i in 6"
        :key="i"
        :value="'tab-' + i"
      >
      <v-card align="center" min-height="200">
        <v-card-text> 
          <v-row justify="center">
            <template v-if="getCandidaturas.length == 0">
              <span class="aviso">Não há nenhuma candidatura.</span>
            </template>
            <template v-else>
              <v-col cols="12" lg="6" md="6" sm="12" class="d-flex flex-column" v-for="candidatura in getCandidaturas" :key="candidatura.id">
                <v-card class="flex d-flex flex-column">
                  <v-card-title class="primary--text">
                    <h3 :title="candidatura.vaga.titulo">{{truncate(candidatura.vaga.titulo, 25)}}</h3>
                    <v-spacer></v-spacer>
                    <v-chip :color="getColor(candidatura.status)">{{candidatura.status}}</v-chip>
                  </v-card-title>
                  <v-card-text class="black--text" align="left">
                    <span>
                      <strong>Cargo: </strong> {{candidatura.vaga.cargo}} <br/>
                      <strong>Descrição da Vaga: </strong> {{candidatura.vaga.descricao}} <br/>
                    </span>
                    <template v-if="candidatura.status == 'AGUARDANDO'">
                      <br/><h3 align="center">Enviamos sua solicitação para a empresa. Aguarde retorno!</h3>
                    </template>
                    <template v-if="candidatura.status == 'ENTREVISTA CANCELADA'">
                      <template v-if="candidatura.agenda[0].contraproposta == 'JURIDICA'">
                        <br/><h3 align="center">A empresa optou por cancelar o agendamento.</h3>
                      </template>
                      <template v-else>
                        <br/><h3 align="center">Você optou por cancelar o agendamento.</h3>
                      </template>
                      <template v-if="candidatura.agenda[0].observacao != null">
                        <p align="center">Foi feita a seguinte observação:</p>
                        <p align="center" class="font-italic">"{{candidatura.agenda[0].observacao}}"</p> 
                      </template>
                    </template>
                    <template v-if="candidatura.status == 'RECUSADO'">
                      <br/><h3 align="center" class="red--text">Infelizmente, a empresa decidiu não dar continuidade no processo de sua candidatura :(</h3>
                    </template>
                  </v-card-text>
                  <v-card-actions class="text-center justify-center">
                    <template v-if="candidatura.status == 'AGUARDANDO'">
                      <ModalAlert :candidaturaId="candidatura.id" :payload="cancelarCandidatura">
                        <slot>
                          <h1 class="text-center line-height">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> a candidatura nessa vaga?</h1>
                          <h2 class="text-center mt-4">Essa ação não poderá ser desfeita!</h2>
                        </slot>
                      </ModalAlert>
                    </template>
                    <template v-if="candidatura.status == 'EM AGENDAMENTO' && getCandidaturaId(candidatura.id)">
                      <ModalDetalhes :candidatura="candidatura" :payload="verAgendamento" :candidaturaId="candidatura.id">
                        <template v-slot:texto>
                          <template v-if="agendaById != undefined">
                            <span class="text-subtitle-1">Referente à vaga "<strong>{{candidatura.vaga.titulo}}</strong>":</span> <br/><br/>
                            <template v-if="candidatura.agenda.contraproposta == 'JURIDICA'">
                              A empresa agendou uma entrevista para o dia 
                            </template> 
                            <template v-else>
                              Você fez uma contraproposta para o dia
                            </template>
                            <strong>{{agendaById.data | dateFormat}}</strong>, 
                            às <strong>{{agendaById.hora | hourFormat}}</strong> 
                            <template v-if="agendaById.observacao != null">
                              com as seguintes <strong>observações:</strong> <br/><br/>
                              <p class="font-italic subtitle-1" align="center">"{{agendaById.observacao}}"</p>
                            </template>
                            <template v-else>
                              e não fez nenhuma observação. 
                            </template>
                            <p align="center">O que deseja fazer?</p>
                          </template>
                        </template>
                      </ModalDetalhes>
                    </template>
                    <template v-if="candidatura.status == 'ENTREVISTA CONFIRMADA'">
                      <ModalAlert 
                          :candidaturaId="candidatura.id" 
                          :observacaoCancelamento="observacaoCancelamento" 
                          :payload="cancelarAgendamento"
                        >
                        <slot>
                          <h1 class="text-center line-height">Tem certeza de que deseja <span style="color: #ff0000">
                          <strong>cancelar</strong></span> esse agendamento?</h1>
                          <h3 class="mt-3" align="center">Você pode fazer uma observação:</h3>
                          <v-textarea
                            class="mt-3"
                            v-model="observacaoCancelamento"
                            outlined
                          ></v-textarea>
                          <h2 class="text-center mt-4">Essa ação não poderá ser desfeita!</h2>
                        </slot>
                      </ModalAlert>
                    </template>
                  </v-card-actions>
                </v-card>
              </v-col>
            </template>
          </v-row>
        </v-card-text>
      </v-card>
    </v-tab-item>
  </v-tabs-items>
  </v-tabs>
</template>


<script>
import {actionTypes} from '@/core/constants'
import {mapState, mapGetters} from 'vuex'
import ModalAlert from '@/components/Utils/ModalAlert'
import ModalDetalhes from '@/components/Utils/ModalDetalhes'
import moment from 'moment'

const customLabels = {
  first: "Primeira",
  last: "Última",
  previous: "Anterior",
  next: "Próxima"
}

export default {
  components: {ModalAlert, ModalDetalhes},
  props: {
    vagaId: Number
  },
  data(){
    return{
      isLoaded: false,
      title: '',
      toggle: false,
      tab: null, 
      pageOfItems: [],
      customLabels,
      candidaturaId: 0,
      observacaoCancelamento: '',
      candidaturasData: [],
      statusCandidatura: '',
      verCurriculo: {
        'buttonText': 'Ver Mais',
        'title': 'Detalhes do Candidato',
        'action': 'ver curriculo'
      },
      verAgendamento: {
        'buttonText': 'Ver Agendamento',
        'title': 'Detalhes do Agendamento',
        'action': 'ver agendamento',
        'hasCardActions': true
      },
      cancelarCandidatura: {
        'title': 'Cancelar Candidatura',
        'action': 'cancelar candidatura'
      },
      cancelarAgendamento: {
        'title': 'Cancelar Agendamento',
        'action': 'cancelar agendamento'
      },
      active: 'TODAS'
    }
  },
  filters:{
    dateFormat: function(value){
      if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
      }
    },
    hourFormat: function(value){
    if(value){ 
      return value.replace(/:[^:]*$/,'')
    }
  }
  },
  async created(){
    await this.$store.dispatch(actionTypes.GET_AGENDA)
  },
  computed: {
    ...mapState(['candidaturas']),
    ...mapGetters([
      'tipoPermissao', 'getCandidaturasFiltradas', 
      'getCandidaturasFinalizadas', 'getAgendaById'
    ]),
    agendaById(){
      return this.getAgendaById(this.candidaturaId)
    },
    getCandidaturas(){
      if(this.active == 'TODAS'){
        console.log('TODAS', this.candidaturas)
        return this.candidaturas
      }else if(this.active == 'FINALIZADAS'){
        console.log('FINALIZADAS', this.candidaturas)
        return this.getCandidaturasFinalizadas(this.active)
      }else{
        console.log('kaokaokao', this.getCandidaturasFiltradas(this.active))
        return this.getCandidaturasFiltradas(this.active)
      }
    }
  },
  methods: {
    onChangePage(pageOfItems) {
      this.pageOfItems = pageOfItems
    },
    truncate(value, size){
      if(value.length > size){
        let title = value.slice(0, size)
        title = title + '...'
        return title
      }else{
        return value
      }
    },
    verCandidatos(vagaId){
      let payload = {vagaId: vagaId, toggle: true}
      this.$emit('handlePayload', payload)
    },
    getRedesSociaisCandidato(candidatoId){
      return this.candidaturasDaVaga.filter(filtered => {
        if(filtered.id == candidatoId){
          Object.keys(filtered.curriculo.fisica.contato)
            .forEach((key) => (filtered.curriculo.fisica.contato[key] == null) && delete filtered.curriculo.fisica.contato[key])
        }
      })
    },
    getCandidaturaId(id){
      this.candidaturaId = id
      return true
    },
    getColor(status){
      if(status == 'AGUARDANDO') return 'amber lighten-3'
      else if(status == 'EM AGENDAMENTO') return 'amber lighten-1'
      else if(status == 'ENTREVISTA CONFIRMADA') return 'light-green lighten-1'
      else if(status == 'ENTREVISTA CANCELADA') return 'red lighten-1'
      else if(status == 'RECUSADO' || status == 'CONTRATADO') return 'indigo lighten-1'
    }
  }
}
</script>

<style lang="stylus" scoped>
  .dados 
    font-size 15px
</style>