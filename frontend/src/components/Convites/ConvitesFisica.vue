<template>
<span>
  <v-snackbar
    top
    v-model="snackbar"
    :timeout="timeout"
  >{{notificacao}}
    <template v-slot:action="{ attrs }">
      <v-btn
        color="primary"
        text
        v-bind="attrs"
        @click="snackbar = false"
      >Fechar</v-btn>
    </template>
  </v-snackbar>
  <v-tabs
    v-model="tab"
    centered
    color="basil"
    grow
    show-arrows
  >
    <v-tab href="#tab-1" class="info lighten-3" @click="active = 'TODOS'">Todos</v-tab>
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
              <v-col class="d-flex flex-column" cols="12" lg="6" md="6" sm="12" v-for="convite in pageOfItems" :key="convite.id">
                <v-card class="py-2 flex d-flex flex-column">
                  <v-card-title class="primary--text">
                    <h3>{{convite.vaga.titulo}}</h3>
                  </v-card-title>
                  <v-card-text class="black--text" align="left">
                    <span>
                      <strong>Cargo:</strong> {{convite.vaga.cargo}} <br/>
                      <strong>Área de Atuação: </strong> {{convite.vaga.area.tipo}} <br/>
                      <strong>Jornada de Trabalho: </strong> {{convite.vaga.jornada}} <br/>
                    </span>
                  </v-card-text>
                  <v-card-actions class="text-center justify-center">
                    <template v-if="convite.resposta == 'CANCELADO'">
                      <v-chip class="red darken-3" dark>Esse convite foi cancelado.</v-chip>
                    </template>
                    <template v-if="convite.resposta == 'RECUSOU'">
                      <v-chip class="red darken-3" dark>Você recusou esse convite.</v-chip>
                    </template>
                    <template v-if="convite.resposta == 'AGUARDANDO'">
                      <ModalDetalhes :payload="verVaga">
                        <template v-slot:texto>
                          <v-row>
                            <v-col>
                              <strong>Descriçao:</strong> {{convite.vaga.descricao}} <br/>
                              <strong>Cargo:</strong> {{convite.vaga.cargo}} <br/>
                              <strong>Área de Atuação:</strong> {{convite.vaga.area.tipo}} <br/>
                              <strong>Jornada de Trabalho:</strong> {{convite.vaga.jornada}} <br/>
                              <strong>Salário:</strong> {{convite.vaga.salario}} <br/>
                              <strong>Benefícios:</strong> {{convite.vaga.beneficio}} <br/>
                              <strong>Requisitos:</strong> {{convite.vaga.requisito}} <br/> 
                            </v-col>
                          </v-row>
                        </template>
                      </ModalDetalhes>
                      <v-btn color="success" class="ml-1" @click="aceitarConvite(convite.vaga.id)">Aceitar</v-btn>
                      <ModalAlert :vagaId="convite.vaga.id" :payload="recusarConvite">
                        <slot>
                          <h1 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>recusar</strong></span> esse convite?</h1>
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
</span>
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
  props: {
    vagaId: Number
  },
  data(){
    return{
      isLoaded: false,
      title: '',
      snackbar: false,
      timeout: 8000,
      notificacao: '',
      tab: null, 
      pageOfItems: [],
      customLabels,
      candidaturasData: [],
      statusCandidatura: '',
      verVaga: {
        'buttonText': 'Ver Mais',
        'title': 'Detalhes da Vaga',
        'action': 'ver vaga'
      },
      verAgendamento: {
        'buttonText': 'Ver Agendamento',
        'title': 'Detalhes do Agendamento',
        'action': 'ver agendamento'
      },
      recusarConvite: {
        'title': 'Recusar',
        'action': 'recusar convite'
      },
      cancelarEntrevista: {
        'title': 'Cancelar Entrevista',
        'action': 'cancelar entrevista'
      },
      active: 'TODOS'
    }
  },
  computed: {
    ...mapState(['convites']),
    ...mapGetters(['tipoPermissao', 'getConvitesDaVaga']),
    getConvites(){
      if(this.active == 'TODOS'){
        return this.convites
      }else{
        console.log('no else', this.active)
        return this.convites.filter(filtered => {return filtered.resposta == this.active})
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
    async aceitarConvite(vagaId){
      let resposta = {
        resposta: 'ACEITOU',
        vaga_id: vagaId
      }
      this.$store.dispatch(actionTypes.RESPOSTA_CONVITE, resposta)
        .then(response => {
          this.notificacao = 'O convite foi aceito e uma candidatura foi criada! Aguarde resposta da empresa.'
          this.snackbar = true
        })
    }
  }
}
</script>

<style lang="stylus" scoped>
  .dados 
    font-size 15px
</style>