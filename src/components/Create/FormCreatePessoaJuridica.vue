<template>
<v-dialog v-model="dialog" max-width="800px">
  <template v-slot:activator="{on: evento, attrs}">
    <v-btn
      outlined
      color="grey darken-1" 
      text
      v-bind="attrs"
      v-on="evento"
      @click="close"
    >
      Sou uma pessoa jurídica
    </v-btn>
  </template>
  <v-card>
      <v-card-title>
        <h3 class="text-center">Cadastro de Pessoa Jurídica</h3>
        <v-spacer></v-spacer>
      </v-card-title>
      <v-card-text class="pa-10 black--text">
        <p>Para sua empresa fazer parte do nosso sistema, entre em contato com a Associação Comercial de Corumbá (ACIC) por meio desses meios:</p>
        <p>Email: teste@hotmail.com</p>
        <p>Telefone: teste@hotmail.com</p>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <span>
            <v-btn outlined color="red darken-1" text @click="dialog = false">Fechar</v-btn>
        </span>
        <v-spacer></v-spacer>
  </v-card-actions>
  </v-card>
</v-dialog>
</template>

<script>
import FormCreatePessoaJuridica from './FormCreatePessoaJuridica'
export default {
    components:{FormCreatePessoaJuridica},
    data(){
        return{
            dialog: false
        }
    },
    created(){
        console.log('this.route', this.$route)
    },
    methods: {
      close(){
        console.log('emit')
        this.$emit('close')
        this.dialog = true        
      }
    }
}
</script>