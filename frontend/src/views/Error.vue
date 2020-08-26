<template>
  <v-row justify="center">
    <v-col align="center" cols="12" lg="10" md="10" sm="6">
    <h1 style="font-size: 100px; color: #B71C1C" class="--text" >DEU RUIM!</h1>
    <template v-if="error.statusText == 'Unauthorized'">
      <h2 style="font-size: 50px"> Sua sessão expirou. <br/> Faça login novamente. </h2>
        <router-link to="/login">
          <v-btn large color="primary" dark class="mt-6">
            <v-icon class="pr-1">fa-sign-in-alt</v-icon>
            Entrar
          </v-btn>
        </router-link> 
    </template>
    <template v-else>
      <h2 style="font-size: 50px"> Ocorreu um erro:
        <v-icon style="font-size: 50px" class="black--text">far fa-dizzy</v-icon>  
      </h2>
    </template>
    </v-col>
  </v-row>
</template>

<script>
export default {
  data() {
    return {
      error: ''
    }
  },
  created(){
    this.error = this.$route.query.error
  }
}
</script>
