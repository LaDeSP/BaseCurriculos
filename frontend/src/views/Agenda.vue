<template>
 <v-row align="center" justify="center" v-if="isLoaded">
    <v-col cols="10" lg="8" md="8" sm="10">
      <span v-if="notificacao">
        <v-alert type="success">
          {{notificacao}}
        </v-alert>
      </span>
    </v-col>
    <v-col cols="10" md="12" sm="10">
      <router-link to="/candidaturas">
        <v-btn class="mr-1">
          <v-icon class="pr-1">fas fa-file</v-icon> Candidaturas
        </v-btn>
      </router-link>
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <router-view></router-view>
        <v-card align="center" justify="center" min-height="300">
          <v-card-title class="text-center justify-center py-6">
            <h1>Agenda de Entrevistas</h1>
          </v-card-title>
          <v-tabs
            v-model="tab"
            centered
            show-arrows
            background-color="transparent"
            color="basil"
            grow
          >
            <v-tab href="#tab-1" class="info lighten-3" @click="active = 'ALL'">Todas</v-tab>
            <v-tab href="#tab-3" class="amber lighten-1" @click="active = 'EM AGENDAMENTO'">Em Agendamento</v-tab>
            <v-tab href="#tab-4" class="light-green lighten-1" @click="active = 'ENTREVISTA CONFIRMADA'">Confirmadas</v-tab>
            <v-tab href="#tab-5" class="red lighten-1" @click="active = 'ENTREVISTA CANCELADA'">Canceladas</v-tab>
            <v-tab href="#tab-6" class="indigo lighten-1" @click="active = 'FINALIZADO'">Finalizadas</v-tab>
            <v-tabs-items v-model="tab">
            <v-tab-item
              v-for="i in 6"
              :key="i"
              :value="'tab-' + i"
            >
              <v-card align="center" min-height="200">
                <v-card-text align="center" justify="center">
                  <template v-if="getAgenda.length == 0">
                    <span class="aviso">Não há nenhum agendamento.</span>
                  </template>
                  <template v-else>
                    <v-row justify="center" align="center">
                      <v-col cols="12" lg="6" md="6" sm="12" v-for="agendamento in pageOfItems" :key="agendamento.id">
                          <v-card>
                            <v-card-title class="justify-center text-center primary--text">
                              <h3 :title="agendamento.candidatura.curriculo.fisica.user.name">
                                {{truncate(agendamento.candidatura.curriculo.fisica.user.name, 25)}}
                              </h3>
                              <v-spacer></v-spacer>
                              <v-chip :color="getColor(agendamento.candidatura.status)">{{agendamento.candidatura.status}}</v-chip>
                            </v-card-title>
                            <v-card-text align="left" class="black--text">
                              <strong>Vaga:</strong> {{agendamento.candidatura.vaga.titulo}} <br/>
                              <strong>Data:</strong> {{agendamento.data | dateFormat}} <br/>
                              <strong>Hora:</strong> {{agendamento.hora | hourFormat}} <br/>
                              <template v-if="agendamento.observacao != null">
                                <strong>Observação:</strong> {{agendamento.observacao}} <br/>
                              </template>
                              <template v-else>
                                <p class="font-italic" align="center">Não há observações.</p>
                              </template>
                            </v-card-text>
                            <v-card-actions class="text-center justify-center">
                              <template v-if="agendamento.candidatura.status == 'EM AGENDAMENTO'">
                                <router-link :to="`/agenda/edit/${agendamento.candidatura.id}`">
                                  <v-btn class="mr-1" color="primary">
                                    Reagendar
                                  </v-btn>
                                </router-link>
                              </template>
                              <template v-if="agendamento.candidatura.status == 'EM AGENDAMENTO' || agendamento.candidatura.status == 'ENTREVISTA CONFIRMADA'">
                                <ModalAlert 
                                  :candidaturaId="agendamento.candidatura.id" 
                                  :observacaoCancelamento="observacaoCancelamento" 
                                  :payload="cancelarAgendamento"
                                >
                                  <slot>
                                    <h1 class="text-center line-height">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> esse agendamento?</h1>
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
                    </v-row>
                  </template>
                </v-card-text>
              </v-card>
                <template class="" v-if="getAgenda.length > 3">
                  <jw-pagination 
                    :items="getAgenda"
                    @changePage="onChangePage"
                    :pageSize="3"
                    :labels="customLabels"
                  ></jw-pagination>
                </template>
                <template v-else>
                  <span style="display: none" >
                    <jw-pagination 
                      :items="getAgenda" 
                      @changePage="onChangePage"
                      :pageSize="3" 
                      :labels="customLabels"
                    ></jw-pagination>
                  </span>
                </template>
            </v-tab-item>
          </v-tabs-items>
          </v-tabs>
        </v-card>
    </v-col>
 </v-row>
</template>

<script>
import moment from 'moment'
import {mapState, mapGetters} from 'vuex'
import {actionTypes} from '@/core/constants'
import ModalAlert from '../components/Utils/ModalAlert'

const customLabels = {
  previous: "Anterior",
  next: "Próxima"
}

export default {
  components: {ModalAlert},
  data(){
    return{
      tab: null, 
      notificacao: '',
      observacaoCancelamento: '',
      pageOfItems: [],
      active: 'ALL',
      customLabels,
      isLoaded: false,
      cancelarAgendamento: {
        'title': 'Cancelar Agendamento',
        'action': 'cancelar agendamento'
      }
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
    this.setNotificacoes()
    console.log('this. toute', this.$route, this.notificacao)
    await this.$store.dispatch(actionTypes.GET_AGENDA)
    this.isLoaded = true
  },
  computed: {
    ...mapState(['agenda']),
    ...mapGetters(['getAgendaFiltrada']),
    getAgenda(){
      if(this.active == 'ALL'){
        return this.agenda
      }else{
        return this.getAgendaFiltrada(this.active)
      }/* else{
        return this.getCandidaturasFiltradas(this.active)
      } */
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
    setNotificacoes(){
      if(this.$route.params.cadastroAgendaSucesso){
        this.notificacao = 'Agendamento cadastrado com sucesso!'
      }else if(this.$route.params.editouAgendaSucesso){
        this.notificacao = 'Agendamento atualizado com sucesso!'
      }
    },
    getColor(status){
      if(status == 'AGUARDANDO') return 'amber lighten-3'
      else if(status == 'EM AGENDAMENTO') return 'amber lighten-1'
      else if(status == 'ENTREVISTA CONFIRMADA') return 'light-green lighten-1'
      else if(status == 'ENTREVISTA CANCELADA') return 'red lighten-1'
      else if(status == 'RECUSADO' || status == 'CONTRATADO') return 'indigo lighten-1'
    },
  }
}
</script>

<style lang="stylus" scoped>
  .dados 
    font-size 15px
</style>