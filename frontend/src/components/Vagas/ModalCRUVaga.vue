<template>
<v-dialog v-model="dialog" max-width="800px">
  <template v-slot:activator="{on: evento, attrs}">
      <slot name="button">
        butao
      </slot>
  </template>
  <v-card>
      <v-card-title>
        <h3 class="text-center">Cadastro de Pessoa Física</h3>
        <v-spacer></v-spacer>
        
      </v-card-title>
      <template>
        <ValidationObserver ref="observer" v-slot="{ invalid }">
        <v-form>
          <v-card-text class="pa-10">
            <template v-if="notificacoes">
              <span class="rounded-lg pa-1 mr-1 mb-10 text-center red lighten-2 white--text" v-for="notificacao in notificacoes" :key="notificacao">
                {{notificacao[0]}}
              </span>
            </template>
            <template v-if="pleaseWait">
              <PleaseWait></PleaseWait>
            </template>
            <template v-else>
              <ValidationProvider v-slot="{ errors }" name="name" rules="required|max:250">
                <v-text-field 
                  label="Nome Completo *"
                  v-model="name"
                  name="name"
                  :error-messages="errors"
                  type="text"
                ></v-text-field>
              </ValidationProvider>
              <ValidationProvider v-slot="{ errors }" name="cpf" rules="required|numeric|digits:11">
                <v-text-field 
                  label="CPF *"
                  v-model="cpf"
                  :counter="11"
                  name="cpf"
                  :error-messages="errors"
                  type="text"
                ></v-text-field>
              </ValidationProvider>
              <ValidationProvider v-slot="{ errors }" name="email" rules="required|email|max:250">
                <v-text-field 
                  label="Email *"
                  v-model="email"
                  name="email"
                  :error-messages="errors"
                  type="text"
                ></v-text-field>
              </ValidationProvider>
              <ValidationProvider v-slot="{ errors }" name="senha" rules="required|min:8|max:30">
                  <v-text-field
                    v-model="password"
                    label="Senha *"
                    :error-messages="errors"
                    name="password"
                    type="password"
                  ></v-text-field>
              </ValidationProvider>
            </template>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <span>
              <v-btn outlined color="red darken-1" text @click="dialog = false">Fechar</v-btn>
            </span>
            <v-spacer></v-spacer>
            <template v-if="$route.path == '/'">
              <router-link to="/login" >
                <v-btn outlined color="blue darken-1" text @click="dialog = false">Já possuo cadastro</v-btn>
              </router-link>
            </template>
            <v-btn :disabled="invalid" v-on:keyup.enter="register" class="ml-1" outlined color="green darken-1" text @click="register">Cadastrar</v-btn>
          </v-card-actions>
        </v-form>
        </ValidationObserver>
      </template>
  </v-card>
</v-dialog>
</template>

<script>
import {actionTypes} from '../../core/constants'
export default {
  components:{},
  data(){
    return{
      dialog: false,
      pleaseWait: false,
      name: '',
      email: '',
      password: '',
      cpf: '',
      role: 'FISICA',
      notificacoes: []
    }
  },
  methods:{
    closeDialog(){
      this.dialog = false
    },
    async register(){
      let fisica = {
        name: this.name,
        email: this.email,
        cpf: this.cpf, 
        password: this.password, 
        role: this.role
      }
      this.pleaseWait = true
      await this.$store.dispatch(actionTypes.CREATE_PESSOA_FISICA, fisica)
        .then(response => {
          if(response.error  != undefined){
            this.notificacoes = response.error
            this.pleaseWait = false
          }else{
            this.$router.push({ name: 'dashboard', params:{cadastroFisicaSucesso: true} })
          }
        })
    }
  }
}
</script>
