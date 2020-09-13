<template>
<v-dialog v-model="dialog" max-width="800px">
  <template v-slot:activator="{on: evento, attrs}"> 
    <v-btn
      color="primary"
      class="mr-1"
      dark 
      v-bind="attrs"
      v-on="evento"
    >
      Ver Mais
    </v-btn>
    <v-btn
      color="success"
      dark 
      :loading="pleaseWaitDialog"
      @click="criarCandidatura()"
    >
      Se Candidatar
    </v-btn>
    <v-dialog
      v-model="pleaseWaitDialog"
      hide-overlay
      persistent
      width="300"
    > 
      <v-card class="grey darken-3 text-center white--text" dark>
        <v-card-text>Por favor, aguarde...
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </template>
  <v-card>
      <v-card-title class="text-center justify-center">
        <h3 class="primary--text">{{vaga.titulo}}</h3>
      </v-card-title>
      <v-card-text class="black--text">
        <strong>Descrição:</strong> {{vaga.descricao}}<br/>
        <strong>Cargo:</strong> {{vaga.cargo}}<br/>
        <strong>Área de Atuação:</strong> {{vaga.area.tipo}}<br/>
        <strong>Jornada de Trabalho:</strong> {{vaga.jornada}}<br/>
        <strong>Salário:</strong> {{vaga.salario}}<br/>
        <strong>Benefícios:</strong> {{vaga.beneficio}}<br/>
        <strong>Requisitos:</strong> {{vaga.requisito}}<br/>      
      </v-card-text>
      <v-card-actions class="text-center justify-center">
        <v-btn
          color="grey white--text"
          @click="dialog = false"
        >
          Voltar
        </v-btn>
        <v-btn
          color="success"
          dark 
          @click="criarCandidatura()"
        >
          Se Candidatar
        </v-btn>
      </v-card-actions>
  </v-card>
</v-dialog>
</template>

<script>
import { actionTypes } from '../../../core/constants'
import {mapState} from 'vuex'
export default {
  props: {
    vagaId: Number,
    vaga: Object,
    vagaBuscada: Boolean
  },
  data() {
    return {
      dialog: false,
      notificacao: '',
      pleaseWaitDialog: false
    }
  },
  computed: {
    ...mapState(['resultado', 'auth'])
  },
  methods: {
    async criarCandidatura(){
      let payload = {
        vagaId: this.vagaId, 
        userId: this.auth.user.id
      }
      this.pleaseWaitDialog = true
      let response = await this.$store.dispatch(actionTypes.REQUEST_VAGA_DASH, payload)
      console.log('response er', response, response.error != undefined)
      if(response.error != undefined){
        this.$emit('handleNotif', response.error)
      }else{
        this.$emit('handleNotif', 'Candidatura realizada com sucesso')
        console.log('EMIT actions')
        if(this.vagaBuscada){
          for(let i = 0; i < this.resultado.length; i++){
            if (this.resultado[i].id == this.vagaId) {
              this.resultado.splice(i, 1)
            }
          }
        }
      }
      this.pleaseWaitDialog = false
    }
  }
}
</script>