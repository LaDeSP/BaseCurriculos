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
                    <h3>{{candidatura.vaga.titulo}}</h3>
                    <v-spacer></v-spacer>
                    <template v-if="candidatura.status == 'CONTRATADO'">
                      <v-chip class="success darken-3" dark>Contratado</v-chip>
                    </template>
                    <template v-if="candidatura.status == 'RECUSADO'">
                      <v-chip class="grey darken-1" dark>Recusado</v-chip>
                    </template>
                  </v-card-title>
                  <v-card-text class="black--text" align="left">
                    <span>
                      <strong>Cargo: </strong> {{candidatura.vaga.cargo}} <br/>
                      <strong>Descrição da Vaga: </strong> {{candidatura.vaga.descricao}} <br/>
                    </span>
                    <template v-if="candidatura.status == 'AGUARDANDO'">
                      <br/><h3 align="center">Enviamos sua solicitação para a empresa. Aguarde retorno!</h3>
                    </template>
                    <template v-if="candidatura.status == 'RECUSADO'">
                      <br/><h3 align="center" class="red--text">Infelizmente, a empresa decidiu não dar continuidade no processo de sua candidatura :(</h3>
                    </template>
                  </v-card-text>
                  <v-card-actions class="text-center justify-center">
                    <template v-if="candidatura.status == 'AGUARDANDO'">
                      <ModalAlert :candidaturaId="candidatura.id" :payload="cancelarCandidatura">
                        <slot>
                          <h1 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> a candidatura nessa vaga?</h1>
                          <h2 class="text-center mt-4">Essa ação não poderá ser desfeita!</h2>
                        </slot>
                      </ModalAlert>
                    </template>
                    <template v-if="candidatura.status == 'EM AGENDAMENTO' && getCandidaturaId(candidatura.id)">
                      <ModalDetalhes :payload="verAgendamento" :candidaturaId="candidatura.id">
                        <template v-slot:texto>
                          <template v-if="agendaById != undefined">
                            <span class="text-subtitle-1">Referente à vaga "<strong>{{candidatura.vaga.titulo}}</strong>":</span> <br/><br/>
                            A empresa agendou uma entrevista para o dia <strong>{{agendaById.data | dateFormat}}</strong>, 
                            às <strong>{{agendaById.hora | hourFormat}}</strong> 
                            <template v-if="agendaById.observacao != null">
                              com as seguintes <strong>observações:</strong> <br/><br/>
                              <p class="font-italic subtitle-1" align="center">"{{agendaById.observacao}}"</p>
                            </template>
                            <template v-else>
                              e não fez nenhuma observação. 
                            </template>
                            O que deseja fazer?
                          </template>
                        </template>
                      </ModalDetalhes>
                    </template>
                    <template v-if="candidatura.status == 'ENTREVISTA CONFIRMADA'">
                      <ModalAlert 
                          :candidaturaId="candidatura.id" 
                          :observacaoCancelamento="observacaoCancelamento" 
                          :payload="cancelarEntrevista"
                        >
                        <slot>
                          <h1 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> a entrevista agendada?</h1>
                          <h3 class="mt-3" align="center">Você pode fazer uma observação para o candidato:</h3>
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
      cancelarEntrevista: {
        'title': 'Cancelar Entrevista',
        'action': 'cancelar entrevista'
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
    }
  }
}
</script>

<style lang="stylus" scoped>
  .dados 
    font-size 15px
</style>