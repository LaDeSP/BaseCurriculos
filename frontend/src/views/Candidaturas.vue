<template>
 <v-row align="center" justify="center">
    <v-col cols="12" lg="12" md="12" sm="10" v-if="isLoaded">
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-card align="center">
        <v-card-title class="text-center justify-center py-6">
          <h1>Minhas Candidaturas</h1>
        </v-card-title>
        <v-tabs
          v-model="tab"
          centered
          color="basil"
          grow
          show-arrows
        >
          <v-tab href="#tab-1" class="info lighten-3" @click="getCandidaturas('TODAS')">Todas</v-tab>
          <v-tab href="#tab-2" class="amber lighten-3" @click="getCandidaturas('AGUARDANDO')">Aguardando</v-tab>
          <v-tab href="#tab-3" class="amber lighten-1" @click="getCandidaturas('EM AGENDAMENTO')">Em Agendamento</v-tab>
          <v-tab href="#tab-4" class="light-green lighten-1" @click="getCandidaturas('ENTREVISTA CONFIRMADA')">Confirmadas</v-tab>
          <v-tab href="#tab-5" class="red lighten-1" @click="getCandidaturas('ENTREVISTA CANCELADA')">Canceladas</v-tab>
          <v-tab href="#tab-6" class="indigo lighten-1" @click="getCandidaturas('FINALIZADAS')">Finalizadas</v-tab>
          <v-tabs-items v-model="tab">
            <v-tab-item
              v-for="i in 6"
              :key="i"
              :value="'tab-' + i"
            >
            <v-card align="center" min-height="300">
              <v-card-text> 
                <v-row justify="center">
                  <template v-if="candidaturas.length == 0">
                      <span style="font-size: 20px">Não há nenhuma candidatura com esse status.</span>
                  </template>
                  <template v-if="candidaturasFisica.length == 0">
                    <span style="font-size: 20px">Você ainda não se candidatou a nenhuma vaga.</span>
                  </template>
                  <template v-else>
                    <v-col cols="12" lg="6" md="6" sm="12" v-for="candidatura in candidaturas" :key="candidatura.id">
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
                          <template v-if="candidatura.status == 'EM AGENDAMENTO'">
                            <ModalDetalhes :payload="verAgendamento">
                              <template v-slot:texto>
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
      </v-card>
    </v-col>
 </v-row>
</template>

<script>
import FormPessoaFisicaCurriculo from '../components/Forms/FormPessoaFisicaCurriculo'
import {actionTypes} from '@/core/constants'
import {mapState, mapGetters} from 'vuex'
import ModalAlert from '../components/Utils/ModalAlert'
import ModalDetalhes from '../components/Utils/ModalDetalhes'

export default {
  components: {FormPessoaFisicaCurriculo, ModalAlert, ModalDetalhes},
  data(){
    return{
      isLoaded: false,
      tab: null, 
      candidaturas: [],
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
      }
    }
  },
  async created(){
    //await this.$store.dispatch(actionTypes.GET_AGENDAMENTOS)
    if(this.tipoPermissao == 'FISICA'){
      await this.$store.dispatch(actionTypes.GET_CANDIDATURAS_FISICA)
      this.isLoaded = true
      this.candidaturas = this.candidaturasFisica
    }
  },
  computed: {
    ...mapState(['candidaturasFisica']),
    ...mapGetters(['tipoPermissao', 'getCandidaturasFiltradas', 'getCandidaturasFinalizadas'])
  },
  methods: {
    getCandidaturas(status){
      if(status == 'TODAS'){
        this.candidaturas = this.candidaturasFisica
      }else if(status == 'FINALIZADAS'){
        this.candidaturas = this.getCandidaturasFinalizadas(status)
      }else{
        this.candidaturas = this.getCandidaturasFiltradas(status)
      }
    }
  }
}
</script>

<style lang="stylus" scoped>
  .dados 
    font-size 15px
</style>