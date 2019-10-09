<template>
    <div class="container">
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
                              <input placeholder="Email" type="email"  name="email" class="form-control" v-model="email">
                              {{ errors[0] }}
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-text"><i class="fa fa-key fa-fw"></i></span>
                        <ValidationProvider name="password" rules="required|min:8|max:30">
                            <input placeholder="Senha" type="password" name="password" class="form-control" v-model="password">
                            <!-- <div slot-scope="{ errors }"><p>{{ errors[0] }}</p></div> -->
                        </ValidationProvider>
                    </div>
                </div>
                <div class="col-sm-3 text-right" style="padding-left: 35px;">
                    <slot name="icone">
                        <i class="far fa-user fa-5x login-icon"></i>
                    </slot>
                </div>
                <div class="fix-form-modal text-center">
                    <button :disabled="invalid" @click.prevent="login" type="submit" class="btn btn-lg btn-primary">Entrar</button>
                </div>
            </ValidationObserver>
        </div>
    </div>
</template>

<script>

    export default {

        data(){
            return{
                email: '',
                password: '',
                notificacoes: [],
            }
        },
        methods: {
            login(){
               let email = this.email;
               let password = this.password;
               this.$store.dispatch('login', {email, password})
               .then(() => console.log(this.$store.getters))
               .catch(error => console.log(error))
            }
        },

        created(){
            console.log(this.$store.getters);
        }
    }

</script>
