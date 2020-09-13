<template>
 <div>
  <v-snackbar
    top
    v-model="snackbar"
    :timeout="timeout"
  > {{notificacao}}
    <template v-slot:action="{ attrs }">
      <v-btn
        color="blue"
        text
        v-bind="attrs"
        @click="snackbar = false"
      >Fechar</v-btn>
    </template>
  </v-snackbar>
   <template v-if="getVagasAtivas.length > 0">
    <h2 class="text-center my-4">Vagas que podem lhe interessar</h2>
    <v-row class="my-5" align="center">
      <v-col class="d-flex flex-column" cols="12" lg="6" md="6" sm="6" v-for="vaga in pageOfItems" :key="vaga.id">
        <v-card class="py-5 flex d-flex flex-column">
          <v-card-title class="primary--text text-center justify-center">
            <h3>{{vaga.titulo}}</h3>
          </v-card-title>
          <v-card-text class="black--text same-size-card">
            <strong>Cargo:</strong> {{vaga.cargo}} <br/>
            <strong>Área de Atuação:</strong> {{vaga.area.tipo}} <br/>
            <strong>Jornada de Trabalho:</strong> {{vaga.jornada}}
          </v-card-text>
          <v-card-actions class="text-center justify-center">
            <ActionsDaVagaRecomendada 
              :vagaBuscada="false"
              :vaga="vaga" 
              :vagaId="vaga.id"
              @handleNotif="getNotificacao"
            ></ActionsDaVagaRecomendada>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row align="center" justify="center">
      <v-col cols="12" md="6">
        <template v-if="getVagasAtivas.length > 4">
          <jw-pagination 
            :items="getVagasAtivas"
            @changePage="onChangePage"
            :pageSize="4"
            :labels="customLabels"
          ></jw-pagination>
        </template>
        <template v-else>
          <span style="display: none" >
            <jw-pagination 
              :items="getVagasAtivas" 
              @changePage="onChangePage"
              :pageSize="4" 
              :labels="customLabels"
            ></jw-pagination>
          </span>
        </template>
      </v-col>
    </v-row>
   </template>
   <template v-else>
    <h2 class="text-center my-4">Não temos nenhuma vaga para recomendar no momento. </h2>
   </template>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
import JwPagination from 'jw-vue-pagination'
import ActionsDaVagaRecomendada from './ActionsDaVagaRecomendada'

const customLabels = {
  first: "Primeira",
  last: "Última", 
  previous: "Anterior",
  next: "Próxima"
}

export default {
  components: {ActionsDaVagaRecomendada, JwPagination},
  data() {
    return {
      pageOfItems: [],
      notificacao: '',
      snackbar: false,
      timeout: 2000,
      vagas: [],
      vaga_id: 0,
      customLabels
    }
  },
  computed: {
    ...mapGetters(['getVagasAtivas'])
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

<style scoped lang="stylus">
  .v-application a:hover
    color #4e73df !important
    text-decoration underline
  .borda-card
    border-left 5px solid #4e73df !important
  .v-card__title
    justify-content center
  .same-size-card 
    height 100px !important
</style>