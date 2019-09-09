<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Cadastro de Pessoa Física</h1>
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" 
                class="form-control" v-model="name" placeholder="Ex. nome.sobrenome">
            </div>

            <div class="form-group"> 
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" name="cpf" placeholder="Ex. 999.999.999-99" v-model="cpf">
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
  import axios from 'axios';

    export default {
    
        data(){
            return{

                name:'',
                email: '',
                password: '',
                cpf: '',
                role: 'FISICA'
                
            }
        },
        methods: {
            
            register(){

                axios.post('http://localhost:8000/api/pfisica', 
                //pra autenticar, precisa de mais uma header
                //essa header só vai dizer pro beck q isso é uma chamada ajax
                    {
                        
                        email: this.email, 
                        password: this.password,
                        name: this.name,
                        cpf: this.cpf,
                        role: this.role
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response)
                    )
                    .catch(
                        (error) => console.log(error)
                    );

                  //  if(this.role == 'ADMIN'){
                    //    this.$router.push({ name: 'ADMDash' })
                   // }else if(role == 'COORDENADOR'){
                    //    this.$router.push({ name: 'COORDash' })
                    //}
                    
            }
        },
    }
</script>
