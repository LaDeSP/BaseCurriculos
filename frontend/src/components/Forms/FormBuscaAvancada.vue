<template>
<v-dialog v-model="dialog" max-width="800px">
  <template v-slot:activator="{on: evento, attrs}">
    <v-btn
      depressed 
      class="ml-2"
      large
      dark 
      v-bind="attrs"
      v-on="evento"
    >
      Busca Avançada
    </v-btn>
  </template>
  <v-card>
      <v-card-title>
        <h3 class="text-center">Busca Avançada</h3>
        <v-spacer></v-spacer>
      </v-card-title>
      <v-card-text class="pa-10">
        <v-text-field label="Qualificações "></v-text-field>
        <v-select
          class="mt-0"
          v-model="areaAtuacao"
          :items="itemsGeneros"
          :error-messages="errors"
          label="Área de Atuação *"
          required
        ></v-select>
        <v-select
          class="mt-3"
          v-model="estadoCivil"
          :items="itemsEstadoCivil"
          :error-messages="errors"
          label="Nível de Escolaridade *"
          required
        ></v-select>
        <v-text-field label="Objetivos"></v-text-field>
        <v-text-field label="Histórico Profissional"></v-text-field>
        <v-text-field label="Cidade"></v-text-field>  
        <v-text-field label="Nome"></v-text-field> 
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
        <v-btn class="ml-1" color="primary darken-1" @click="dialog = false">Buscar</v-btn>
  </v-card-actions>
  </v-card>
</v-dialog>
</template>

<script>
export default {
    components:{},
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
