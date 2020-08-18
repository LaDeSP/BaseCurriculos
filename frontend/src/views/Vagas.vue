<template>
 <v-row class="fill-height" align="center" justify="center">
    <v-col cols="12" lg="12" md="8" sm="10">
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-card align="center">
          <v-card-title class="text-center justify-center py-6">
            <h1>Minhas Vagas</h1> 
          </v-card-title>
          <v-tabs 
            v-model="tab"
            centered 
            grow
            color="black"
            show-arrows
          >
          <v-tabs-slider></v-tabs-slider>
          <v-tab href="#tab-1" class="green lighten-1">
            Vagas Ativas
          </v-tab>
          <v-tab href="#tab-2" class="grey lighten-1">
            Vagas Inativas
          </v-tab>
          <v-tabs-items v-model="tab">
            <v-tab-item
              v-for="i in 3"
              :key="i"
              :value="'tab-' + i"
            >
            <v-card align="center">
              <v-card-text>
                <v-btn class="ml-3" outlined color="primary darken-1">
                  Criar Nova Vaga 
                  <v-icon class="pl-1">fa fa-plus</v-icon>
                </v-btn>
                <v-row class="justify-space-between my-5">
                  <v-col>
                      <v-card class="py-5">
                        <v-card-title>Titulo deste</v-card-title>
                      </v-card>
                  </v-col>
                  <v-col>
                      <v-card class="py-5">
                        <v-card-title>Titulo deste</v-card-title>
                      </v-card>
                  </v-col>
                  <v-col>
                      <v-card class="py-5">
                        <v-card-title>Titulo deste</v-card-title>
                      </v-card>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
            </v-tab-item>
          </v-tabs-items>
          </v-tabs>
        </v-card>
    </v-col>
 </v-row>
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