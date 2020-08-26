<template>
  <v-row justify="center">
    <v-col align="center" cols="12" lg="10" md="10" sm="6">
    <h1 style="font-size: 100px; color: #B71C1C" class="--text" >OPA!</h1>
    <h2 style="font-size: 50px"> Não conseguimos encontrar essa página 
      <v-icon style="font-size: 50px" class="black--text">far fa-dizzy</v-icon>  
    </h2>
    <template v-if="isLoggedIn">  
      <router-link to="/">
        <v-btn color="red darken-4" dark large class="mt-6">
          <v-icon class="pr-1">mdi-arrow-left</v-icon>
          Voltar para a Home
        </v-btn>
      </router-link>
    </template>
    </v-col>
  </v-row>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
  computed: {
    ...mapGetters(['isLoggedIn'])
  }
}
</script>