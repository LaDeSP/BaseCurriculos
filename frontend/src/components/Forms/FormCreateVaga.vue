<template>
<v-row class="mb-12">
  <v-col cols="12" lg="12" md="12" sm="12">
    <v-stepper class="mt-3" v-model="step">
    <v-stepper-header>
      <v-divider></v-divider>
      <v-stepper-step :complete="step > 1" editable step="1">Informações da Empresa</v-stepper-step>
          <v-divider></v-divider>
      <v-stepper-step :complete="step > 2" editable step="2">Contato</v-stepper-step>
          <v-divider></v-divider>
      <v-stepper-step :complete="step > 3" editable step="3">Endereço</v-stepper-step>
          <v-divider></v-divider>
    </v-stepper-header>
    <form>
      <ValidationObserver ref="observer" v-slot="{ invalid }">
      <v-stepper-items>
        <v-card flat class="mb-12" color="white darken-1" align="center">
          <template v-if="notificacoes">
            <span class="rounded-lg pa-1 mr-1 mt-3 mb-10 text-center red lighten-2 white--text" v-for="(notificacao, index) in notificacoes" :key="index">
              {{notificacao[0]}}
            </span>
          </template>
          <InformacoesEmpresa :edicao="edicao" @handlePayload="getPayloadInfosJuridica" @handleStep="getStep"></InformacoesEmpresa>
          <Contato :edicao="edicao" @handlePayload="getPayloadContato" @handleStep="getStep"></Contato>
          <Endereco :invalid="invalid" :edicao="edicao" 
            :infosJuridica="infosJuridica" :infosContato="infosContato" 
            @handleNotif="getNotif" @handleNotifSuccess="getNotifSuccess" 
            @handleStep="getStep"></Endereco>
        </v-card>
      </v-stepper-items>
      </ValidationObserver>
    </form>
  </v-stepper>
  </v-col> 
</v-row>
</template>

<script>
import moment from 'moment'
import {mapState} from 'vuex'
import InformacoesEmpresa from './FormPessoaJuridicaComponents/InformacoesEmpresa'
import Contato from './FormPessoaJuridicaComponents/Contato'
import Endereco from './FormPessoaJuridicaComponents/Endereco'
import { actionTypes } from '../../core/constants'

export default {
  components: {InformacoesEmpresa, Contato, Endereco},
  props: {
    edicao: Boolean
  },
  data(){
    return {
      step: 1,
      isLoaded: false,
      pleaseWaitDialog: false,
      aviso: '',
      notificacoes: [],
      menu: false,
      infosJuridica: {},
      infosContato: {}
    }
  },
  async created(){
    await this.$store.dispatch(actionTypes.GET_AREAS)
      .then(response => {
        this.itemsAreaAtuacao = response.areas
      })
    console.log('modo edicao?', this.edicao)
    if(this.edicao){
      this.loadDataToEdit()
    }
  },
  methods: {
    getStep(value){
      this.step = value
    },
    getNotif(value){
      this.notificacoes = value
    },
    getPayloadInfosJuridica(value){
      this.infosJuridica = value
    },
    getPayloadContato(value){
      this.infosContato = value
    },
    getNotifSuccess(value){
      console.log('get notif success dform data', value)
      this.$emit('handleNotifSuccess', value)
    }
  }
}
</script>