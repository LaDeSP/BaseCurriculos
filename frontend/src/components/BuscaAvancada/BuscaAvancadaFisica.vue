 <template>
  <div>
    <v-card-text class="pa-10 text-center justify-center">
      <template v-if="notificacao != ''">
        <span class="rounded-lg pa-1 text-center red lighten-2 white--text">
          {{notificacao}}
        </span>
      </template>
      <v-text-field 
        v-model="keywords"
        label="Titulo"
      ></v-text-field>
      <v-select
        class="mt-0" 
        v-model="area"
        :items="itemsAreaAtuacao"
        item-text="tipo"
        item-value="id"
        label="Área de Atuação"
        required
      ></v-select>
      <v-text-field 
        v-model="cargo"
        label="Cargo"
      ></v-text-field>
      <v-text-field 
        v-model="beneficio"
        label="Benefício"
      ></v-text-field>
      <v-text-field 
        label="Jornada"
        v-model="jornada"
      ></v-text-field>  
      <v-text-field 
        label="Requisitos"
        v-model="requisitos"
      ></v-text-field> 
    </v-card-text>
    <v-divider></v-divider>
    <v-card-actions>
      <v-btn outlined color="red darken-1" text @click="closeDialog">Fechar</v-btn>
      <v-spacer></v-spacer>
      <v-btn class="ml-1" color="primary darken-1" @click="advancedSearchCurriculos"
        :disabled="keywords.length<1 && cargo.length<1 && beneficio.length<1 && jornada.length<1 && requisitos.length<1 && area.length<1"
      >Buscar</v-btn>
    </v-card-actions>
  </div>
</template>

<script>
import {actionTypes} from '@/core/constants'
export default {
  props: {
    itemsAreaAtuacao: Array
  },
  data() {
    return {
      keywords: '',
      area: '',
      notificacao: '',
      titulo: '',
      cargo: '',
      beneficio: '',
      requisitos: '',
      jornada: ''
    }
  },
  methods: {
    closeDialog(){
      this.notificacao = ''
      this.$emit('closeDialog', false)
    },
    async advancedSearchCurriculos(){
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
        this.closeDialog()
        this.$store.dispatch(actionTypes.GET_BUSCA_AVANCADA_VAGAS, pesquisa)
        .then(response => {
            this.notificacao = ''
            this.keywords = ''
            this.area = '' 
            this.cargo = ''
            this.beneficio = ''
            this.requisitos = ''
            this.jornada = ''
        })
        .catch(error => console.log(error))
      }
      else{
        this.$router.push({ name: 'search', query: { keywords: this.keywords, cargo: this.cargo, beneficio: this.beneficio, requisitos: this.requisitos, jornada: this.jornada, area: this.area} })
        this.closeDialog()
        this.notificacao = ''
      }
    }
  }
}
</script>