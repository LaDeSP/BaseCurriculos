<template>
  <v-card class="borda-card mt-3 mx-auto elevation-6" max-width="800" align="center" justify="center">
    <v-card-title class="warning--text">
        <router-link to="convites">Meus convites</router-link>  
        <v-spacer></v-spacer>
        <router-link to="convites">
          <v-btn outlined color="grey darken-1">Ver mais <v-icon class="pl-1">fa fa-eye</v-icon></v-btn>
        </router-link>
    </v-card-title>
    <v-card-text>
        <v-row class="my-5">
          <v-col>
              <h1>{{convites.length}}</h1>
              <v-icon class="mt-3">fas fa-envelope</v-icon>
          </v-col>
        </v-row>
    </v-card-text> 
  </v-card>
</template>

<script>
import {mapState} from 'vuex'

export default {
  computed: {
    ...mapState(['convites'])
  }

}
</script>

<style scoped lang="stylus">
  .v-application a:hover
    color #f6c23e !important
    text-decoration underline
  .borda-card
    border-left: 5px solid #f6c23e !important 
  .v-card__title
    justify-content center
</style>