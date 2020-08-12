<template>
<div>
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
import FormCreatePessoaFisica from '../components/Create/FormCreatePessoaFisica'
import EmpresasParceiras from '../components/Home/EmpresasParceiras'

export default {
  components:{HeaderImages, FormCreatePessoaFisica, EmpresasParceiras}
}
</script>

<style lang="stylus" scoped>
  .home-container
    padding 5% !important 
    align-content center
</style>
