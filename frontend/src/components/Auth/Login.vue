<template>
    <header class="masthead2">
        <NavBarLogin></NavBarLogin>
        <div class="container">
          <div class="login-form">
            <form>
              <ValidationObserver v-slot="{ invalid }">
                <div class="container" v-if="notificacoes">
                  <span v-for="notificacao in notificacoes" :key="notificacao" class="badge badge-danger badge-pill">
                    {{notificacao}}
                  </span>
                </div>
                <div class="avatar">
                  <span class="fa fa-user fa-5x"></span>
                </div>
                <h2 class="text-center">Login</h2>
                <ValidationProvider name="email" rules="required|email|max:50">
                  <div slot-scope="{errors}">
                    <p class="color-red">{{ errors[0] }}</p>
                    <div class="form-group">
                      <input placeholder="Email" type="email" size="25" name="email" class="form-control" v-model="email" autocomplete="email">
                    </div>
                  </div>
                </ValidationProvider>
                <ValidationProvider name="password" rules="required|min:8|max:30">
                  <div slot-scope="{ errors }">
                    <div class="form-group">
                      <input placeholder="Senha" type="password" size="25" name="password" class="form-control" v-model="password" autocomplete="password">
                    </div>
                    <p class="color-red">{{ errors[0] }}</p>
                  </div>
                </ValidationProvider>
                <div class="form-group">
                    <button :disabled="invalid" @click.prevent="login" type="submit" class="btn btn-primary btn-lg btn-block">Entrar</button>
                </div>
                <div>
                    <a  href="#">Recuperar senha</a>
                </div>
                <div class="clearfix">
                    <p class="text-center small">Não tem uma conta ainda? <a href="#">Clique aqui</a></p>
                </div>
              </ValidationObserver>
            </form>
          </div>
        </div>
    </header>
</template>

<script>
    import NavBarLogin from '../Home/NavBarLogin.vue'
    import {mapGetters} from 'vuex'

    export default {
        components: {
            NavBarLogin
        },
        data(){
            return{
                email: '',
                password: '',
                notificacoes: [],
            }
        },
        computed:{
            ...mapGetters(['permissaoDoUsuario'])
        },
        methods: {
            login(){
               let email = this.email;
               let password = this.password;
               this.$store.dispatch('login', {email, password})
               .then(response => {
                 if(response.error  != undefined){
                    this.notificacoes = response.error;
                  }else{
                    this.redirecionarUsuarioPorPermissao(this.permissaoDoUsuario)
                  }
                })
               .catch(error => console.log(error))
            },
            redirecionarUsuarioPorPermissao(permissao){
                if(permissao === "FISICA"){
                    this.$router.push({ name: 'dashboard-fisica' })
                } else if(permissao === "JURIDICA"){
                    this.$router.push({ name: 'dashboard-juridica' })
                } else {
                    alert('erro no login')
                }
            }
        }
    }

</script>
<style lang="stylus">
    .login
        margin-top -30px;
        display flex
        transform-origin center top
        justify-content center
</style>

