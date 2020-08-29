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
        label="Qualificações"
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
      <v-select
        class="mt-3"
        v-model="escolaridade"
        :items="itemsNivelEscolaridade"
        label="Nível de Escolaridade"
        required
      ></v-select>
      <v-text-field 
        v-model="objetivos"
        label="Objetivos"
      ></v-text-field>
      <v-text-field 
        v-model="historicoProfissional"
        label="Histórico Profissional"
      ></v-text-field>
      <v-text-field 
        label="Cidade"
        v-model="cidade"
      ></v-text-field>  
      <v-text-field 
        label="Nome"
        v-model="nome"
      ></v-text-field> 
    </v-card-text>
    <v-divider></v-divider>
    <v-card-actions>
      <v-btn outlined color="red darken-1" text @click="closeDialog">Fechar</v-btn>
      <v-spacer></v-spacer>
      <v-btn class="ml-1" color="primary darken-1" @click="advancedSearchCurriculos"
        :disabled="keywords.length<1 && escolaridade.length<1 && objetivos.length<1 && historicoProfissional.length<1 && cidade.length<1 && nome.length<1 && area.length<1"
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
      nome: '',
      escolaridade: '',
      historicoProfissional: '',
      cidade: '',
      qualificacoes: '',
      objetivos: '',
      itemsNivelEscolaridade: [
        "Ensino Fundamental(Incompleto)",
        "Ensino Fundamental(Cursando)", 
        "Ensino Fundamental(Completo)",
        "Ensino Médio(Incompleto)", 
        "Ensino Médio(Cursando)", 
        "Ensino Médio(Completo)", 
        "Ensino Superior(Incompleto)", 
        "Ensino Superior(Cursando)",
        "Ensino Superior(Completo)", 
        "Pós-Graduação(Especialização)", 
        "Pós-Graduação(Mestrado)", 
        "Pós-Graduação(Doutorado)"
      ]
    }
  },
  methods: {
    closeDialog(){
      this.notificacao = ''
      this.$emit('closeDialog', false)
    },
    async advancedSearchCurriculos(){
      if ((this.keywords=='' || this.keywords==undefined)==true && (this.escolaridade=='' || this.escolaridade==undefined)
        && (this.objetivos=='' || this.objetivos==undefined) && (this.historicoProfissional=='' || this.historicoProfissional==undefined)
        && (this.cidade=='' || this.cidade==undefined) && (this.nome=='' || this.nome==undefined) && (this.area=='' || this.area==undefined)){
        this.notificacao = "Preencha pelo menos um campo para realizar a busca."
        return
      }
      if (this.$router.currentRoute.name == "search"){
        let pesquisa = {
          keywords : this.keywords,
          escolaridade : this.escolaridade, 
          objetivos : this.objetivos, 
          historicoProfissional : this.historicoProfissional,
          cidade : this.cidade,
          nome: this.nome,
          area: this.area
        } 
          this.closeDialog()
          this.$store.dispatch(actionTypes.GET_BUSCA_AVANCADA_CURRICULOS, pesquisa)
          .then(response => {
              this.notificacao = ''
              this.keywords = ''
              this.area = '' 
              this.nome = ''
              this.escolaridade = ''
              this.historicoProfissional = ''
              this.cidade = ''
              this.qualificacoes = ''
              this.objetivos = ''
          })
          .catch(error => console.log(error))
      }
      else{
        this.$router.push({ name: 'search', query: { keywords: this.keywords, escolaridade: this.escolaridade, objetivos: this.objetivos, historicoProfissional: this.historicoProfissional, cidade: this.cidade, nome: this.nome, area: this.area} })
        this.closeDialog()
        this.notificacao = ''
      }
    }
  }
}
</script>