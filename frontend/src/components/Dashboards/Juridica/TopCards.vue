<template>
<div>
  <v-row align="center" justify="center">
    <v-col v-for="(card, index) in cards" :key="index" cols="10" lg="6" md="6" sm="8">
      <v-card class="mx-auto elevation-6" :style="getStyle(card.title)" max-width="800" align="center" justify="center">
        <v-card-title :class="getTitleColor(card.title)">
            <router-link :to="card.path">{{card.title}}</router-link>  
            <v-spacer></v-spacer>
            <router-link :to="card.path">
              <v-btn outlined color="grey darken-1">Ver mais 
                <v-icon class="pl-1">fa fa-eye</v-icon>
              </v-btn>
            </router-link>
        </v-card-title>
        <v-card-text>
          <v-row class="my-5">
            <v-col>
              <h1>
                <template v-if="card.title == 'Minhas Vagas'">
                  {{counter.vagasAtivas}} 
                </template>
                <template v-else-if="card.title == 'Candidaturas'">
                  {{counter.candidaturas.todasCandidaturas}} 
                </template>
                <template v-else-if="card.title == 'Convites'">
                  {{counter.convites.todosConvites}} 
                </template>
                <template v-else-if="card.title == 'Agenda'">
                  {{counter.agenda}} 
                </template>
              </h1>
              <v-icon class="mt-3">{{card.icon}}</v-icon>
            </v-col>
          </v-row>
        </v-card-text> 
      </v-card>
    </v-col>
  </v-row>
</div>
</template>

<script>
import {mapState} from 'vuex'
export default {
  data(){
    return{
      cards: [
        {
          'title': 'Minhas Vagas',
          'icon': 'fas fa-file-invoice-dollar',
          'path': '/vagas'
        },
        {
          'title': 'Candidaturas',
          'icon': 'fas fa-file',
          'path': '/candidaturas'
        },
        {
          'title': 'Convites',
          'icon': 'fas fa-envelope',
          'path': '/convites'
        },
        {
          'title': 'Agenda',
          'icon': 'fas fa-calendar-alt',
          'path': '/agenda'
        },

      ]
    }
  },
  computed: {
    ...mapState(['counter'])
  },
  methods:{
    getStyle(type){
      if(type == 'Minhas Vagas'){
        return 'border-left: 5px solid #1cc88a !important'
      }else if(type == 'Candidaturas'){
        return 'border-left: 5px solid #4e73df !important'
      }else if(type == 'Convites'){
        return 'border-left: 5px solid #f6c23e !important '
      }else if(type == 'Agenda'){
        return 'border-left: 5px solid #36b9cc !important'
      }
    },
    getTitleColor(type){
      if(type == 'Minhas Vagas'){
        return 'success--text'
      }else if(type == 'Candidaturas'){
        return 'primary--text'
      }else if(type == 'Convites'){
        return 'warning--text'
      }else if(type == 'Agenda'){
        return 'info--text'
      }
    }
  }
}
</script>

<style scoped lang="stylus">
  .borda-card
    border-left: 5px solid #4e73df !important
  .v-card__title
    justify-content center
</style>