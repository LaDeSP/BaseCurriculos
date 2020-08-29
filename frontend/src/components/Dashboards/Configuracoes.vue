<template>
  <v-row align="center" justify="center">
    <v-col cols="12" lg="8" md="10" sm="4">
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-snackbar
        top
        v-model="snackbar"
        :timeout="timeout"
      > {{snackNotificacao}}
        <template v-slot:action="{ attrs }">
          <v-btn
            color="blue"
            text
            v-bind="attrs"
            @click="snackbar = false"
          >Fechar</v-btn>
        </template>
      </v-snackbar>
      <ValidationObserver v-slot="{ invalid }">
        <v-form>
          <v-card class="mx-auto" max-width="800" align="center" justify="center">
            <v-card-text class="pa-10">
              <template v-if="notificacoes">
                <span class="rounded-lg pa-1 mr-1 mt-3 mb-10 text-center red lighten-2 white--text" v-for="(notificacao, index) in notificacoes" :key="index">
                  {{notificacao[0]}}
                </span>
              </template>
              <h2 class="mt-3">Dados</h2>
              <ValidationProvider v-slot="{errors}" name="email" rules="required|email|max:250">
                <v-text-field
                  v-model="email"
                  :error-messages="errors"
                  label="Email"
                  name="email"
                  prepend-icon="mdi-email"
                  type="email"
                  ></v-text-field>
              </ValidationProvider>
              <template v-if="tipoPermissao == 'FISICA'">
                <ValidationProvider name="cpf" rules="required|numeric|digits:11">
                  <v-text-field
                    v-model="cpf"
                    label="CPF"
                    name="cpf"
                    prepend-icon="mdi-file-document-edit"
                    type="text"
                  ></v-text-field>
                </ValidationProvider>
              </template>
              <template v-else-if="tipoPermissao == 'JURIDICA'">
                <ValidationProvider v-slot="{errors}" name="cnpj" rules="required|numeric|digits:14">
                  <v-text-field
                    v-model="cnpj"
                    :error-messages="errors"
                    label="CNPJ"
                    name="cnpj"
                    prepend-icon="mdi-file-document-edit"
                    type="text"
                  ></v-text-field>
                </ValidationProvider>
              </template>
              <v-divider></v-divider>
              <h2 class="mt-3">Segurança</h2>
              <ValidationProvider v-slot="{errors}" name="newPassword" rules="min:8|max:30" vid="newPassword">
                <v-text-field
                v-model="newPassword"
                :error-messages="errors"
                label="Nova Senha"
                name="newPassword"
                prepend-icon="mdi-lock"
                type="password"
                ></v-text-field>
              </ValidationProvider>
              <template v-if="newPassword != ''">
                <ValidationProvider v-slot="{errors}" name="password" rules="required|min:8|max:30">
                  <v-text-field
                    :error-messages="errors"
                    v-model="password"
                    label="Senha Atual"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                  ></v-text-field>
                </ValidationProvider>
              </template>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions class="text-center justify-center">
              <v-btn :disabled="invalid" 
                v-on:keyup.enter="submit" class="ml-1" 
                color="success darken-1" 
                @click="submit()"
                :loading="pleaseWaitDialog"
              >Salvar</v-btn>   
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
            </v-card-actions>
          </v-card>
        </v-form>
      </ValidationObserver>
    </v-col>
  </v-row>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import {actionTypes} from '@/core/constants'
export default {
  data() {
    return {
      email: '',
      cpf: '',
      password: '',
      cnpj: '',
      snackbar: false,
      pleaseWaitDialog: false,
      snackNotificacao: '',
      timeout: 2000,
      newPassword: '',
      notificacoes: [],
      isLoaded: false
  }
  },
  async created(){
    this.email = this.auth.user.email
    if(this.tipoPermissao == 'FISICA'){
      await this.$store.dispatch(actionTypes.GET_PESSOA_FISICA)
      this.cpf = this.pessoaFisicaInfo.cpf
      this.isLoaded = true
    }else if(this.tipoPermissao == 'JURIDICA'){
      await this.$store.dispatch(actionTypes.GET_PESSOA_JURIDICA)
      this.cnpj = this.pessoaJuridicaInfo.cnpj
      this.isLoaded = true
    }
  },
  computed: {
    ...mapState(['auth', 'pessoaFisicaInfo', 'pessoaJuridicaInfo']),
    ...mapGetters(['tipoPermissao'])
  },
  methods: {
    submit(){
      this.pleaseWaitDialog = true
      let payloadUser = {
        email: this.email,
        password: this.password,
        newPassword: this.newPassword
      }
      if(this.tipoPermissao == 'FISICA'){
        payloadUser.cpf = this.cpf 
        this.$store.dispatch(actionTypes.UPDATE_USER_FISICA, payloadUser)
          .then(response => {
            if(response.error != undefined){
              this.notificacoes = response.error
              this.pleaseWaitDialog = false
            }
          })
      }else if(this.tipoPermissao == 'JURIDICA'){
        payloadUser.cnpj = this.cnpj
        this.$store.dispatch(actionTypes.UPDATE_USER_JURIDICA, payloadUser)
          .then(response => {
            if(response.error != undefined){
              this.notificacoes = response.error
              this.pleaseWaitDialog = false
            }else{
              this.notificacoes = ''
              this.snackNotificacao = 'Dados atualizados com sucesso!'
              this.pleaseWaitDialog = false
              this.snackbar = true
            }
          })
      }
    }
  }
}
</script>