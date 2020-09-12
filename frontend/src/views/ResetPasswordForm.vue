<template>
  <v-row align="center" justify="center">
    <v-col cols="12" lg="10" md="10" sm="10">
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
            @click="closeAndRedirect()"
          >Fechar</v-btn>
        </template>
      </v-snackbar>
      <ValidationObserver v-slot="{ invalid }">
        <v-form>
          <v-card class="mx-auto" max-width="800" align="center" justify="center">
            <v-card-title class="justify-center text-center font-weight-bold">Nova Senha</v-card-title>
            <v-card-text class="pl-10 pr-10">
              <template v-if="notificacoes">
                <span class="rounded-lg pa-1 mr-1 mt-3 mb-10 text-center red lighten-2 white--text" v-for="(notificacao, index) in notificacoes" :key="index">
                  {{notificacao}}
                </span>
              </template>
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
              <ValidationProvider v-slot="{ errors }" name="password" rules="required|min:8|max:30">
                  <v-text-field
                    v-model="password"
                    label="Nova Senha *"
                    :error-messages="errors"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                  ></v-text-field>
              </ValidationProvider>
              <ValidationProvider v-slot="{ errors }" name="password_confirmation" rules="required|min:8|max:30">
                  <v-text-field
                    v-model="password_confirmation"
                    label="Confirmar Nova Senha *"
                    :error-messages="errors"
                    name="password_confirmation"
                    prepend-icon="mdi-lock"
                    type="password"
                  ></v-text-field>
              </ValidationProvider>

            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions class="text-center justify-center">
              <v-btn :disabled="invalid" 
                v-on:keyup.enter="submit" class="ml-1" 
                color="success darken-1" 
                @click="resetPassword()"
                :loading="pleaseWaitDialog"
              >Enviar</v-btn>   
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
import {actionTypes} from '@/core/constants'
export default {
    data() {
      return {
        token: null,
        email: null,
        password: null,
        password_confirmation: null,
        has_error: false,
        pleaseWaitDialog: false,
        snackbar: false,
        snackNotificacao: '',
        timeout: 5000,
        notificacoes: []
      }
    },
    methods: {
      async resetPassword() {
        this.pleaseWaitDialog = true
        await this.$store.dispatch(actionTypes.RESET_PASSWORD, {
            token: this.$route.params.token,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation
        })
        .then(response => {
          if(response.errorToken){
            this.notificacoes = response.errorToken
            this.pleaseWaitDialog = false
          }else{
            this.notificacoes = []
            this.email = null
            this.password = null
            this.password_confirmation = null
            this.snackNotificacao = 'Senha atualizada com sucesso!'
            this.snackbar = true
            this.pleaseWaitDialog = false
        }
        })
      },
      async closeAndRedirect(){
        this.snackbar = false
        this.$router.push({name: 'login'})
      }
    }
}
</script>