<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Cadastro de Instituição</h1>
            
            <div class="form-group">
                <label for="nome">Nome da Instituição</label>
                <input type="text" id="nome" name="nome" 
                class="form-control" v-model="nome">
            </div>
        
            <div class="form-group">
                <label for="cnpj">CNPJ</label>
                <input type="text" class="form-control" name="cnpj" v-model="cnpj">
            </div>
            <div class="form-group"> 
                <label for="tipo">Tipo</label>
                    <select class="custom-select" name="tipo" id="tipo" v-model="tipo">
                        <option value="Pública">Pública</option>
                        <option value="Privada">Privada</option>
                    </select>
            </div>
            <div class="form-group">
                <label for="contato">Telefone</label>
                <input type="text" class="form-control" name="contato" v-model="contato">
            </div>
             <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" v-model="email">
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
                <label for="campus">Campus</label>
                    <select class="custom-select" name="campus" v-model="campus">
                        <option value="" disabled selected>Selecione um campus</option>
                        <option v-for="cam in campuses" :key="cam.id" :value="cam.id">
                            {{cam.nome}}
                        </option>
                    </select>    
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

                nome: '',
                cnpj: '',
                tipo: '',
                contato: '',
                email: '',
                site: '',
                rua: '',
                bairro: '',
                cidade: '',
                cep: '',
                campus: '',
                campuses: [],
                ///
                auth: localStorage.getItem('role')
                
            }
        },
        methods: {
            register(){
                const token = localStorage.getItem('token');
                axios.post('http://localhost:8000/api/instituicao?token=' + token, 
               
                    {
                        nome: this.nome,
                        cnpj: this.cnpj,
                        tipo: this.tipo,
                        contato: this.contato,
                        email: this.email,
                        site: this.site,
                        rua: this.rua,
                        bairro: this.bairro,
                        cidade: this.cidade,
                        cep: this.cep,
                        campus: this.campus,
    
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
          
            loadCampus(){
                const token = localStorage.getItem('token');
                axios.get('http://localhost:8000/api/instituicao/create?token=' + token)
                    .then(response => {
                        this.campuses = response.data.campuses
                        console.log(response)
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },

        mounted(){
            this.loadCampus();
        }
        
    }
</script>
