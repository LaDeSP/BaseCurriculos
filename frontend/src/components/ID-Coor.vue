<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Perfil do Coordenador</h2></div>
        <div class="panel-body">
              <div v-for="cor in coordenador" :key="cor.id">
                <h1>Nome: {{cor.pessoa.nome}}</h1>
                <hr>
                <p>Data de Nascimento: {{cor.pessoa.nascimento | dateFormat}}</p>
                <p>CPF: {{cor.pessoa.cpf}}</p>
                <p>RG: {{cor.pessoa.rg}}</p>
               
                <p>Telefone Fixo: {{cor.telefone.fixo}}</p>
                <p>Telefone Celular: {{cor.telefone.celular}}</p>
                <p>Instituição: {{cor.instituicao.nome}}</p>
                <p>Campus: {{cor.campus.nome}}</p>
                <p>Curso: {{cor.curso.nome}}</p>
                <p>Cargo: {{cor.cargo}}</p>
                <p>SIAPE: {{cor.siape}}</p>
            </div>  
             <hr>
        </div>
        <div class="panel-footer">
                    <router-link to="/coordenadores" 
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
                coordenador: [],
            }
        },
        methods: {

            loadCoordenador(){
                const token = localStorage.getItem('token');
                axios
                    .get('http://localhost:8000/api/coordenador/' + this.$route.params.id + '?token=' + token)
                    .then(response => {
                        this.coordenador = response.data.coordenador
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
            this.loadCoordenador();
        }
       
    }
</script>

