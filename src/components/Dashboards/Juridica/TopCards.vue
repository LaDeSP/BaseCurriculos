<template>
<div>
  <span class="pagina"><v-icon class="pagina">fas fa-home fa-lg</v-icon> Home</span>
  <v-row>
    <v-col v-for="(card, index) in cards" :key="index" cols="10" lg="6" md="8" sm="8">
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
              <h1>0</h1>
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
  .pagina 
    font-size 30px
  .borda-card
    border-left: 5px solid #4e73df !important
  .v-card__title
    justify-content center
</style>