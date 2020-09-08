<template>
<v-dialog v-model="dialog" max-width="800px">
  <template v-slot:activator="{on: evento, attrs}">
    <v-btn
      depressed 
      class="ml-2"
      large
      dark 
      v-bind="attrs"
      v-on="evento"
    >
      Busca Avançada
    </v-btn>
  </template>
  <v-card>
      <v-card-title class="text-center justify-center">
        <h3>Busca Avançada</h3>
      </v-card-title>
        <template v-if="tipoPermissao == 'FISICA'">
          <BuscaAvancadaFisica :itemsAreaAtuacao="itemsAreaAtuacao" @closeDialog="closeDialog"></BuscaAvancadaFisica>
        </template>
        <template v-else-if="tipoPermissao == 'JURIDICA'">
          <BuscaAvancadaJuridica :itemsAreaAtuacao="itemsAreaAtuacao" @closeDialog="closeDialog"></BuscaAvancadaJuridica>
        </template>
  </v-card>
</v-dialog>
</template>

<script>
import {actionTypes} from '@/core/constants'
import {mapGetters} from 'vuex'
import BuscaAvancadaFisica from '@/components/BuscaAvancada/BuscaAvancadaFisica'
import BuscaAvancadaJuridica from '@/components/BuscaAvancada/BuscaAvancadaJuridica'
export default {
  components:{BuscaAvancadaFisica, BuscaAvancadaJuridica},
  data(){
    return{
      dialog: false,
      keywords: '',
      notificacao: '',
      itemsAreaAtuacao: []
    }
  },
  async created(){
    await this.$store.dispatch(actionTypes.GET_AREAS)
    .then(response => {
      this.itemsAreaAtuacao = response.areas
    })
  },
  computed:{
    ...mapGetters(['tipoPermissao'])
  },
  methods: {
    closeDialog(value){
      this.dialog = value
    }
  }
}
</script>
