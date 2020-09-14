<template>
 <v-row align="center" justify="center">
    <v-col cols="12" lg="12" md="12" sm="10">
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-card align="center">
        <v-card-title class="text-center justify-center py-6">
          <h1>Resultados</h1> 
        </v-card-title>
        <v-card-text>
            <template v-if="resultado.length == 0">
              <v-col>
                <span class="aviso">Nenhum resultado encontrado.</span>
              </v-col>
            </template>
            <template v-else>
              <template v-if="tipoPermissao == 'JURIDICA'">
                <ResultadosJuridica></ResultadosJuridica>
              </template>
              <template v-else-if="tipoPermissao == 'FISICA'">
               <ResultadosFisica></ResultadosFisica>
              </template>
            </template>
        </v-card-text>
      </v-card>
    </v-col>
 </v-row>
</template>

<script>
import {mapGetters, mapState} from 'vuex'
import {actionTypes} from '@/core/constants'
import ThumbnailPic from '@/components/Utils/ThumbnailPic'
import ResultadosJuridica from '@/components/Resultados/ResultadosJuridica'
import ResultadosFisica from '@/components/Resultados/ResultadosFisica'

const customLabels = {
  previous: 'Anterior',
  next: 'Próxima' 
}
export default {
  components: {ThumbnailPic, ResultadosJuridica, ResultadosFisica},
  data() {
    return {
      keywords: '',
      pleaseWaitDialog: false,
      snackbar: false,
      notificacao: '',
      timeout: 5000,
      pageOfItems: [],
      customLabels,
      convite: '',
      vaga_id: 0,
      vaga: [],
      thisCurriculo: ''
    }
  },
  async created(){
    if(this.tipoPermissao == 'JURIDICA'){
      await this.searchCurriculos()
      await this.$store.dispatch(actionTypes.GET_VAGAS_JURIDICAS)
    }else if(this.tipoPermissao == 'FISICA'){
      await this.searchVagas()
    }
  },
  computed: {
    ...mapState(['resultado']),
    ...mapGetters(['tipoPermissao', 'getVagasAtivas'])
  },
  methods: {
    async searchCurriculos(){
      if((this.$route.query.escolaridade != '' || this.$route.query.objetivos != '' || this.$route.query.historicoProfissional != '' || 
          this.$route.query.cidade != '' || this.$route.query.nome != '' || this.$route.query.area != '') == true && 
          (this.$route.query.escolaridade != undefined || this.$route.query.objetivos != undefined || this.$route.query.historicoProfissional != undefined ||
          this.$route.query.cidade != undefined || this.$route.query.nome != undefined || this.$route.query.area != undefined) == true){
        let pesquisa = {
          keywords : this.$route.query.keywords,
          escolaridade : this.$route.query.escolaridade,
          objetivos : this.$route.query.objetivos,
          historicoProfissional : this.$route.query.historicoProfissional,
          cidade : this.$route.query.cidade,
          nome: this.$route.query.nome,
          area: this.$route.query.area,
        }
        await this.$store.dispatch(actionTypes.GET_BUSCA_AVANCADA_CURRICULOS, pesquisa)
      }else{
        await this.$store.dispatch(actionTypes.GET_BUSCA_CURRICULOS, this.$route.query.keywords)
      }
    },
    async searchVagas(){
      if((this.$route.query.cargo != '' || this.$route.query.beneficio != '' || this.$route.query.jornada != '' || this.$route.query.requisitos != '' || 
        this.$route.query.area != '') == true && (this.$route.query.cargo != undefined || this.$route.query.beneficio != undefined || 
        this.$route.query.jornada != undefined || this.$route.query.requisitos != undefined || this.$route.query.area != undefined) == true){
        let pesquisa = {
          keywords : this.$route.query.keywords,
          cargo : this.$route.query.cargo,
          beneficio : this.$route.query.beneficio,
          jornada : this.$route.query.jornada,
          requisitos : this.$route.query.requisitos,
          area: this.$route.query.area,
        }
        await this.$store.dispatch(actionTypes.GET_BUSCA_AVANCADA_VAGAS, pesquisa)
      }else{
        await this.$store.dispatch(actionTypes.GET_BUSCA_VAGAS, this.$route.query.keywords)
      }
    }
  }
}
</script>
