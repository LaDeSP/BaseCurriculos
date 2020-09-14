<template>
<div v-if="isLoaded">
  <headerImages></headerImages>
  <div class="home-container">
    <h2 class="text-center ma-2" >Essas são as empresas que fazem parte do nosso sistema e que estarão de olho em você!</h2>
    <v-row justify="center">
      <FormCreatePessoaFisica></FormCreatePessoaFisica>
    </v-row>
    <EmpresasParceiras></EmpresasParceiras>
  </div>
</div>
</template>

<script>
import HeaderImages from '../components/Home/HeaderImages'
import FormCreatePessoaFisica from '@/components/CreateUsers/FormCreatePessoaFisica'
import EmpresasParceiras from '../components/Home/EmpresasParceiras'
import {actionTypes} from '@/core/constants'

export default {
  components:{HeaderImages, FormCreatePessoaFisica, EmpresasParceiras},
  data() {
    return {
      isLoaded: false
    }
  },
  async created(){
    await this.$store.dispatch(actionTypes.GET_JURIDICA_PATROCINADORAS)
    this.isLoaded = true
  }
}
</script>

<style lang="stylus" scoped>
  .home-container
    padding 5% !important 
    align-content center
</style>
