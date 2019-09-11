<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Perfil da Empresa</h2></div>
        <div class="panel-body">
            <h1>Perfil da Empresa</h1>
              <div v-for="emp in empresa" :key="emp.id">
                <h1>Nome: {{emp.nome}}</h1>
                <hr>
                <p>Representante: {{emp.representante}}</p>
                <p>Ramo: {{emp.ramo}}</p>
                <p>CNPJ: {{emp.cnpj}}</p>
                <p>Telefone: {{emp.telefone}}</p>
                <p>Email: {{emp.email}}</p>
                <p>Site: {{emp.site}}</p>
                <p>Endereço: Rua {{emp.endereco.rua}}, Bairro {{emp.endereco.bairro}}</p>
                <p>Cidade: {{emp.endereco.cidade}}</p>
                <p>CEP: {{emp.endereco.cep}}</p>
            </div>  
             <hr>
        </div>
        <div class="panel-footer">
                    <router-link to="/empresas" 
                        tag="button" class="btn btn-lg btn-danger ">Voltar</router-link>
        </div>   
        
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        data(){
            return{
                empresa: [],
            }
        },
        methods: {

            loadEmpresa(){
                const token = localStorage.getItem('token');
                axios
                    .get('http://localhost:8000/api/empresa/' + this.$route.params.id + '?token=' + token)
                    .then(response => {
                        this.empresa = response.data.empresa
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },
        created(){
            this.loadEmpresa();
        }
       
    }
</script>

