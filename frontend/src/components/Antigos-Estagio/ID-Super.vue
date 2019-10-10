<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Perfil do Supervisor</h2></div>
        <div class="panel-body">
              <div v-for="sup in supervisor" :key="sup.id">
                <h1>Nome: {{sup.pessoa.nome}}</h1>
                <hr>
                <p>Data de Nascimento: {{sup.pessoa.nascimento | dateFormat}}</p>
                <p>CPF: {{sup.pessoa.cpf}}</p>
                <p>RG: {{sup.pessoa.rg}}</p>
                <p>Telefone Fixo: {{sup.telefone.fixo}}</p>
                <p>Telefone Celular: {{sup.telefone.celular}}</p>
                <p>Empresa: {{sup.empresa.nome}}</p>
                <p>Campus: {{sup.campus.nome}}</p>
                <p>Cargo: {{sup.cargo}}</p>
                <p>Área: {{sup.area}}</p>
            </div>  
             <hr>
        </div>
        <div class="panel-footer">
                    <router-link to="/supervisores" 
                        tag="button" class="btn btn-lg btn-danger">Voltar</router-link>
        </div>   
        
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment'
    export default {
        data(){
            return{
                supervisor: [],
            }
        },
        methods: {

            loadSupervisores(){
                const token = localStorage.getItem('token');
                axios
                    .get('http://localhost:8000/api/supervisor/' + this.$route.params.id + '?token=' + token)
                    .then(response => {
                        this.supervisor = response.data.supervisor
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },
        filters:{
           
            dateFormat: function(value){
                if (value) {
                    return moment(String(value)).format('DD/MM/YYYY')
                }
            }
        }, 
        created(){
            this.loadSupervisores();
        }
       
    }
</script>

