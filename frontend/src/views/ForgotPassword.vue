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
              <h2 class="mt-3">Esqueci Minha Senha</h2>
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
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions class="text-center justify-center">
              <v-btn :disabled="invalid" 
                v-on:keyup.enter="submit" class="ml-1" 
                color="success darken-1" 
                @click="requestResetPassword()"
                :loading="pleaseWaitDialog"
              >Resetar</v-btn>   
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
      email: null,
      pleaseWaitDialog: false,
      has_error: false,
      snackbar: false,
      snackNotificacao: '',
      timeout: 5000,
      notificacoes: ''
    }
  },
  methods: {
    requestResetPassword() {
      this.$store.dispatch(actionTypes.FORGOT_PASSWORD, {email: this.email})
      .then(response => {
        if (response.errorEmail){
          this.notificacoes = response.errorEmail;
        }
        else{
          this.notificacoes='';
          this.email=null;
        }
      })
    }
  }
}
</script>