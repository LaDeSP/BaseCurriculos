<template>
  <v-stepper class="mt-3" v-model="step">
    <v-stepper-header>
      <v-stepper-step :complete="step > 1" editable step="1">Informações Pessoais</v-stepper-step>
          <v-divider></v-divider>
      <v-stepper-step :complete="step > 2" editable step="2">Contato</v-stepper-step>
          <v-divider></v-divider>
      <v-stepper-step :complete="step > 3" editable step="3">Endereço</v-stepper-step>
          <v-divider></v-divider>
      <v-stepper-step :complete="step > 4" editable step="4">Informações Profissionais</v-stepper-step>  
    </v-stepper-header>
    <form>
      <v-stepper-items>
        <v-stepper-content step="1">
          <InformacoesPessoais></InformacoesPessoais>
           <v-btn color="primary" @click="step = 2">Próximo</v-btn>
        </v-stepper-content>
        <v-stepper-content step="2">
          <Contato></Contato>
          <v-btn color="default" class="mr-3" @click="step = 1">Voltar</v-btn>
          <v-btn color="primary" @click="step = 3">Próximo</v-btn>
        </v-stepper-content>
        <v-stepper-content step="3">
          <Endereco></Endereco>
          <v-btn color="default" class="mr-3" @click="step = 2">Voltar</v-btn>
          <v-btn color="primary" @click="step = 4">Próximo</v-btn>
        </v-stepper-content>
        <v-stepper-content step="4">
          <InformacoesProfissionais></InformacoesProfissionais>
          <v-btn color="default" class="mr-3" @click="step = 3">Voltar</v-btn>
          <v-btn class="ml-3 mr-3 green white--text" @click="submit"> Salvar</v-btn>
        </v-stepper-content>
      </v-stepper-items>
    </form>
  </v-stepper>
</template>

<script>
import moment from 'moment'
import InformacoesPessoais from './FormPessoaFisicaComponents/InformacoesPessoais'
import Contato from './FormPessoaFisicaComponents/Contato'
import Endereco from './FormPessoaFisicaComponents/Endereco'
import InformacoesProfissionais from './FormPessoaFisicaComponents/InformacoesProfissionais'

export default {
  components: {InformacoesPessoais, Contato, Endereco, InformacoesProfissionais},
  data(){
    return {
      step: 1,
      date: '',
      menu: false,
      genero: '',
      itemsGeneros: [
        'Feminino',
        'Masculino',
        'Não-binário'
      ],
      itemsEstadoCivil: [
        'Solteiro',
        'Casado',
        'Separado',
        'Viúvo'
      ]

    }
  },
  created(){
    this.date = '1996-06-05'
  },
  computed: {
    dateFormated(){
      return moment(this.date).format('DD/MM/YYYY')
    }
  }
}
</script>