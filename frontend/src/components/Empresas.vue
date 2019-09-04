<template>

    <div class="row">
        <div class="col-md-12">
                <div class="panel panel-default" id="caixa4">
                <div class="panel-body">
                   <div class="table-responsive-md">
                       <h3><center>Empresas Cadastradas</center></h3>
                        <table class="table text-center" v-if="empresas.length > 0">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th class="text-center">Razão Social</th>
                            <th class="text-center">Representante</th>
                            <th class="text-center">Ramo</th>
                              <th class="text-center">CNPJ</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Telefone</th>
                            <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="emp in empresas" :key="emp.id" :id="emp.id" @empDeleted="onEmpDeleted($event)">
                                <td>{{emp.id}}</td>
                                <td>{{emp.nome}}</td>
                                <td>{{emp.representante}}</td>
                                <td>{{emp.ramo}}</td>
                                <td>{{emp.cnpj}}</td>
                                <td>{{emp.email}}</td>
                                <td>{{emp.telefone}}</td>
                                <td>
                                <router-link v-bind:to="'/empresa/' + emp.id" tag="button" class="btn btn-success">Ver</router-link>
                                <router-link v-bind:to="'/empresa/edit/' + emp.id" tag="button" class="btn btn-sm btn-warning">Editar</router-link>
                                <button @click="onDelete(emp.id)" class="btn btn-sm btn-danger">Apagar</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>

                   </div>
                </div>
                <div class="panel-footer">
                    <router-link to="/nova-empresa" 
                        tag="button" class="btn btn-success btn-lg btn-block">Adicionar Nova Empresa</router-link>
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
                cursos: [],
                empresas: [],
                errors: [],
            }
        },
        methods: {
            loadEmpresas(){
                const token = localStorage.getItem('token');
                axios
                    .get('http://localhost:8000/api/empresa?token=' + token)
                    .then(response => {
                        this.empresas = response.data.empresas
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onDelete(id){
                console.log(this.id)
                const token = localStorage.getItem('token');
                this.$emit('empDeleted', id);
                axios.delete('http://localhost:8000/api/empresa/' + id + '?token=' + token)
                    .then(
                        response => console.log(response)
                    )
                    .catch(
                        error => console.log(error)
                    )
            },
            onEmpDeleted(id){
                const position = this.empresas.findIndex((element) => {
                    return element.id == id;
                });

                this.empresas.splice(position, 1);
            }
        },
        mounted(){
            this.loadEmpresas();
        }
    }
</script>
<style>
  #caixa4{
    width: 26%;
    height: 90px;
    margin-left: 35%;
  }
 </style>

