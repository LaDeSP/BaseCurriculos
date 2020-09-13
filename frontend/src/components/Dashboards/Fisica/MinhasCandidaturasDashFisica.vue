<template>
<div class="text-center">
  <span class="pagina"><v-icon class="pagina">fas fa-home fa-lg</v-icon> Home</span>
  <v-card class="borda-card mx-auto elevation-6" max-width="800" align="center" justify="center">
    <v-card-title class="primary--text">
        <router-link to="candidaturas">Minhas Candidaturas</router-link>  
        <v-spacer></v-spacer>
        <router-link to="candidaturas"><v-btn outlined color="grey darken-1">Ver mais <v-icon class="pl-1">fa fa-eye</v-icon></v-btn></router-link>  
    </v-card-title>
    <v-card-text>
      <template v-if="candidaturas.length == 0">
            <span style="font-size: 20px">Nenhuma Candidatura Realizada!</span>
      </template>
      <template v-else>
        <v-row class="justify-space-around">
          <v-col class="d-flex flex-column" cols="10" lg="4" md="4" sm="4" v-for="candidatura in getUltimasCandidaturas" :key="candidatura.id">
              <v-card class="py-5 flex d-flex flex-column">
                <v-card-title class="text-center justify-center">
                  <h3 :title="candidatura.vaga.titulo">{{truncate(candidatura.vaga.titulo, 25)}}</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="mt-1 same-size-card">
                    <span :class="getStyle(candidatura.status)">
                    <div>{{candidatura.status}}</div>
                    <v-icon :class="getIcons(candidatura.status)" large></v-icon>
                  </span>
                </v-card-text>
              </v-card>
          </v-col>
        </v-row>
      </template>
    </v-card-text> 
  </v-card>
</div>
</template>

<script>
import {mapState, mapGetters} from 'vuex'
export default {
  data() {
    return {
      icon: ''
    }
  },
  computed: {
    ...mapState(['candidaturas', 'auth']),
    ...mapGetters(['getUltimasCandidaturas'])
  },
  methods: {
    truncate(value, size){
      if(value.length > size){
        let title = value.slice(0, size)
        title = title + '...'
        return title
      }else{
        return value
      }
    },
    getStyle(status){
      if(status == 'AGUARDANDO' || status == 'EM AGENDAMENTO'){
        return 'mt-2 warning--text'
      }else if(status == 'ENTREVISTA CONFIRMADA'){
        return 'success--text'
      }else if(status == 'RECUSADO'){
        return 'red--text'
      }else if(status == 'ENTREVISTA CANCELADA'){
        return 'red--text'
      }else if(status == 'CONTRATADO'){
        return 'success--text'
      }
    },
    getIcons(status){
      switch (status) {
        case 'AGUARDANDO':
          return 'yellow--text text--darken-2 fas fa-clock'
          break;
        case 'EM AGENDAMENTO':
          return 'warning--text fas fa-calendar-alt'
          break;
        case 'ENTREVISTA CONFIRMADA':
          return 'success--text fas fa-calendar-check'
          break;
        case 'RECUSADO':
          return 'red--text fas fa-frown-open'
          break;
        case 'ENTREVISTA CANCELADA':
          return 'red--text fas fa-calendar-times'
          break;
        case 'CONTRATADO':
          return 'success--text fas fa-smile'
          break;
      }
    }
  }
}
</script>

<style scoped lang="stylus">
  .pagina 
    font-size 30px
    padding-bottom 10px
  .borda-card
    border-left: 5px solid #4e73df !important
  .v-card__title
    justify-content center
  .same-size-card 
    height 100px !important
</style>