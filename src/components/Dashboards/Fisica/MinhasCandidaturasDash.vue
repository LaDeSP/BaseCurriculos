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
        <v-row class="justify-space-between my-5">
          <v-col cols="10" sm="4">
              <v-card class="py-5">
                <v-card-title>Titulo deste</v-card-title>
                <v-icon>fas fa-spinner fa-pulse</v-icon>
              </v-card>
          </v-col>
          <v-col cols="10" sm="4">
              <v-card class="py-5">
                <v-card-title>Titulo deste</v-card-title>
                <v-icon>fas fa-spinner fa-pulse</v-icon>
              </v-card>
          </v-col>
          <v-col cols="10" sm="4">
              <v-card class="py-5">
                <v-card-title>Titulo deste</v-card-title>
                <v-icon>fas fa-spinner fa-pulse</v-icon>
              </v-card>
          </v-col>
        </v-row>
    </v-card-text> 
  </v-card>
</div>
</template>

<style scoped lang="stylus">
  .pagina 
    font-size 30px
    padding-bottom 10px
  .v-application a:hover
    color #4e73df !important
    text-decoration underline
  .borda-card
    border-left: 5px solid #4e73df !important
  .v-card__title
    justify-content center
</style>