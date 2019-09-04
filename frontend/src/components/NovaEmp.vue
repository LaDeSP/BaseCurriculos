<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Cadastro de Empresa</h1>
            
            <div class="form-group">
                <label for="razao">Razão Social</label>
                <input type="text" id="razao" name="razaoSocial" 
                class="form-control" v-model="razaoSocial">
            </div>
            <div class="form-group">
                <label for="ramo">Ramo</label>
                <input type="text" class="form-control" name="ramo" v-model="ramo">
            </div>
            <div class="form-group">
                <label for="cnpj">CNPJ</label>
                <input type="text" class="form-control" name="cnpj" v-model="cnpj">
            </div>
            <div class="form-group">
                <label for="contato">Telefone</label>
                <input type="text" class="form-control" name="contato" v-model="contato">
            </div>
             <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" v-model="email">
            </div>
            <div class="form-group">
                <label for="site">Site</label>
                <input type="text" class="form-control" name="site" v-model="site">
            </div>
            <div class="form-group">
                <label for="endereco">Endereço</label>
                    <div class="form-row">
                        <div class="col-3">
                            <input type="text" class="form-control" name="rua" placeholder="Rua" v-model="rua">
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" name="bairro" placeholder="Bairro" v-model="bairro">
                        </div>    
                        <div class="col-3">
                            <input type="text" class="form-control" name="cidade" placeholder="Cidade" v-model="cidade">
                        </div>    
                        <div class="col">
                            <input type="text" class="form-control" name="cep" placeholder="CEP" v-model="cep">
                        </div>
                    </div>
            </div>
            <div class="form-group">
                <label for="representante">Representante</label>
                <input type="text" class="form-control" name="representante" v-model="representante">
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

                razaoSocial: '',
                ramo: '',
                cnpj: '',
                contato: '',
                email: '',
                site: '',
                rua: '',
                bairro: '',
                cidade: '',
                cep: '',
                representante: '',
                ///
                auth: localStorage.getItem('role')
                
            }
        },
        methods: {
            register(){
                const token = localStorage.getItem('token');
                axios.post('http://localhost:8000/api/empresa?token=' + token, 
              
                    {
                        razaoSocial: this.razaoSocial,
                        ramo: this.ramo,
                        cnpj: this.cnpj,
                        contato: this.contato,
                        email: this.email,
                        site: this.site,
                        rua: this.rua,
                        bairro: this.bairro,
                        cidade: this.cidade,
                        cep: this.cep,
                        representante: this.representante,
            
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
                    
            }
        },
        
        mounted(){
           
        }
        
    }
</script>
