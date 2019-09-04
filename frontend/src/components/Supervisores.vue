<template>

    <div class="row">
        <div class="col-md-12">
                <div class="panel panel-default">
                <div class="panel-body">
                     <h3>Supervisores Cadastrados</h3>
                   <div class="table-responsive-md">
                        <table class="table text-center" v-if="supervisores.length > 0">
                        <thead>
                            <tr>
                            <th>#</th>

                            <th class="text-center">Nome</th>
                            <th class="text-center">Telefone</th>
                            <th class="text-center">Empresa</th>
                            <th class="text-center">Cargo</th>
                            <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sup in supervisores" :key="sup.id" :id="sup.id" @superDeleted="onSuperDeleted($event)">
                                <td>{{sup.id}}</td>
                                <td>{{sup.pessoa.nome}}</td>
                                <td>{{sup.telefone}}</td>
                                <td>{{sup.empresa.nome}}</td>
                                <td>{{sup.cargo}}</td>
                                <td>
                                <router-link v-bind:to="'/supervisor/' + sup.id" tag="button" class="btn btn-sm btn-success">Ver</router-link>
                                <router-link v-bind:to="'/supervisor/edit/' + sup.id" tag="button" class="btn btn-sm btn-warning">Editar</router-link>
                                <button @click="onDelete(sup.id)" class="btn btn-sm btn-danger">Apagar</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>

                   </div>
                </div>
                <div class="panel-footer">
                    <router-link to="/novo-supervisor" 
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
         
                ////
                cursos: [],
                supervisores: [],
                campuses: [],

                errors: [],
            }
        },
        methods: {
            loadSupervisores(){
                const token = localStorage.getItem('token');
                axios
                    .get('http://localhost:8000/api/supervisor?token=' + token)
                    .then(response => {
                        this.supervisores = response.data.supervisores
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onDelete(id){
                console.log(this.id)
                const token = localStorage.getItem('token');
                this.$emit('superDeleted', id);
                axios.delete('http://localhost:8000/api/supervisor/' + id + '?token=' + token)
                    .then(
                        response => console.log(response)
                    )
                    .catch(
                        error => console.log(error)
                    )
            },
            onSuperDeleted(id){
                const position = this.supervisores.findIndex((element) => {
                    return element.id == id;
                });

                this.supervisores.splice(position, 1);
            }
        },
        mounted(){
            this.loadSupervisores();
        }
    }
</script>

