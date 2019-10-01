<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Editar Instituição</h1>
         
            <div class="form-group">
                <label for="nome">Nome da Instituição</label>
                <input type="text" id="nome" name="nome" 
                class="form-control" v-model="nome">
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

            <div v-if="auth === 'ADMIN'">
                <button @click.prevent="editInstituicao" type="submit" class="btn btn-success">Salvar</button>
                <router-link to="{name: ADMDash}" class="btn btn-danger">Cancelar</router-link>
            </div>
            <div v-else-if="auth === 'COORDENADOR'">
                 <button @click.prevent="editInstituicao" type="submit" class="btn btn-success">Salvar</button>
                <router-link to="{name: COORDash}" class="btn btn-danger">Cancelar</router-link>
            </div>

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
                contato: '',
                email: '',
                site: '',
                rua: '',
                bairro: '',
                cidade: '',
                cep: '',
                ///
                auth: localStorage.getItem('role')
                
            }
        },
        methods: {
            editInstituicao(){
                const token = localStorage.getItem('token');
                axios.put('http://localhost:8000/api/instituicao/' + this.$route.params.id + '?token=' + token, 

                    {
                    
                        nome: this.nome,
                        contato: this.contato,
                        email: this.email,
                        site: this.site,
                        rua: this.rua,
                        bairro: this.bairro,
                        cidade: this.cidade,
                        cep: this.cep
                        
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                        alert("Editado com sucesso"),
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
   
            getEditInstituicao(){
                
                const token = localStorage.getItem('token');
                axios.get('http://localhost:8000/api/instituicao/create?token=' + token)
                    .then(response => {
                        console.log(response)
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },

    
    }
</script>
