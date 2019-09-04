<template>

    <div class="row">
        <div class="col-md-12">
                <div class="panel panel-default">
                <div class="panel-body">
                   <div class="table-responsive-md">
                       <h3>Instituições Cadastradas</h3>
                        <table class="table text-center" v-if="instituicoes.length > 0">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th class="text-center">Nome</th>
                            <th class="text-center">CNPJ</th>
                            <th class="text-center">Tipo</th>
                              <th class="text-center">Telefone</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Site</th>
                            <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="inst in instituicoes" :key="inst.id" :id="inst.id" @instDeleted="onInstDeleted($event)">
                                <td>{{inst.id}}</td>
                                <td>{{inst.nome}}</td>
                                <td>{{inst.cnpj}}</td>
                                <td>{{inst.tipo}}</td>
                                <td>{{inst.email}}</td>
                                <td>{{inst.telefone}}</td>
                                <td>{{inst.site}}</td>
                                <td>
                                <router-link v-bind:to="'/instituicao/' + inst.id" tag="button" class="btn btn-sm btn-primary">Ver</router-link>
                                <router-link v-bind:to="'/instituicao/edit/' + inst.id" tag="button" class="btn btn-sm btn-warning">Editar</router-link>
                                <button @click="onDelete(inst.id)" class="btn btn-sm btn-danger">Apagar</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>

                   </div>
                </div>
                <div class="panel-footer">
                    <router-link to="/nova-instituicao" 
                        tag="button" class="btn btn-success btn-lg">Adicionar Nova Instituição</router-link>
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
              
       
                nome: '',
               
                rua: '',
                bairro: '',
                cidade: '',
                cep: '',
                instituicao: '',
                campus: '',
                id: '',
                ////
                cursos: [],
                instituicoes: [],
                campuses: [],
           
                errors: [],
            }
        },
        methods: {
            loadInstituicoes(){
                const token = localStorage.getItem('token');
                axios
                    .get('http://localhost:8000/api/instituicao?token=' + token)
                    .then(response => {
                        this.instituicoes = response.data.instituicoes
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onDelete(id){
                console.log(this.id)
                const token = localStorage.getItem('token');
                this.$emit('instDeleted', id);
                axios.delete('http://localhost:8000/api/instituicao/' + id + '?token=' + token)
                    .then(
                        response => console.log(response)
                    )
                    .catch(
                        error => console.log(error)
                    )
            },
            onInstDeleted(id){
                const position = this.instituicoes.findIndex((element) => {
                    return element.id == id;
                });

                this.instituicoes.splice(position, 1);
            }
        },
        mounted(){
            this.loadInstituicoes();
        }
    }
</script>

