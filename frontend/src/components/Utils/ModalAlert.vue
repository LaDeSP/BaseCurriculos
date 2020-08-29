<template>
<v-dialog v-model="dialog" max-width="700px">
  <template v-slot:activator="{on: evento, attrs}">
    <v-btn
      class="ml-1"
      color="red lighten-1 white--text" 
      v-bind="attrs"
      v-on="evento"
    >
      {{payload.title}}
    </v-btn>
  </template>
  <v-card>
      <v-card-title class="red lighten-1 white--text">
        <h3 class="text-center">{{payload.title}}</h3>
      </v-card-title>
        <v-card-text class="text-justify my-5 justify-center text-center">
            <slot> 
              Texto do Modal Alert
            </slot>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn class="ml-1" color="red lighten-1 white--text" @click="cancelAction">{{payload.title}}</v-btn>
          <v-btn class="ml-1" color="grey white--text" @click="dialog = false">Voltar</v-btn>
        </v-card-actions>
  </v-card>
</v-dialog>
</template>

<script>
import {actionTypes} from '@/core/constants'

export default {
    props:{
      payload: Object,
      candidaturaId: Number,
      conviteId: Number,
      vagaId: Number
    },
    data(){
        return{
          dialog: false
        }
    },
    created(){
      console.log('payload', this.payload)
    },
    methods:{
      closeDialog(){
        this.dialog = false
      },
      async cancelAction(){

        console.log('conviteId', this.conviteId)
        switch (this.payload.action) {
          case 'cancelar candidatura':
            console.log('no case', this.candidaturaId)
            await this.$store.dispatch(actionTypes.CANCELAR_CANDIDATURA, this.candidaturaId)
            break;
          case 'cancelar agendamento':
            await this.$store.dispatch(actionTypes.CANCELAR_AGENDAMENTO, payload.agendamentoId)
            break;
          case 'cancelar entrevista':
            await this.$store.dispatch(actionTypes.CANCELAR_ENTREVISTA, payload.agendamentoId)
            break;
          case 'cancelar convite':
            let convite = {convite_id: this.conviteId}
            await this.$store.dispatch(actionTypes.CANCELAR_CONVITE, convite)
            break;
          case 'recusar convite':
            let resposta = {resposta: 'RECUSOU', vaga_id: this.vagaId}
            await this.$store.dispatch(actionTypes.RESPOSTA_CONVITE, resposta)
            break;
          case 'desativar conta':
            await this.$store.dispatch(actionTypes.DESATIVAR_CONTA)
            this.$router.push({name: 'home'})
            break;
          default:
            break;
        }
        
      }
    }
}
</script>
