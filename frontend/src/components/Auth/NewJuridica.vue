<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <ValidationObserver v-slot="{ invalid }">
            <form>
                <h1>Cadastro de Pessoa Jurídica</h1>

                <div class="form-group">
                    <label for="cnpj">* CNPJ</label>
                    <ValidationProvider name="cnpj" rules="required|numeric|digits:14">
                        <div slot-scope="{ errors }">
                            <input type="text" class="form-control" name="cnpj" v-model="cnpj" maxlength="14" minlength="14">
                            <p>{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>
                </div>

                <div class="form-group">
                    <label for="name">* Nome</label>
                    <ValidationProvider name="name" rules="required|max:50">
                        <div slot-scope="{ errors }">
                            <input type="text" name="name" 
                            class="form-control" v-model="name" maxlength="50">
                            <p>{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>
                </div>

                <div class="form-group">
                    <label for="ramo">* Ramo</label>
                    <ValidationProvider name="ramo" rules="required|max:50">
                        <div slot-scope="{ errors }">
                            <input type="ramo" name="ramo" 
                            class="form-control" v-model="ramo" maxlength="50">
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
                            <input type="password" name="password" 
                            class="form-control" v-model="password" minlength="8" maxlength="30">
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
                ramo: '',
                cnpj: '',
                role: 'JURIDICA'

            }
        },
        methods: {

            register(){

                this.axios.post('http://localhost:8000/api/pjuridicas',

                    {

                        email: this.email,
                        password: this.password,
                        name: this.name,
                        cnpj: this.cnpj,
                        ramo: this.ramo,
                        role: this.role

                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => {
                            this.$session.start(),
                            this.$session.set('jwt', response.data.token),
                            this.$session.set('name', response.data.name),
                            this.$session.set('role', response.data.role),
                            this.$session.set('user_id', response.data.user_id),
                            console.log(response);
                            //this.$router.push({ name: 'dashboard-juridica' })
                        }
                    )
                    .catch(
                        (error) => console.log(error)
                    );
            }
        },
    }
</script>
