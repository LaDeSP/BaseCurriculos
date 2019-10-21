<template>
    <header class="masthead2">
        <NavBarLogin></NavBarLogin>
        <div class="container login">
            <div class="card login" style="width: 30rem;">
                <br>
                <i class="fas fa-user fa-6x" style="color: Dodgerblue;"></i>
                <div class="card-body">
                    <div class="row justify-content-center" >
                        <ValidationObserver v-slot="{ invalid }">
                            <div class="col-sm-8">
                                <div v-if="notificacoes">
                                    <span v-for="notificacao in notificacoes" :key="notificacao[0]" class="badge badge-danger badge-pill">
                                        {{notificacao[0]}}
                                    </span>
                                </div>
                                <div class="form-group input-group margin-bottom-sm">
                                    <span class="input-group-text"><i class="fas fa-envelope fa-fw"></i></span>
                                    <ValidationProvider name="email" rules="required|email|max:50">
                                        <div slot-scope="{errors}">
                                        <input placeholder="Email" type="email" size="25" name="email" class="form-control" v-model="email">
                                        {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-text"><i class="fa fa-key fa-fw"></i></span>
                                    <ValidationProvider name="password" rules="required|min:8|max:30">
                                        <input placeholder="Senha" type="password" size="25" name="password" class="form-control" v-model="password">
                                       <!-- <div slot-scope="{ errors }"><p>{{ errors[0] }}</p></div> -->
                                    </ValidationProvider>
                                </div>
                                <div class="row align-items-center" style="display: inline-block; margin-left:-150px;">
                                    <a  href="#">Recuperar senha</a>
                                </div>
                            </div>
                            <div class="fix-form-modal text-center" >
                                <br>
                                <button :disabled="invalid" @click.prevent="login" type="submit" class="btn btn-lg btn-primary">Entrar</button>
                            </div>
                        </ValidationObserver>
                    </div>

                </div>
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
<style lang="stylus">
    .login
        margin-top -30px;
        display flex
        transform-origin center top
        justify-content center
</style>
