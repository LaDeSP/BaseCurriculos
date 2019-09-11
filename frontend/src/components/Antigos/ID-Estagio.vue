<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Estágio</h2></div>
        <div class="panel-body">
            <div v-if="estagio.length == 0" class="text-center">
                    <h4> Você ainda não possui estágio :/ </h4>
            </div>
            <div v-else>
                <div v-for="est in estagio" :key="est.id"> 
                    <h1>{{est.solicitacao.titulo}}</h1>
                    <hr>
                    <p>Data de Início do Estágio: {{est.solicitacao.estagioInicio | dateFormat}}</p>
                    <p>Data de Encerramento do Estágio: {{est.solicitacao.estagioFinal | dateFormat}}</p>
                    <p>Carga Horária: {{est.solicitacao.carga}}</p>
                    <p>Planejamento de Tarefas: {{est.solicitacao.tarefas}}</p>
                </div>
            </div>  
             <hr>
    </div>
</div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment'
    export default {
        data(){
            return{
                estagio: [],
            }
        },
        methods: {

          loadEstagio(){
                const token = localStorage.getItem('token');
                const aluno_id = localStorage.getItem('aluno_id');
                axios
                    .get('http://localhost:8000/api/estagio/' + aluno_id + '?token=' + token)
                    .then(response => {
                        this.estagio = response.data.estagio
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
            this.loadEstagio();
        }
       
    }
</script>

