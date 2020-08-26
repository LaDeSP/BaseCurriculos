<template>
<v-row align="center" justify="center">
  <v-col cols="10" lg="12" md="12" sm="10" xs="2">
    <template v-if="isLoaded">
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-card class="mb-10">
        <template v-if="tipoPermissao == 'FISICA'">
          <ProfileFisica></ProfileFisica>
        </template>
        <template v-else-if="tipoPermissao == 'JURIDICA'">
          <ProfileJuridica></ProfileJuridica>
        </template>
      </v-card>
    </template>
  </v-col>
</v-row>
</template>

<script>
import ProfileFisica from '@/components/Profile/ProfileFisica'
import ProfileJuridica from '@/components/Profile/ProfileJuridica'
import {actionTypes} from '@/core/constants'
import ModalAlert from '../components/Utils/ModalAlert'
import {mapState, mapGetters} from 'vuex'
import moment from 'moment'
export default {
  components: {ProfileFisica, ProfileJuridica, ModalAlert},
  data(){
    return{
      avatar: this.$store.state.upload.path,
      nome: this.$store.state.auth.user.name,
      modoEdicao: false,
      isLoaded: false,
      tab: null, 
      text: `loremalp ksa kspadejmf iejfiejf oejfpej foej fpejf pe`,
      avisoModal: {
        title: 'Desativar Conta',
        action: 'desativar conta'
      }
    }
  },
  filters:{
    dateFormat: function(value){
      if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
      }
    }
  },
  async created(){
    if(this.tipoPermissao == 'FISICA'){
      await this.$store.dispatch(actionTypes.GET_PESSOA_FISICA)
      this.isLoaded = true
    }else if(this.tipoPermissao == 'JURIDICA'){
      await this.$store.dispatch(actionTypes.GET_PESSOA_JURIDICA)
      this.isLoaded = true
    }
  },
  computed:{
    ...mapGetters(['tipoPermissao'])
  }
}
</script>

<style lang="stylus" scoped>
  .dados 
    font-size 15px
    white-space: pre-line !important
  h1 
    line-height 31px
</style>