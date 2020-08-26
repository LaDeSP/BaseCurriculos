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
    <v-tabs-items v-model="tab">
      <v-tab-item
        v-for="i in 6"
        :key="i"
        :value="'tab-' + i"
      >
      <v-card align="center" min-height="300">
        <v-card-text align="center" justify="center"> 
          <template v-if="getCandidaturas.length == 0">
            <span style="font-size: 20px" class="my-10">Não há nenhuma candidatura.</span>
          </template>
          <template v-else>
            <v-col cols="12" lg="6" md="6" sm="12" v-for="candidatura in pageOfItems" :key="candidatura.id">
              <v-card class="py-2">
                <v-card-title class="primary--text">
                  <h3>{{candidatura.vaga.titulo}}</h3>
                </v-card-title>
                <v-card-text class="black--text" align="left">
                  <span>
                    <strong>Nome:</strong> {{candidatura.curriculo.fisica.user.name}} <br/>
                    <strong>Objetivos: </strong> {{candidatura.curriculo.objetivos}} <br/>
                    <strong>Pretensão Salarial: </strong> {{candidatura.curriculo.pretensao}} <br/>
                  </span>
                </v-card-text>
                <v-card-actions class="text-center justify-center">
                  <template v-if="candidatura.status == 'AGUARDANDO' || candidatura.status == 'EM AGENDAMENTO'">
                    <ModalDetalhes :candidaturaId="candidatura.id" :payload="verCurriculo">
                      <template v-slot:texto>
                        <v-row>
                          <v-col>
                            <h2 class="mb-1">Informações Pessoais</h2>
                            <strong>Nome Completo:</strong> {{candidatura.curriculo.fisica.user.name}} <br/>
                            <strong>Data de Nascimento:</strong> {{candidatura.curriculo.fisica.data_nascimento}} <br/>
                            <strong>Gênero:</strong> {{candidatura.curriculo.fisica.genero}} <br/>
                            <strong>Estado Civil:</strong> {{candidatura.curriculo.fisica.estado_civil}} <br/>
                            <strong>CPF:</strong> {{candidatura.curriculo.fisica.cpf}} <br/> <br/>
                          </v-col>
                          <v-col>
                            <h2 class="mb-1" v-if="candidatura.curriculo.fisica.contato.twitter || 
                              candidatura.curriculo.fisica.contato.linkedin || 
                              candidatura.curriculo.fisica.contato.site || 
                              candidatura.curriculo.fisica.contato.facebook">
                              Redes Sociais
                            </h2>
                            <span v-if="candidatura.curriculo.fisica.contato.linkedin">
                              <strong>Linkedin:</strong> {{candidatura.curriculo.fisica.contato.linkedin}} <br/>
                            </span>
                            <span v-if="candidatura.curriculo.fisica.contato.facebook">
                              <strong>Facebook:</strong> {{candidatura.curriculo.fisica.contato.facebook}} <br/>
                            </span>
                            <span v-if="candidatura.curriculo.fisica.contato.twitter">
                              <strong>Twitter:</strong> {{candidatura.curriculo.fisica.contato.twitter}} <br/>
                            </span>
                            <span v-if="candidatura.curriculo.fisica.contato.site">
                              <strong>Site:</strong> {{candidatura.curriculo.fisica.contato.site}} <br/>
                            </span> <br/>
                          </v-col>
                        </v-row>
                        <h2 class="mb-1">Currículo</h2>
                        <strong>Objetivos:</strong> {{candidatura.curriculo.objetivos}} <br/>
                        <strong>Área de Atuação:</strong> {{candidatura.curriculo.area.tipo}} <br/>
                        <strong>Pretensão Salarial:</strong> {{candidatura.curriculo.pretensao}} <br/>
                        <strong>Formação Acadêmica:</strong> {{candidatura.curriculo.escolaridade}} <br/>
                        <strong>Histórico</strong> {{candidatura.curriculo}} <br/>
                        <strong>Qualificações:</strong> {{candidatura.curriculo.qualificacoes}} <br/>
                      </template>
                    </ModalDetalhes>
                  </template>
                  <template v-if="candidatura.status == 'EM AGENDAMENTO'">
                    <router-link to="/agenda">
                      <v-btn class="ml-1" outlined color="primary">
                        Ver Agendamento
                      </v-btn>
                    </router-link>
                  </template>
                </v-card-actions>
              </v-card>
            </v-col>
          </template>
            <v-row align="center" justify="center">
              <v-col cols="12" md="6">
                <template v-if="getCandidaturas.length > 4">
                  <jw-pagination 
                    :items="getCandidaturas"
                    @changePage="onChangePage"
                    :pageSize="4"
                    :labels="customLabels"
                  ></jw-pagination>
                </template>
                <template v-else>
                  <span style="display: none" >
                    <jw-pagination 
                      :items="getCandidaturas" 
                      @changePage="onChangePage"
                      :pageSize="4" 
                      :labels="customLabels"
                    ></jw-pagination>
                  </span>
                </template>
              </v-col>
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
  created(){
    console.log('jsaia', this.vagaId)
  },
  computed: {
    ...mapState(['candidaturas']),
    ...mapGetters([
      'tipoPermissao', 'getCandidaturasFiltradas', 
      'getCandidaturasFinalizadas', 'getVagasAtivas', 
      'getVagasThatHaveCandidaturas', 'getCandidaturasDaVaga'
    ]),
    getCandidaturas(){
      if(this.active == 'TODAS'){
        return this.candidaturasDaVaga
      }else if(this.active == 'AGUARDANDO'){
        console.log('AKI', this.candidaturasDaVaga)
        return this.candidaturasDaVaga.filter(filtered => {return filtered.status == this.active})
      }else if(this.active == 'EM AGENDAMENTO'){
        return this.candidaturasDaVaga.filter(filtered => {return filtered.status == this.active})
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
    },
    getRedesSociaisCandidato(candidatoId){
      return this.candidaturasDaVaga.filter(filtered => {
        if(filtered.id == candidatoId){
          Object.keys(filtered.curriculo.fisica.contato)
            .forEach((key) => (filtered.curriculo.fisica.contato[key] == null) && delete filtered.curriculo.fisica.contato[key])
        }
      })
    }
  }
}
</script>

<style lang="stylus" scoped>
  .dados 
    font-size 15px
</style>