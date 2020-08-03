<template>
<v-dialog v-model="dialog" max-width="800px">
  <template v-slot:activator="{on: evento, attrs}">
      <div>
          <template v-if="$route.path == '/'">
            <v-btn
              large
              color="primary"
              dark 
              v-bind="attrs"
              v-on="evento"
            >
              FAÇA PARTE
            </v-btn>
          </template>
          <template v-if="$route.path == '/login'">
            <v-btn
              outlined
              color="green darken-1"
              dark 
              v-bind="attrs"
              v-on="evento"
            >
              Não possuo cadastro
            </v-btn>
        </template>
      </div>
  </template>
  <v-card>
      <v-card-title>
        <h3 class="text-center">Cadastro de Pessoa Física</h3>
        <v-spacer></v-spacer>
        <FormCreatePessoaJuridica @close="closeDialog"></FormCreatePessoaJuridica>
      </v-card-title>
      <v-card-text class="pa-10">
        <v-text-field label="Nome Completo *" required></v-text-field>
        <v-text-field label="CPF *" required></v-text-field>
        <v-text-field label="Email *" type="email" required></v-text-field>
        <v-text-field label="Senha *" type="password" required></v-text-field>  
        <small class="red--text">* Campo obrigatório</small>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <span>
            <v-btn outlined color="red darken-1" text @click="dialog = false">Fechar</v-btn>
        </span>
        <v-spacer></v-spacer>
        <template v-if="this.$route.path == '/'">
          <router-link to="/login" >
            <v-btn outlined color="blue darken-1" text @click="dialog = false">Já possuo cadastro</v-btn>
          </router-link>
        </template>
        <v-btn class="ml-1" outlined color="green darken-1" text @click="dialog = false">Cadastrar</v-btn>
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
    methods:{
      closeDialog(){
        this.dialog = false
      }
    }
}
</script>