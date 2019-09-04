<template>

    <div class="row">
        <div class="col-md-12">
                <div class="panel panel-default">
                <div class="panel-body">
                     <h3>Alunos Cadastrados</h3>
                   <div class="table-responsive-md">
                        <table class="table text-center" v-if="alunos.length > 0">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th class="text-center">RGA</th>
                            <th class="text-center">Nome</th>
                            <th class="text-center">Instituição</th>
                            <th class="text-center">Campus</th>
                            <th class="text-center">Curso</th>
                            <th class="text-center">Semestre</th>
                            <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="alu in alunos" :key="alu.id" :id="alu.id" @alunoDeleted="onAlunoDeleted($event)">
                                <td>{{alu.id}}</td>
                                <td>{{alu.rga}}</td>
                                <td>{{alu.pessoa.nome}}</td>
                                <td>{{alu.instituicao.nome}}</td>
                                <td>{{alu.campus.nome}}</td>
                                <td>{{alu.curso.nome}}</td>
                                <td>{{alu.semestre}}</td>
                                <td>
                                <router-link v-bind:to="'/aluno/' + alu.id" tag="button" class="btn btn-sm btn-success">Ver</router-link>
                                <router-link v-bind:to="'/aluno/edit/' + alu.id" tag="button" class="btn btn-sm btn-warning">Editar</router-link>
                                <button @click="onDelete(alu.id)" class="btn btn-sm btn-danger">Apagar</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>

                   </div>
                </div>
                <div class="panel-footer">
                    <router-link to="/novo-aluno" 
                        tag="button" class="btn btn-lg btn-success">Adicionar Novo Aluno</router-link>
                </div>               
            </div>
        </div>
    </div>


    
</template>

<script>
    import axios from 'axios';
    export default {
        data(){
            return{
                alunos: [],
                /////modal -> edit
                nome: '',
                nascimento: '',
                cpf: '',
                rg: '',
                rua: '',
                bairro: '',
                cidade: '',
                cep: '',
                celular: '',
                fixo: '',
                rga: '',
                semestre: '',
                curso: '',
                instituicao: '',
                campus: '',
                id: '',
                ////
                cursos: [],
                instituicoes: [],
                campuses: [],
                editAluno: [],
                errors: [],
            }
        },
        methods: {
            loadAlunos(){
                const token = localStorage.getItem('token');
                axios
                    .get('http://localhost:8000/api/aluno?token=' + token)
                    .then(response => {
                        this.alunos = response.data.alunos
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onDelete(id){
                console.log(this.id)
                const token = localStorage.getItem('token');
                this.$emit('alunoDeleted', id);
                axios.delete('http://localhost:8000/api/aluno/' + id + '?token=' + token)
                    .then(
                        response => console.log(response)
                    )
                    .catch(
                        error => console.log(error)
                    );
                 this.$router.push({ name: 'alunos' })
            },
            onAlunoDeleted(id){
                //vou pegar index do elemento q foi deletado
                const position = this.alunos.findIndex((element) => {
                    //true or false, é esse o elemento q vc quer ou não? se for igual, manda ele
                    return element.id == id;
                });

                this.alunos.splice(position, 1);
            }
        },
        mounted(){
            this.loadAlunos();
        }
    }
</script>

