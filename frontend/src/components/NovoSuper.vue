<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Cadastro de Supervisor</h1>
            <div class="form-group">
                <label for="username">Nome de Usuário</label>
                <input type="text" id="username" name="username" 
                class="form-control" v-model="username" placeholder="Ex. nome.sobrenome">
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
            
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="nome" id="nome" name="nome" 
                class="form-control" v-model="nome">
            </div>
        
            <div class="form-group"> 
                <label for="nascimento">Data de Nascimento</label>
                <input type="date" class="form-control" name="nascimento" v-model="nascimento">
            </div>
            <div class="form-group"> 
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" name="cpf" placeholder="Ex. 999.999.999-99" v-model="cpf">
            </div>
            <div class="form-group">
                <label for="rg">RG</label>
                <input type="text" class="form-control" name="rg" placeholder="RG" v-model="rg">
            </div>
            <div class="form-group"> 
                <label for="telefone">Telefone</label>
                <div class="form-row">
                    <div class="col-6">
                        <input type="text" class="form-control" name="fixo" placeholder="Fixo" v-model="fixo">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="celular" placeholder="Celular" v-model="celular"> 
                    </div>
                </div>
            </div>
            <div class="form-group"> 
                <label for="empresa">Empresa</label>
                    <select class="custom-select" name="empresa" v-model="empresa">
                        <option value="" disabled selected>Selecione uma empresa</option>
                        <option v-for="emp in empresas" :key="emp.id" :value="emp.id">
                            {{emp.nome}}
                        </option>
                    </select>
            </div>
            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" name="cargo" v-model="cargo">
            </div>
            <div class="form-group">
                <label for="area">Área</label>
                <input type="text" class="form-control" name="area" v-model="area">
            </div>
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

                username:'',
                email: '',
                password: '',
                ////
                nome: '',
                nascimento: '',
                cpf: '',
                rg: '',
                celular: '',
                fixo: '',
                area: '',
                empresa: '',
                cargo: '',
                role: 'SUPERVISOR',
                ////
                empresas: [],
                ///
                auth: localStorage.getItem('role')
                
            }
        },
        methods: {
            register(){
                const token = localStorage.getItem('token');
                axios.post('http://localhost:8000/api/supervisor?token=' + token, 
                    {
                        username: this.username, 
                        email: this.email, 
                        password: this.password,
                        ////
                        nome: this.nome,
                        nascimento: this.nascimento,
                        cpf: this.cpf,
                        rg: this.rg,
                        area: this.area,
                        celular: this.celular,
                        fixo: this.fixo,
                        cargo: this.cargo,
                        empresa: this.empresa,
                        role: this.role
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                        alert("Cadastrado com sucesso"),
                    )
                    .catch(
                        (error) => console.log(this.role)
                    );

                    if(this.auth === 'ADMIN'){
                        this.$router.push({ name: 'ADMDash' })
                    }else if(auth === 'COORDENADOR'){
                        this.$router.push({ name: 'COORDash' })
                    }
                    
            },
         
            loadICC(){
                const token = localStorage.getItem('token');
                axios.get('http://localhost:8000/api/supervisor/create?token=' + token)
                    .then(response => {
                        this.empresas = response.data.empresas
                        console.log(response)
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },
        
        mounted(){
            this.loadICC();
        }
        
    }
</script>
