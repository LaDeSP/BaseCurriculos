<template>
    <header class="masthead2">
        <NavBarLogin></NavBarLogin>
        <div class="container">
          <div class="login-form">
            <form>
              <ValidationObserver v-slot="{ invalid }">
                <div v-if="notificacoes">
                  <span v-for="notificacao in notificacoes" :key="notificacao[0]" class="badge badge-danger badge-pill">
                    {{notificacao[0]}}
                  </span>
                </div>
                <div class="avatar">
                  <span class="fa fa-user fa-5x"></span>
                </div>
                <h2 class="text-center">Login</h2>
                <ValidationProvider name="email" rules="required|email|max:50">
                  <div slot-scope="{errors}">
                    {{ errors[0] }}
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
                    {{ errors[0] }}
                  </div>
                </ValidationProvider>
                <div class="form-group">
                  <button :disabled="invalid" @click.prevent="login" type="submit" class="btn btn-primary btn-lg btn-block">Entrar</button>
                  <br>
                  <div>
                    <a  href="#">Recuperar senha</a>
                  </div>
                  <br>
                  <strong>Já possui uma conta?  <button @click.prevent="showModal" class="btn btn-warning" > Cadastre-se</button></strong>
                  <Modal v-show="Modalrain" @click.prevent="closeModal">
                    <template v-slot:header><h3>Quem é você?</h3></template>
                    <template v-slot:body>
                      <OpcoesHome></OpcoesHome>
                    </template>
                  </Modal>
                </div>
              </ValidationObserver>
            </form>
          </div>
        </div>
    </header>
</template>

<script>
    import NavBarLogin from '../Home/NavBarLogin.vue'
    import Modal from '../Utils/Modal.vue';
    import OpcoesHome from '../Home/OpcoesHome.vue';
    import {mapGetters} from 'vuex'
    import card from '../Utils/Card.vue';
    export default {
        components: {
            NavBarLogin, Modal, OpcoesHome,card
        },
        data(){
            return{
                email: '',
                password: '',
                notificacoes: [],
                Modalrain:false,
            }
        },
        computed:{
            ...mapGetters(['permissaoDoUsuario'])
        },
        methods: {
          showModal(){
            this.Modalrain = true;
          },
          closeModal(){
            this.Modalrain = false;
          },
            login(){
               let email = this.email;
               let password = this.password;
               this.$store.dispatch('login', {email, password})
               .then(() => {
                   this.redirecionarUsuarioPorPermissao(this.permissaoDoUsuario)
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

