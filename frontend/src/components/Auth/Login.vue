<template>
    <header class="masthead2">
        <NavBarLogin></NavBarLogin>
        <div class="container">
          <div class="login-form">
            <ValidationObserver v-slot="{ invalid }">
              <form>
                <div class="container" v-if="notificacoes">
                  <span v-for="notificacao in notificacoes" :key="notificacao" class="badge badge-danger badge-pill">
                    {{notificacao}}
                  </span>
                </div>
                <div class="avatar">
                  <span class="fa fa-user fa-5x"></span>
                </div>
                <h2 class="text-center">Login</h2>
                <ValidationProvider name="email" rules="required|email|max:250">
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
                  <button :disabled="invalid" v-on:keyup.enter="login" @click.prevent="login" type="submit" class="btn btn-primary btn-lg btn-block">Entrar</button>
                  <br>
                  <div>
                    <a  href="#">Recuperar senha</a>
                  </div>
                  <br>
                  <strong>Não possui uma conta?  <button @click.prevent="showModal" class="btn btn-outline-info" > Cadastre-se</button></strong>
                </div>
            </form>
          </ValidationObserver>
          <Modal v-show="ModalCadastro" @close="closeModal">
            <template v-slot:header><h3>Quem é você?</h3></template>
            <template v-slot:body>
              <OpcoesHome></OpcoesHome>
            </template>
          </Modal>
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
                ModalCadastro:false,
            }
        },
        computed:{
            ...mapGetters(['permissaoDoUsuario'])
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
               this.$store.dispatch('login', {email, password})
                .then(response => {
                  
                 if(response.error  != undefined){
                    this.notificacoes = response.error;
                    console.log(this.notificacoes);
                  }else if(response.user.deleted_at == null){
                    console.log('response', response)
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

