<template>
  <v-footer
    dark
    padless
  >
    <v-row
      justify="center"
      no-gutters
    >
      <v-col
        class="grey darken-3 py-4 text-center white--text"
        cols="12"
      >
       <a href="https://fabricadesoftwaredopantanal.ufms.br"><img class="logoDaFabrica" src="../../../img/logo3.png"></a>   
      </v-col>
      <h4 class="py-1 text-center white--text">Copyright &copy; {{new Date().getFullYear()}} —  Sistema de Recrutamento e Seleção</h4>
    </v-row>
  </v-footer>
</template>

<style lang="stylus">
  .logoDaFabrica
      width: 115px
      height: 100px
      margin-bottom: -10px
</style>