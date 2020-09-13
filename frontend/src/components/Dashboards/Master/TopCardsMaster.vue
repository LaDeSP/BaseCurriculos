<template>
  <ManageJuridicaUsers></ManageJuridicaUsers>
</template>

<script>
import ManageJuridicaUsers from '@/components/Display/ManageJuridicaUsers'
export default {
  components: {ManageJuridicaUsers},
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