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
          <BuscaAvancadaFisica></BuscaAvancadaFisica>
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
    console.log('this.route', this.$route)
    await this.$store.dispatch(actionTypes.GET_AREAS)
    .then(response => {
      this.itemsAreaAtuacao = response.areas
    })
  },
  computed:{
    ...mapGetters(['tipoPermissao'])
  },
  methods:{
    closeDialog(value){
      this.dialog = value
    },
    async advancedSearchVagas(){
      if ((this.keywords=='' || this.keywords==undefined)==true && (this.cargo=='' || this.cargo==undefined)
        && (this.beneficio=='' || this.beneficio==undefined) && (this.jornada=='' || this.jornada==undefined)
        && (this.requisitos=='' || this.requisitos==undefined) && (this.area=='' || this.area==undefined)){
        this.notificacao = "Preencha pelo menos um campo para realizar a busca."
        return
      }
      if (this.$router.currentRoute.name == "search"){
        let pesquisa = {
          keywords : this.keywords,
          cargo : this.cargo, 
          beneficio : this.beneficio, 
          jornada : this.jornada,
          requisitos : this.requisitos,
          area: this.area
        }
          this.$store.dispatch('searchVagasAvancadas', pesquisa)
          .then(response => {
              this.dialog = false
              this.notificacao = ''
          })
          .catch(error => console.log(error))
      }
      else{
        this.$router.push({ name: 'buscas', query: { keywords: this.keywords, cargo: this.cargo, beneficio: this.beneficio, jornada: this.jornada, requisitos: this.requisitos, area: this.area} })
        this.dialog = false
      }
    }
  }
}
</script>
