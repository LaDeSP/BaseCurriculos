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
        <v-row>
          <v-col cols="10" sm="4" v-for="candidatura in getUltimasCandidaturas" :key="candidatura.id">
              <v-card class="py-5">
                <v-card-title>{{candidatura.vaga.titulo}}</v-card-title>
                <v-divider></v-divider>
                <v-card-text class="mt-1">
                    <span :class="getStyle(candidatura.status)">
                    <div>{{candidatura.status}}</div>
                    <v-icon large :class="getStyle(candidatura.status)">{{icon}}</v-icon>
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
    ...mapState(['candidaturas']),
    ...mapGetters(['getUltimasCandidaturas'])
  },
  methods: {
    getStyle(status){
      if(status == 'AGUARDANDO' || status == 'EM AGENDAMENTO'){
        this.icon = 'fas fa-spinner fa-pulse'
        return 'mt-2 warning--text'
      }else if(status == 'ENTREVISTA CONFIRMADA'){
        this.icon = 'fas fa-check-circle'
        return 'success--text'
      }else if(status == 'RECUSADO'){
        this.icon = 'fas fa-frown-open'
        return 'red lighten-2'
      }else if(status == 'ENTREVISTA CANCELADA'){
        this.icon = 'fas fa-calendar-times'
        return 'red lighten-2'
      }else if(status == 'CONTRATADO'){
        this.icon = 'fas fa-smile'
        return 'success--text'
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
</style>