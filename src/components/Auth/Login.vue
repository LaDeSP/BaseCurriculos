<template>
<div class="login">
  <v-row class="fill-height" align="center" justify="center">
    <v-col cols="10" md="8" sm="10" xs="2">
      <v-card class="mx-auto elevation-12" max-width="800" align="center" justify="center">
          <v-card-title>
                <div class="avatar">
                <span class="fa fa-user fa-3x"></span>
              </div>
          </v-card-title>
          <v-card-text class="pa-10">
            <v-form>
              <v-text-field
                label="Email"
                name="email"
                prepend-icon="mdi-email"
                type="text"
              ></v-text-field>
              <v-text-field
                id="password"
                label="Senha"
                name="senha"
                prepend-icon="mdi-lock"
                type="password"
              ></v-text-field>
          </v-form>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
              <span>
                  <v-btn outlined color="brown darken-1" text @click="dialog = false">Esqueci minha senha</v-btn>
              </span>
              <v-spacer></v-spacer>
                <FormCreatePessoaFisica></FormCreatePessoaFisica>
                <v-btn class="ml-1" outlined color="primary darken-1" text @click="dialog = false">Entrar</v-btn>              
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</div>
</template>

<script>
    import {actionTypes} from '../../core/constants'
    import FormCreatePessoaFisica from '../Create/FormCreatePessoaFisica';
    import OpcoesHome from '../Home/OpcoesHome.vue'
    import {mapGetters} from 'vuex'
    import card from '../Utils/Card.vue';
    import NavBar from '../Utils/NavBar.vue';

    export default {
        components: {
          FormCreatePessoaFisica, OpcoesHome,card, NavBar
        },
        data(){
            return{
                email: '',
                password: '',
                notificacoes: [],
                ModalCadastro:false
            }
        },
        computed:{
            ...mapGetters(['permissaoDoUsuario'])
        },
        mounted(){
          this.setImage()
          console.log(this.image)
        },
        methods: {
          showModal(){
          this.ModalCadastro = true;
          },
          closeModal(){
            this.ModalCadastro = false;
          },
          login(){
              let email = this.email;
              let password = this.password;
              this.$store.dispatch(actionTypes.LOGIN, {email, password})
              .then(response => {

                if(response.error  != undefined){
                  this.notificacoes = response.error;
                }else if(response.user.deleted_at == null){
                  this.redirecionarUsuarioPorPermissao(this.permissaoDoUsuario)
                }else{
                  this.$router.push({ name: 'conta-desativada' })
                }
              })
              .catch(error => console.log(error))
          },
          redirecionarUsuarioPorPermissao(permissao){
              if(permissao === "FISICA"){
                  this.$router.push({ name: 'dashboard' })
              } else if(permissao === "JURIDICA"){
                  this.$router.push({ name: 'dashboard' })
              } else {
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

