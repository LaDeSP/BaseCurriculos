<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Cadastro de Pessoa Jurídica</h1>

            <div class="form-group"> 
                <label for="cnpj">CNPJ</label>
                <input type="text" class="form-control" name="cnpj" placeholder="Ex. 999.999.999-99" v-model="cnpj">
            </div>

            <div class="form-group">
                <label for="name">Nome da Empresa</label>
                <input type="text" id="name" name="name" 
                class="form-control" v-model="name" placeholder="Ex. nome.sobrenome">
            </div>

            <div class="form-group">
                <label for="ramo">Ramo</label>
                <input type="ramo" id="ramo" name="ramo" 
                class="form-control" v-model="ramo">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                class="form-control" v-model="email">
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" 
                class="form-control" v-model="password">
            </div>
            
            <hr>
            
            <button @click.prevent="register" type="submit" class="btn btn-primary">Cadastrar</button>
            <router-link to="/dashboard" class="btn btn-danger">Cancelar</router-link>
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
                ramo: '',
                cnpj: '',
                role: 'JURIDICA'
                
            }
        },
        methods: {
            
            register(){

                this.axios.post('http://localhost:8000/api/pjuridica', 

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
                            console.log(this.$session.get('jwt'))
                           
                        }
                    )
                    .catch(
                        (error) => console.log(error)
                    );
                    
            }
        },
    }
</script>
