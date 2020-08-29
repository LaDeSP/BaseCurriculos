<template>
<div>
  <v-row justify="center">
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
    <v-col cols="12" lg="6" md="6" sm="6" v-for="vaga in pageOfItems" :key="vaga.id">
      <v-card class="py-5 my-5">
        <v-card-title class="text-center justify-center primary--text">
          <h3>{{vaga.titulo}}</h3>
        </v-card-title>
        <v-card-text class="black--text same-size-card" align="left">
          <strong>Cargo:</strong> {{vaga.cargo}} <br/>
          <strong>Área de Atuação:</strong> {{vaga.area.tipo}} <br/>
          <strong>Jornada de Trabalho:</strong> {{vaga.jornada}}
        </v-card-text>
        <v-card-actions class="justify-center text-center">
          <template v-if="vaga.my_candidatura">
            <v-chip class="success">Você já se candidatou a esta vaga!</v-chip>
          </template>
          <template v-else>
            <ActionsDaVagaRecomendada 
              :vagaBuscada="true"
              :vaga="vaga" 
              :vagaId="vaga.id"
              @handleNotif="getNotificacao"
            ></ActionsDaVagaRecomendada>
          </template>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
  <v-row align="center" justify="center">
    <v-col cols="12" md="6">
      <template class="" v-if="resultado.length > 6">
        <jw-pagination 
          :items="resultado"
          @changePage="onChangePage"
          :pageSize="6"
          :labels="customLabels"
        ></jw-pagination>
      </template>
      <template v-else>
        <span style="display: none" >
          <jw-pagination 
            :items="resultado" 
            @changePage="onChangePage"
            :pageSize="6" 
            :labels="customLabels"
          ></jw-pagination>
        </span>
      </template>
    </v-col>
  </v-row>
</div>
</template>


<script>
import {mapGetters, mapState} from 'vuex'
import {actionTypes} from '@/core/constants'
import ActionsDaVagaRecomendada from '@/components/Dashboards/Fisica/ActionsDaVagaRecomendada'

const customLabels = {
  first: 'Primeira',
  last: 'Última',
  previous: 'Anterior',
  next: 'Próxima' 
}
export default {
  components: {ActionsDaVagaRecomendada},
  data() {
    return {
      keywords: '',
      pleaseWaitDialog: false,
      snackbar: false,
      notificacao: '',
      timeout: 5000,
      pageOfItems: [],
      customLabels,
      convite: '',
      vaga: []
    }
  },
  computed: {
    ...mapState(['resultado']),
    ...mapGetters(['tipoPermissao', 'getVagasAtivas'])
  },
  methods: {
    onChangePage(pageOfItems){
      this.pageOfItems = pageOfItems
    },
    getNotificacao(value){
      console.log('getnoi', value)
      this.notificacao = value
      this.snackbar = true
      
      console.log('snackbar', this.snackbar)
    }
  }
}
</script>

<style lang="stylus" scoped>
  .same-size-card 
    height 100px !important
</style>
