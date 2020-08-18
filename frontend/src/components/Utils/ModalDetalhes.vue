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
          <template v-if="payload.action == 'ver agendamento'">
            <ModalAlert :payload="cancelarAgendamento">
              <template>
                <h1 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>cancelar</strong></span> o agendamento?</h1>
              </template>
            </ModalAlert>
            <v-btn class="ml-1" color="primary darken-2 white--text" @click="fazerContraproposta()">Fazer uma contraproposta</v-btn>
            <v-btn class="ml-1" color="success lighten-1 white--text" @click="agendarEntrevista()">Agendar Entrevista</v-btn>
          </template>
        </v-card-actions>
  </v-card>
</v-dialog>
</template>

<script>
import ModalAlert from '@/components/Utils/ModalAlert'

export default {
    components: {ModalAlert},
    props:{
      payload: Object
    },
    data(){
        return{
          dialog: false,
          cancelarAgendamento: {
            'title': 'Cancelar Agendamento',
            'action': 'cancelar agendamento'
          }
        }
    },
    created(){
      //console.log('this ', this.payload)
    },
    methods:{
      closeDialog(){
        this.dialog = false
      },
      async fazerContraproposta(){

      },
      async agendarEntrevista(){

      }
    }
}
</script>
