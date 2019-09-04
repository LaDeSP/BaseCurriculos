<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Informações Pessoais</h2></div>
        <div class="panel-body">
              <div v-for="alu in aluno" :key="alu.id">
                <h4>Nome: <strong>{{alu.pessoa.nome}}</strong></h4>
                <hr>
                <p>Data de Nascimento: {{alu.pessoa.nascimento | dateFormat}}</p>
                <p>CPF: {{alu.pessoa.cpf}}</p>
                <p>RG: {{alu.pessoa.rg}}</p>
                <p>Rua: {{alu.endereco.rua}}</p>
                <p>Bairro: {{alu.endereco.bairro}}</p>
                <p>Cidade: {{alu.endereco.cidade}}</p>
                <p>CEP: {{alu.endereco.cep}}</p>
                <p>Telefone Fixo: {{alu.telefone.fixo}}</p>
                <p>Telefone Celular: {{alu.telefone.celular}}</p>
                <p>RGA: {{alu.rga}}</p>
                <p>Instituição: {{alu.instituicao.nome}}</p>
                <p>Campus: {{alu.campus.nome}}</p>
                <p>Curso: {{alu.curso.nome}}</p>
                <p>Semestre: {{alu.semestre}}</p>
            </div>  
             <hr>
            
                <estagio></estagio>
        </div>
        <div class="panel-footer">
            <div v-if="isAdmin == true || isCoor == true">
                <router-link to="/alunos" tag="button" class="btn btn-lg btn-danger ">Voltar</router-link>
            </div>
                    
        </div>   
        
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment'
    import Estagio from './ID-Estagio.vue';

    export default {

        data(){
            return{
                aluno: [],
                isAdmin: false,
                isCoor: false,
                isAluno: false
            }
        },
        components: {'estagio': Estagio},
        methods: {

            loadAluno(){
                const token = localStorage.getItem('token');
                const param = this.$route.params.id
                const aluno_id = localStorage.getItem('aluno_id');
                
                if(param == undefined){
                    console.log(aluno_id)
                    axios
                        .get('http://localhost:8000/api/aluno/' + aluno_id + '?token=' + token)
                        .then(response => {
                            this.aluno = response.data.aluno
                            console.log(response);
                        })
                        .catch(
                            error => console.log(error)
                        );
                }else if(typeof param != undefined){
                    axios
                        .get('http://localhost:8000/api/aluno/' + this.$route.params.id + '?token=' + token)
                        .then(response => {
                            this.aluno = response.data.aluno
                            console.log(response);
                        })
                        .catch(
                            error => console.log(error)
                        );
                }
                
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
            const role = localStorage.getItem('role')
            if(role == 'ADMIN'){
                this.isAdmin = true
            }else if(role == 'COORDENADOR'){
                this.isCoor = true
            }else if(role == 'ALUNO'){
                this.isAluno = true
            }

            this.loadAluno();
        }
       
    }
</script>

