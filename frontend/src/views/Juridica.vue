<template>
 <v-row align="center" justify="center">
    <span class="pagina"><v-icon class="pagina">fas fa-home fa-lg</v-icon> Home</span>
    <TopCards></TopCards>
    <v-row justify="center">
      <v-col cols="10" lg="6" md="8" sm="8">
        <ProcessosEmAndamento></ProcessosEmAndamento>
      </v-col>
      <v-col cols="10" lg="6" md="8" sm="8">
        <StatusEntrevistas></StatusEntrevistas>
      </v-col>
    </v-row>   
 </v-row>
</template>

<script>
import TopCards from '../components/Dashboards/Juridica/TopCards'
import ProcessosEmAndamento from '../components/Dashboards/Juridica/ProcessosEmAndamento'
import StatusEntrevistas from '../components/Dashboards/Juridica/StatusEntrevistas'
export default {
  components:{TopCards, ProcessosEmAndamento, StatusEntrevistas}
}
</script>

<style lang="stylus">
  .pagina 
    font-size 30px
</style>