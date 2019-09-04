<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Solicitações Pendentes</h2></div>
            <div class="panel-body" v-if="st == false" v-for="soli in solicitacoes" :key="soli.id" :value="soli.status" :id="soli.id" @solicitacoesDeleted="onSolicitacoesDeleted($event)">
                <div v-if="value != 'PENDENTE'">
                    <h3><span class="label label-info ">Titulo: {{soli.vaga.titulo}}</span></h3>
                    <p>Nome:{{soli.nome}}</p>
                    <p>Data de Início do Estágio: {{soli.estagioInicio | dateFormat}}</p>
                    <p>Data de Encerramento do Estágio: {{soli.estagioFinal | dateFormat}}</p>
                    <p>Planejamento de Tarefas: {{soli.tarefas}}</p>
                    <p>Carga Horária: {{soli.carga}}</p>
                
                    <div>
                        <button @click="onAcceptRequest(soli.id)" class="btn btn-sm btn-success">Aprovar</button>
                        <button @click="onDenyRequest(soli.id)" class="btn btn-sm btn-danger">Rejeitar</button>
                    </div>
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
                solicitacoes: [],
                status: '',
                value: '',
                st: false
            }
        },
        methods: {
            loadSolicitacoes(){
                const token = localStorage.getItem('token');
                const coor_id = localStorage.getItem('coor_id');

                axios
                    .get('http://localhost:8000/api/solicitacao/' + coor_id + '?token=' + token)
                    .then(response => {
                        this.solicitacoes = response.data.solicitacoes
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            },

            onAcceptRequest(id){
                const token = localStorage.getItem('token');
                this.st = true
                this.status = 'APROVADO'

                axios.post('http://localhost:8000/api/solicitacao/fb/' + id + '?token=' + token, 
               
                    {
                       status: this.status
                    },

                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                       
                    )
                    .catch(
                        (error) => console.log(error)
                    );
                
                axios.post('http://localhost:8000/api/estagio/' + id + '?token=' + token, 
               
                    {
                       soli_id: id
                    },

                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                    )
                    .catch(
                        (error) => console.log(error)
                    );   
            },

            onDenyRequest(id){
                const token = localStorage.getItem('token');
                this.status = 'REJEITADO'

                axios.post('http://localhost:8000/api/solicitacao/fb/' + id + '?token=' + token, 
               
                    {
                       status: this.status
                    },

                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                       
                       //alert("Solicitação feita com sucesso"),
                    )
                    .catch(
                        (error) => console.log(error)
                    );

                    //this.$router.push({ name: 'COORDash' })
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
            this.loadSolicitacoes();
        }
    }
</script>

