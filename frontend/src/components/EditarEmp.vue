<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Editar Empresa</h1>
         
            <div class="form-group">
                <label for="razaoSocial">Razão Social</label>
                <input type="text" id="razaoSocial" name="razaoSocial" 
                class="form-control" v-model="razaoSocial">
            </div>
            <div class="form-group">
                <label for="contato">Ramo</label>
                <input type="text" class="form-control" name="ramo" v-model="ramo">
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
                <label for="representante">Representante</label>
                <input type="text" class="form-control" name="representante" placeholder="Representante" v-model="representante">
            </div>
            <div v-if="auth === 'ADMIN'">
                <button @click.prevent="editEmpresa" type="submit" class="btn btn-success">Salvar</button>
                <router-link to="{name: ADMDash}" class="btn btn-danger">Cancelar</router-link>
            </div>
            <div v-else-if="auth === 'COORDENADOR'">
                 <button @click.prevent="editEmpresa" type="submit" class="btn btn-success">Salvar</button>
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

                representante: '',
                ramo: '',
                razaoSocial: '',
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
            editEmpresa(){
                const token = localStorage.getItem('token');
                axios.put('http://localhost:8000/api/empresa/' + this.$route.params.id + '?token=' + token, 

                    {
                    
                        razaoSocial: this.razaoSocial,
                        ramo: this.ramo,
                        contato: this.contato,
                        email: this.email,
                        site: this.site,
                        rua: this.rua,
                        bairro: this.bairro,
                        cidade: this.cidade,
                        cep: this.cep,
                        representante: this.representante
                        
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
   
        },

    
    }
</script>
