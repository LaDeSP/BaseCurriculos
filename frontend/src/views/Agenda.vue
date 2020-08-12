<template>
 <v-row class="fill-height" align="center" justify="center">
    <v-col cols="10" md="12" sm="10" xs="2">
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <router-link to="/agenda/new">xadad</router-link>
      <router-view></router-view>
      <v-card align="center" justify="center">
        <v-card-title class="text-center justify-center py-6">
          <h1>Agenda de Entrevistas</h1>
        </v-card-title>
        <v-tabs
          v-model="tab"
          background-color="transparent"
          color="basil"
          grow
        >
          <v-tab href="#tab-1" class="info lighten-3">Todas</v-tab>
          <v-tab href="#tab-2" class="amber lighten-3">Aguardando</v-tab>
          <v-tab href="#tab-3" class="amber lighten-1">Em Agendamento</v-tab>
          <v-tab href="#tab-4" class="light-green lighten-1">Confirmadas</v-tab>
          <v-tab href="#tab-5" class="red lighten-1">Canceladas</v-tab>
          <v-tab href="#tab-6" class="indigo lighten-1">Finalizadas</v-tab>
          <v-tabs-items v-model="tab">
          <v-tab-item
            v-for="i in 6"
            :key="i"
            :value="'tab-' + i"
          >
          <v-card align="center">
            <v-card-text>
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