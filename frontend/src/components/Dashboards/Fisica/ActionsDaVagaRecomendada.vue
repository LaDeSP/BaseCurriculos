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
      @click="criarCandidatura()"
    >
      Se Candidatar
    </v-btn>
  </template>
  <v-card>
      <v-card-title>
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
export default {
  props: {
    vagaId: Number,
    vaga: Object 
  },
  data() {
    return {
      dialog: false,
      notificacao: ''
    }
  },
  methods: {
    async criarCandidatura(){
      let payload = {
        vagaId: this.vagaId, 
        userId: this.$store.state.auth.user.id
      }
      this.$emit('handleNotif', 'Candidatura realizada com sucesso')
      await this.$store.dispatch(actionTypes.REQUEST_VAGA_DASH, payload)
    }
  }
}
</script>