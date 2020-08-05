<template>
<div>
  <router-link to="/dashboard">
    <v-btn>
      <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
    </v-btn>
  </router-link>
  <v-card class="mb-10">
    <v-tabs 
      v-model="tab"
      background-color="light-blue accent-4"
      centered 
      dark 
      icons-and-text=""
    >
    <v-tabs-slider></v-tabs-slider>
    <v-tab href="#tab-1">
      Meu Perfil
      <v-icon>mdi-account-circle</v-icon>
    </v-tab>
    <v-tab href="#tab-2">
      Currículo 
      <v-icon>fas fa-file-alt</v-icon>
    </v-tab>
    <v-tabs-items v-model="tab">
      <v-tab-item
        v-for="i in 3"
        :key="i"
        :value="'tab-' + i"
      >
      <v-card align="center">
        <v-card-text>
          <v-img class="rounded-circle" height="400px" width="400" src="https://pbs.twimg.com/media/Eejr2M4VoAAcLM1?format=jpg&name=small">
          </v-img>
           <FormPessoaFisicaCurriculo></FormPessoaFisicaCurriculo>
          <v-row align="center" justify="center">
            <v-col class="black--text" col="10" md="10">
              <h1 class="mb-3">Bae Joohyun</h1>
              <span class="dados text-justify">
                <p> <strong>Nascimento:</strong> 29/09/2020 {{text}}</p>
                <p> <strong>Nascimento:</strong> 29/09/2020 {{text}}</p>
                <p> <strong>Nascimento:</strong> 29/09/2020 {{text}}</p>
                <p> <strong>Nascimento:</strong> 29/09/2020 {{text}}</p>
              </span>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="justify-center">
          <v-btn color="warning lighten-2">
            Editar Perfil
          </v-btn>
          <v-btn color="red darken-4 accent-4 white--text">
            Desativar Conta
          </v-btn>
        </v-card-actions>
      </v-card>
      </v-tab-item>
    </v-tabs-items>
    </v-tabs>
  </v-card>
</div>
</template>

<script>
import FormPessoaFisicaCurriculo from '../components/Forms/FormPessoaFisicaCurriculo'

export default {
  components: {FormPessoaFisicaCurriculo},
  data(){
    return{
      tab: null, 
      text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
    }
  }
}
</script>

<style lang="stylus" scoped>
  .dados 
    font-size 15px
</style>