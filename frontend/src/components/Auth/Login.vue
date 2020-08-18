<template>
<div class="login">
  <v-row class="fill-height" align="center" justify="center">
      <v-col cols="12" md="8" sm="10" xs="6">
      <v-card class="mx-auto elevation-12" max-width="800" align="center" justify="center">
        <v-card-title>
            <div class="avatar">
              <span class="fa fa-user fa-3x"></span>
            </div>
        </v-card-title> 
        <template v-if="pleaseWait">
          <PleaseWait></PleaseWait>
        </template>
        <template v-else>
          <ValidationObserver ref="observer" v-slot="{ invalid }">
          <v-form>
            <v-card-text class="pa-10">
              <template v-if="notificacoes">
                <span class="rounded-lg pa-1 text-center red lighten-2 white--text" v-for="notificacao in notificacoes" :key="notificacao">
                    {{notificacao}}
                </span>
              </template>
              <ValidationProvider v-slot="{ errors }" name="email" rules="required|email|max:250">
                <v-text-field 
                  class="mt-3"
                  label="Email *"
                  v-model="email"
                  name="email"
                  :error-messages="errors"
                  prepend-icon="mdi-email"
                  type="text"
                ></v-text-field>
              </ValidationProvider>
              <ValidationProvider v-slot="{ errors }" name="senha" rules="required|min:8|max:30">
                  <v-text-field
                    v-model="password"
                    label="Senha *"
                    :error-messages="errors"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                  ></v-text-field>
              </ValidationProvider>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <span>
                <v-btn outlined color="brown darken-1" text @click="dialog = false">Esqueci minha senha</v-btn>
              </span>
              <v-spacer></v-spacer>
              <FormCreatePessoaFisica></FormCreatePessoaFisica>
              <v-btn :disabled="invalid" v-on:keyup.enter="login" class="ml-3" outlined color="primary darken-1" text @click.prevent="login">Entrar</v-btn>              
            </v-card-actions>
          </v-form>
          </ValidationObserver>
        </template>
      </v-card>
    </v-col>
  </v-row>
</div>
</template>

<script>
import {actionTypes} from '../../core/constants'
import {mapState} from 'vuex'
import NavBar from '../Utils/NavBar.vue'
import FormCreatePessoaFisica from '../Create/FormCreatePessoaFisica'

export default {
  components: {FormCreatePessoaFisica, NavBar},
  data(){
    return{
        email: '',
        password: '',
        pleaseWait: false,
        notificacoes: []
    }
  },
  computed:{
    ...mapState(['tipoPermissao'])
  },
  created(){
   
  },
  methods: {
    async login(){
      let email = this.email,
          password = this.password
      this.pleaseWait = true
      await this.$store.dispatch(actionTypes.LOGIN, {email, password})
        .then(response => {
          if(response.error  != undefined){
            this.notificacoes = response.error
            this.pleaseWait = false
          }else if(response.user.deleted_at == null){
            this.redirecionarUsuarioPorPermissao(this.tipoPermissao)
          }else{
            this.$router.push({ name: 'conta-desativada' })
          }
        }).catch(error => console.log(error))
    },
    redirecionarUsuarioPorPermissao(permissao){
      if(permissao === "FISICA" || permissao === 'JURIDICA' || permissao == 'MASTER'){
        this.$router.push({name: 'dashboard' })
      }else{
        alert('erro no login')
      }
    }
  }
}
</script>

<style lang="stylus">
  .login
    background-image: url("../../../img/funfo.jpg")
    background-size: cover 
    height 100vh
  .avatar
    position: absolute
    margin: 0 auto
    left: 0
    right: 0
    top: -50px
    width: 95px
    height: 95px
    border-radius: 50%
    z-index: 9
    background: #F0FFFF
    padding: 15px
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1)
</style>

