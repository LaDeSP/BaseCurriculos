<template>
<div>
  <v-row align="center" justify="center">
    <v-col cols="10" lg="12" md="12" sm="8" align="center">
      <span class="pagina"><v-icon class="pagina">fas fa-home fa-lg</v-icon> Home</span>
    </v-col>
    <v-col v-for="(card, index) in cards" :key="index" cols="10" lg="12" md="12" sm="8">
      <router-link :to="card.path">
      <v-card class="mx-auto elevation-6" :style="getStyle(card.title)" max-width="800" align="center" justify="center">
        <v-card-title :class="getTitleColor(card.title)">
            <router-link :to="card.path">{{card.title}}</router-link>  
            <v-spacer></v-spacer> 
        </v-card-title>
        <v-card-text>
          <v-row class="my-5">
            <v-col>
                <v-icon large class="mt-3">{{card.icon}}</v-icon>
            </v-col>
          </v-row>
        </v-card-text> 
      </v-card>
      </router-link>
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
          'title': 'Criar Novo Usuário Jurídico',
          'icon': 'mdi-account-multiple-plus',
          'path': '/new-user'
        },
        {
          'title': 'Gerenciar Usuários',
          'icon': 'mdi-account-group',
          'path': '/manage-users'
        }
      ]
    }
  },
  methods:{
    getStyle(type){
      if(type == 'Criar Novo Usuário Jurídico'){
        return 'border-left: 5px solid #1cc88a !important'
      }else if(type == 'Gerenciar Usuários'){
        return 'border-left: 5px solid #4e73df !important'
      }
    },
    getTitleColor(type){
      if(type == 'Criar Novo Usuário Jurídico'){
        return 'success--text'
      }else if(type == 'Gerenciar Usuários'){
        return 'primary--text'
      }
    }
  }
}
</script>

<style scoped lang="stylus">
  .borda-card
    border-left: 5px solid #4e73df !important
  .v-card__title
    justify-content center
</style>