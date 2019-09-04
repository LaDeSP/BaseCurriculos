<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Solicitações Pendentes</h2></div>
            <div class="panel-body" v-if="st == false" v-for="soli in solicitacao" :key="soli.id" :value="soli.status" :id="soli.id" @solicitacoesDeleted="onSolicitacoesDeleted($event)">
                <div v-if="value != 'PENDENTE'">
                    <h3><span class="label label-info ">Titulo: {{soli.vaga.titulo}}</span></h3>
                    <p>Status: {{soli.status}}</p>
                    <p>Nome:{{soli.nome}}</p>
                    <p>Data de Início do Estágio: {{soli.estagioInicio | dateFormat}}</p>
                    <p>Data de Encerramento do Estágio: {{soli.estagioFinal | dateFormat}}</p>
                    <p>Planejamento de Tarefas: {{soli.tarefas}}</p>
                
                </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    export default {
        data(){
            return{
                solicitacao: [],
                status: '',
                value: '',
                st: false
            }
        },
        methods: {
            loadSolicitacao(){
                const token = localStorage.getItem('token');
                const aluno_id = localStorage.getItem('aluno_id');

                axios
                    .get('http://localhost:8000/api/solicitacao/aluno/' + aluno_id + '?token=' + token)
                    .then(response => {
                        this.solicitacao = response.data.solicitacao
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
                    return moment(String(value)).format('DD/MM/YYYY | hh:mm')
                }
            }
        },

        mounted(){
            this.loadSolicitacao();
        }
    }
</script>

