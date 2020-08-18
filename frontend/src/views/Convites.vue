<template>
 <v-row class="fill-height" align="center" justify="center">
    <v-col cols="10" md="12" sm="10" xs="2">
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-card align="center" min-height="300">
        <v-card-title class="text-center justify-center py-6">
          <h1>Convites</h1> 
        </v-card-title>
        <v-row class="justify-space-between my-5 mr-2 ml-2">
            <template v-if="getConvitesAguardando.length == 0">
              <v-col lg="12" md="12">
                <span style="font-size: 25px">Você ainda não possui nenhum convite.</span>
              </v-col>
            </template>
            <template v-else>
              <v-col lg="12" md="12" v-for="convite in getConvitesAguardando" :key="convite.id">
                <v-card class="py-5 my-5">
                  <v-card-title>Titulo deste</v-card-title>
                  <v-card-text>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus impedit, sint adipisci quo hic, quidem reiciendis ea praesentium nesciunt eaque vero repellendus aliquid eum distinctio ullam in dicta maiores sed?</v-card-text>
                  <v-card-actions class="justify-center text-center">
                    <v-btn class="default">Ver Candidatos</v-btn>
                  </v-card-actions>
                </v-card>
              </v-col>
            </template>
        </v-row>
      </v-card>
    </v-col>
 </v-row>
</template>

<script>
import {actionTypes} from '@/core/constants'
import {mapGetters} from 'vuex'

const customLabels = {
  first: 'Primeira',
  last: 'Última',
  previous: 'Anterior',
  next: 'Próxima'
}

export default {
  components: {},
  data() {
    return {
      pageOfItems: [],
      customLabels, 
      vagaId: 0,
      toggle: false,
      candidatoId: 0
    }
  },
  async created(){
    this.$store.dispatch(actionTypes.GET_CONVITES)
    if(this.tipoPermissao == 'FISICA'){
      console.log('kakakaka')
    }else{
      this.$store.dispatch(actionTypes.GET_VAGAS_JURIDICAS)
    }

  },
  computed: {
    ...mapGetters(['tipoPermissao', 'getConvitesAguardando'])
  }
}
</script>

