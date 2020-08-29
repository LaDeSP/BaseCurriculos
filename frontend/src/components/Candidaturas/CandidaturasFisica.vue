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
    <v-tab href="#tab-4" class="light-green lighten-1" @click="active = 'ENTREVISTA CONFIRMADA'">Confirmadas</v-tab>
    <v-tab href="#tab-5" class="red lighten-1" @click="active = 'ENTREVISTA CANCELADA'">Canceladas</v-tab>
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
              <v-col cols="12" lg="6" md="6" sm="12" v-for="candidatura in getCandidaturas" :key="candidatura.id">
                <v-card class="py-2">
                  <v-card-title class="primary--text">
                    <h3>{{candidatura.vaga.titulo}}</h3>
                  </v-card-title>
                  <v-card-text class="black--text" align="left">
                    <span>
                      <strong>Cargo: </strong> {{candidatura.vaga.cargo}} <br/>
                      <strong>Descrição da Vaga: </strong> {{candidatura.vaga.descricao}} <br/>
                    </span>
                    <template v-if="candidatura.status == 'AGUARDANDO'">
                      <br/><h3 align="center">Enviamos sua solicitação para a empresa. Aguarde retorno!</h3>
                    </template>
                  </v-card-text>
                  <v-card-actions class="text-center justify-center">
                    <template v-if="candidatura.status == 'AGUARDANDO'">
                      <ModalAlert :candidaturaId="candidatura.id" :payload="cancelarCandidatura">
                        <slot>
                          <h1 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>desistir</strong></span> dessa vaga?</h1>
                          <h2 class="text-center mt-4">Essa ação não poderá ser desfeita!</h2>
                        </slot>
                      </ModalAlert>
                    </template>
                    <template v-if="candidatura.status == 'EM AGENDAMENTO' && getCandidaturaId(candidatura.id)">
                      <ModalDetalhes :payload="verAgendamento">
                        <template v-slot:texto>
                          {{agendaById}}
                          Referente à vaga "<strong>{{candidatura.vaga.titulo}}</strong>": <br/>
                          A empresa agendou uma entrevista para o dia <strong>data</strong>, às <strong>horas</strong>. <br/>
                          <strong>Observações:</strong> "lroremomeoeofke" <br/>
                          O que deseja fazer?
                        </template>
                      </ModalDetalhes>
                    </template>
                    <template v-if="candidatura.status == 'ENTREVISTA CONFIRMADA'">
                      <ModalAlert :payload="cancelarEntrevista">
                        <slot>
                          <h1 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> a entrevista agendada?</h1>
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
        return this.candidaturas
      }else if(status == 'FINALIZADAS'){
        return this.getCandidaturasFinalizadas(this.active)
      }else{
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