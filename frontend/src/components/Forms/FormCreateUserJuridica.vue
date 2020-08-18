<template>
<v-row class="fill-height" align="center" justify="center">
  <v-col cols="12" lg="12" md="8" sm="12">
    <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
    <v-card>
      <v-card-title class="justify-center text-center"><h2>Cadastrar Pessoa Jurídica</h2></v-card-title>
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
                  label="Nome da Empresa*"
                  v-model="name"
                  name="name"
                  :error-messages="errors"
                  type="text"
                ></v-text-field>
              </ValidationProvider>
              <ValidationProvider v-slot="{ errors }" name="cnpj" rules="required|numeric|digits:14">
                <v-text-field 
                  label="CNPJ *"
                  v-model="cnpj"
                  maxlength="14"
                  minlength="14" 
                  required='autofocus'
                  :counter="14"
                  name="cnpj"
                  :error-messages="errors"
                  type="text"
                ></v-text-field>
              </ValidationProvider>
              <ValidationProvider v-slot="{ errors }" name="areaAtuacao" rules="required">
                <v-select
                  class="mt-0"
                  v-model="areaAtuacao"
                  :items="itemsAreaAtuacao"
                  item-text="tipo"
                  item-value="id"
                  :error-messages="errors"
                  label="Área de Atuação *"
                  required
                ></v-select>
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
          <v-card-actions class="text-center justify-center">
            <v-btn :disabled="invalid" v-on:keyup.enter="register" class="ml-1" outlined color="green darken-1" text @click="register">Cadastrar</v-btn>
          </v-card-actions>
        </v-form>
        </ValidationObserver>
      </template>
    </v-card>
  </v-col>
</v-row>

</template>

<script>
import {actionTypes} from '../../core/constants'
export default {
  data(){
    return{
      dialog: false,
      pleaseWait: false,
      name: '',
      email: '',
      password: '',
      areaAtuacao: '',
      itemsAreaAtuacao: [],
      cnpj: '',
      role: 'JURIDICA',
      notificacoes: []
    }
  },
  async created(){
    await this.$store.dispatch(actionTypes.GET_AREAS)
      .then(response => {
        this.itemsAreaAtuacao = response.areas
      })
  },
  methods:{
    async register(){
      let juridica = {
        name: this.name,
        email: this.email,
        cnpj: this.cnpj, 
        area: this.areaAtuacao,
        password: this.password, 
        role: this.role
      }
      this.pleaseWait = true
      await this.$store.dispatch(actionTypes.CREATE_PESSOA_JURIDICA, juridica)
        .then(response => {
          if(response.error  != undefined){
            this.notificacoes = response.error
            this.pleaseWait = false
          }else{
            this.$router.push({ name: 'dashboard', params:{cadastroJuridicaSucesso: true} })
          }
        })
    }
  }
}
</script>
