<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Cadastro de Pessoa Física</h1>
            <div class="form-group">
                <label for="name">Nome</label>
                <ValidationProvider name="name" rules="required">
                    <div slot-scope="{ errors }">
                        <input type="text" id="name" name="name" 
                        class="form-control" v-model="name" placeholder="Ex. nome.sobrenome">
                        <p>{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>
            </div>

            <div class="form-group"> 
                <label for="cpf">CPF</label>
                <ValidationProvider name="cpf" rules="required">
                    <div slot-scope="{ errors }">
                        <input type="text" class="form-control" name="cpf" placeholder="Ex. 999.999.999-99" v-model="cpf">
                        <p>{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <ValidationProvider name="email" rules="required|email">
                    <div slot-scope="{ errors }">
                        <input type="email" id="email" name="email" 
                        class="form-control" v-model="email">
                        <p>{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" 
                class="form-control" v-model="password">
            </div>
            
            <hr>
            
            <button @click.prevent="register" type="submit" class="btn btn-primary">Cadastrar</button>
            <router-link to="/login" class="btn btn-default">Voltar</router-link>
        </form>
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
