<template>
  <v-card class="borda-card mt-3 elevation-6" max-width="570" align="center" justify="center">
    <v-card-title class="default--text lighten-5">
        Entrevistas
    </v-card-title> 
    <v-card-text>
        <v-row>
          <v-col cols="10" lg="6" md="12" sm="8" class="success--text size"> 
              <h3 class="my-3">Confirmadas</h3>
              <h1>{{counter.candidaturas.candidaturasConfirmadas}} <v-icon class="success--text text-lg-80">fas fa-calendar-check</v-icon></h1>
          </v-col>
           <v-col cols="10" lg="6" md="12" sm="8" class="warning--text size"> 
              <h3 class="my-3">Em Agendamento</h3>
              <h1>{{counter.candidaturas.candidaturasEmAgendamento}} <v-icon class="warning--text">fas fa-calendar-alt</v-icon></h1>
          </v-col>
        </v-row>
    </v-card-text> 
  </v-card>
</template>

<script>
import {mapState} from 'vuex'
export default {
   computed: {
    ...mapState(['counter'])
  }
}
</script>

<style lang="stylus" scoped>
  .size 
    font-size 20px
</style>
