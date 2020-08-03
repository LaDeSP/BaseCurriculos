<template>
  <v-row class="fill-height" align="center" justify="center">
    <v-col cols="10" md="8" sm="10" xs="2">
      <MinhasCandidaturas></MinhasCandidaturas>
      <MeusConvites></MeusConvites>
      <Vagas></Vagas>
    </v-col>
  </v-row>
</template>

<script>
import MinhasCandidaturas from '../components/Dashboards/Fisica/MinhasCandidaturas'
import MeusConvites from '../components/Dashboards/Fisica/MeusConvitesDashFisica'
import Vagas from '../components/Dashboards/Fisica/VagasDashFisica'
export default {
  components:{MinhasCandidaturas, MeusConvites, Vagas}
}
</script>
