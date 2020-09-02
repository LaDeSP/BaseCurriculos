<template>
<v-dialog v-model="dialog" max-width="700px">
  <template v-slot:activator="{on: evento, attrs}">
    <v-btn
      color="info lighten-1 white--text" 
      v-bind="attrs"
      v-on="evento"
    >
      {{payload.buttonText}}
    </v-btn>
  </template>
  <v-card>
      <v-card-title class="info lighten-1 white--text">
        <h3 class="text-center">{{payload.title}}</h3>
      </v-card-title>
        <v-card-text class="text-justify my-5 black--text justify-center text-center">
            <slot name="texto"> 
              Texto do Modal Detalhes
            </slot>
        </v-card-text>
        <v-card-actions class="text-center justify-center">
          <template v-if="!payload.hasCardActions">
            <v-btn outlined color="red" @click="dialog = false">Fechar</v-btn>
          </template>
          <template v-if="payload.action == 'ver curriculo' && payload.hasCardActions">
            <ModalAlert :payload="recusarCandidato">
              <template>
                <h1 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>recusar</strong></span> esse candidato?</h1>
              </template>
            </ModalAlert>
          </template>
          <template v-if="payload.action == 'ver agendamento'">
           <ModalAlert 
              :candidaturaId="candidaturaId" 
              :observacaoCancelamento="observacaoCancelamento" 
              :payload="cancelarAgendamento"
            >
              <slot>
                <h1 class="text-center">Tem certeza de que deseja <span style="color: #ff0000">
                  <strong>cancelar</strong></span> o processo de agendamento?</h1>
                <h3 class="mt-3" align="center">Você pode fazer uma observação:</h3>
                <v-textarea
                  class="mt-3"
                  v-model="observacaoCancelamento"
                  outlined
                ></v-textarea>
                <h2 class="text-center mt-4">Essa ação não poderá ser desfeita!</h2>
              </slot>
            </ModalAlert>
            <router-link :to="`/agenda/edit/${candidaturaId}`">
              <v-btn class="ml-1" color="primary darken-2 white--text">Fazer uma contraproposta</v-btn>
            </router-link>
            <v-btn class="ml-1" color="success lighten-1 white--text" @click="agendarEntrevista()">Agendar Entrevista</v-btn>
          </template>
        </v-card-actions>
  </v-card>
</v-dialog>
</template>

<script>
import ModalAlert from '@/components/Utils/ModalAlert'
import { actionTypes } from '../../core/constants'

export default {
    components: {ModalAlert},
    props:{
      payload: Object,
      candidaturaId: Number
    },
    data(){
        return{
          dialog: false,
          observacaoCancelamento: '',
          cancelarAgendamento: {
            'title': 'Cancelar Agendamento',
            'action': 'cancelar agendamento'
          },
          recusarCandidato: {
            'title': 'Recusar Candidato',
            action: 'recusar candidato'
          }
        }
    },
    created(){
      console.log('this ', this.candidaturaId, this.payload)
    },
    methods:{
      closeDialog(){
        this.dialog = false
      },
      async agendarEntrevista(){
        let candidatura = {
          candidatura_id: this.candidaturaId
        }

        await this.$store.dispatch(actionTypes.FINALIZAR_AGENDAMENTO)
      }
    }
}
</script>
