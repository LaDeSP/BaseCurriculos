<template>
 <div class="row justify-content-center">
    <div class="col-sm-12">
        <ValidationObserver v-slot="{ invalid }">

        <form>
            <div v-if="notificacoes">
                <span v-for="notificacao in notificacoes" :key="notificacao[0]" class="badge badge-danger badge-pill">
                    {{notificacao[0]}}
                </span>
            </div>
            <div class="form-group">
                <label for="name">* Nome Completo</label>
                <ValidationProvider name="name" rules="required|max:50">
                    <div slot-scope="{ errors }">
                        <input type="text" name="name"
                        class="form-control" v-model="name" maxlength="50">
                        <p>{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>
            </div>

            <div class="form-group">
                <label for="cpf">* CPF</label>
                <ValidationProvider name="cpf" rules="required|numeric|digits:11">
                    <div slot-scope="{ errors }">
                        <input type="text" class="form-control" name="cpf" v-model="cpf" maxlength="11" minlength="11">
                        <p>{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>
            </div>

            <div class="form-group">
                <label for="email">* Email</label>
                <ValidationProvider name="email" rules="required|email|max:50">
                    <div slot-scope="{ errors }">
                        <input type="email" name="email"
                        class="form-control" v-model="email" maxlength="50">
                        <p>{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>
            </div>

            <div class="form-group">
                <label for="password">* Senha</label>
                <ValidationProvider name="password" rules="required|min:8|max:30">
                    <div slot-scope="{ errors }">
                        <input type="password" id="password" name="password"
                        class="form-control" v-model="password" maxlength="30" minlength="8">
                        <p>{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>
            </div>

            <hr>

            <button :disabled="invalid" @click.prevent="register" type="submit" class="btn btn-primary">Cadastrar</button>
            <router-link to="/login" class="btn btn-default">Voltar</router-link>
        </form>
        </ValidationObserver>

    </div>
</div>
</template>

<script>

    export default {

        data(){
            return{

                name:'',
                email: '',
                password: '',
                cpf: '',
                role: 'FISICA',
                notificacoes: [],


            }
        },
        methods: {

            register(){

                this.axios.post('http://localhost:8000/api/pfisicas',

                    {

                        email: this.email,
                        password: this.password,
                        name: this.name,
                        cpf: this.cpf,
                        role: this.role
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => {
                            if(response.data.error  != undefined){
                                this.notificacoes = response.data.error;
                                return;
                            }
                            this.$session.start(),
                            this.$session.set('jwt', response.data.token),
                            this.$session.set('name', response.data.name),
                            this.$session.set('role', response.data.role),
                            this.$session.set('user_id', response.data.user_id)
                            this.$router.push({ name: 'dashboard-fisica' })
                        }
                    )
                    .catch(
                        (error) => console.log(error)
                    );
            }
        },
    }
</script>
