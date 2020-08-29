<template>
 <v-tabs
    v-model="tab"
    centered
    color="basil"
    grow
    show-arrows
  >
 
    <v-tab href="#tab-1" class="info lighten-3" @click="active = 'TODOS'">Todas</v-tab>
    <v-tab href="#tab-2" class="amber lighten-3" @click="active = 'AGUARDANDO'">Aguardando</v-tab>
    <v-tab href="#tab-3" class="green darken-1" @click="active = 'ACEITOU'">Aceitos</v-tab>
    <v-tab href="#tab-4" class="red darken-2" @click="active = 'RECUSOU'">Recusados</v-tab>
    <v-tabs-items v-model="tab">
      <v-tab-item
        v-for="i in 4"
        :key="i"
        :value="'tab-' + i"
      >
      <v-card align="center" min-height="300">
        <v-card-text align="center" justify="center"> 
          <template v-if="getConvites.length == 0">
            <span style="font-size: 20px" class="my-10">Não há nenhum convite.</span>
          </template>
          <template v-else>
            <v-row class="my-5" justify="center">
              <v-col cols="12" lg="6" md="6" sm="12" v-for="convite in pageOfItems" :key="convite.id">
                <v-card class="py-2">
                  <v-card-title class="primary--text">
                    <h3>{{convite.vaga.titulo}}</h3>
                  </v-card-title>
                  <v-card-text class="black--text" align="left">
                    <span>
                      <strong>Nome:</strong> {{convite.curriculo.fisica.user.name}} <br/>
                      <strong>Objetivos: </strong> {{convite.curriculo.objetivos}} <br/>
                      <strong>Pretensão Salarial: </strong> {{convite.curriculo.pretensao}} <br/>
                    </span>
                  </v-card-text>
                  <v-card-actions class="text-center justify-center">
                    <template v-if="convite.resposta == 'AGUARDANDO'">
                      <ModalDetalhes :payload="verCurriculo">
                        <template v-slot:texto>
                          <v-row>
                            <v-col>
                              <h2 class="mb-1">Informações Pessoais</h2>
                              <strong>Nome Completo:</strong> {{convite.curriculo.fisica.user.name}} <br/>
                              <strong>Data de Nascimento:</strong> {{convite.curriculo.fisica.data_nascimento}} <br/>
                              <strong>Gênero:</strong> {{convite.curriculo.fisica.genero}} <br/>
                              <strong>Estado Civil:</strong> {{convite.curriculo.fisica.estado_civil}} <br/>
                              <strong>CPF:</strong> {{convite.curriculo.fisica.cpf}} <br/> <br/>
                            </v-col>
                            <v-col>
                              <h2 class="mb-1" v-if="convite.curriculo.fisica.contato.twitter || 
                                convite.curriculo.fisica.contato.linkedin || 
                                convite.curriculo.fisica.contato.site || 
                                convite.curriculo.fisica.contato.facebook">
                                Redes Sociais
                              </h2>
                              <span v-if="convite.curriculo.fisica.contato.linkedin">
                                <strong>Linkedin:</strong> {{convite.curriculo.fisica.contato.linkedin}} <br/>
                              </span>
                              <span v-if="convite.curriculo.fisica.contato.facebook">
                                <strong>Facebook:</strong> {{convite.curriculo.fisica.contato.facebook}} <br/>
                              </span>
                              <span v-if="convite.curriculo.fisica.contato.twitter">
                                <strong>Twitter:</strong> {{convite.curriculo.fisica.contato.twitter}} <br/>
                              </span>
                              <span v-if="convite.curriculo.fisica.contato.site">
                                <strong>Site:</strong> {{convite.curriculo.fisica.contato.site}} <br/>
                              </span> <br/>
                            </v-col>
                          </v-row>
                          <h2 class="mb-1">Currículo</h2>
                          <strong>Objetivos:</strong> {{convite.curriculo.objetivos}} <br/>
                          <strong>Área de Atuação:</strong> {{convite.curriculo.area.tipo}} <br/>
                          <strong>Pretensão Salarial:</strong> {{convite.curriculo.pretensao}} <br/>
                          <strong>Formação Acadêmica:</strong> {{convite.curriculo.escolaridade}} <br/>
                          <strong>Histórico</strong> {{convite.curriculo}} <br/>
                          <strong>Qualificações:</strong> {{convite.curriculo.qualificacoes}} <br/>
                        </template>
                      </ModalDetalhes>
                      <ModalAlert :conviteId="convite.id" :payload="cancelarConvite">
                        <slot>
                          <h1 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> esse convite?</h1>
                          <h2 class="text-center mt-4">Essa ação não poderá ser desfeita!</h2>
                        </slot>
                      </ModalAlert>
                    </template>
                    <template v-if="convite.resposta == 'ACEITOU'">
                      <router-link to="/candidaturas">
                        <v-btn outlined color="default">Gerenciar Candidatura</v-btn>
                      </router-link>
                    </template>
                  </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
          </template>
            <v-row align="center" justify="center">
              <v-col cols="12" md="6">
                <template v-if="getConvites.length > 4">
                  <jw-pagination 
                    :items="getConvites"
                    @changePage="onChangePage"
                    :pageSize="4"
                    :labels="customLabels"
                  ></jw-pagination>
                </template>
                <template v-else>
                  <span style="display: none" >
                    <jw-pagination 
                      :items="getConvites" 
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
      cancelarConvite: {
        'title': 'Cancelar Convite',
        'action': 'cancelar convite'
      },
      cancelarEntrevista: {
        'title': 'Cancelar Entrevista',
        'action': 'cancelar entrevista'
      },
      active: 'TODOS'
    }
  },
  created(){
    console.log('jsaia', this.vagaId)
  },
  computed: {
    ...mapState(['candidaturas']),
    ...mapGetters([
      'tipoPermissao', 'getConvitesDaVaga'
    ]),
    getConvites(){
      if(this.active == 'TODOS'){
        return this.convitesDaVaga
      }else{
        console.log('no else', this.active)
        return this.convitesDaVaga.filter(filtered => {return filtered.resposta == this.active})
      }
    },
    convitesDaVaga(){
      return this.getConvitesDaVaga(this.vagaId)
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