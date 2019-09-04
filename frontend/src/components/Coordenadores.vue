<template>

    <div class="row">
        <div class="col-md-12">
                <div class="panel panel-default">
                <div class="panel-body">
                     <h3>Coordenadores Cadastrados</h3>
                   <div class="table-responsive-md">
                        <table class="table text-center" v-if="coordenadores.length > 0">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th class="text-center">SIAPE</th>
                            <th class="text-center">Nome</th>
                            <th class="text-center">Instituição</th>
                            <th class="text-center">Campus</th>
                            <th class="text-center">Curso</th>
                            <th class="text-center">Cargo</th>
                            <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="coor in coordenadores" :key="coor.id" :id="coor.id" @coorDeleted="onCoorDeleted($event)">
                                <td>{{coor.id}}</td>
                                <td>{{coor.siape}}</td>
                                <td>{{coor.pessoa.nome}}</td>
                                <td>{{coor.instituicao.nome}}</td>
                                <td>{{coor.campus.nome}}</td>
                                <td>{{coor.curso.nome}}</td>
                                <td>{{coor.cargo}}</td>
                                <td>
                                <router-link v-bind:to="'/coordenador/' + coor.id" tag="button" class="btn btn-sm btn-success">Ver</router-link>
                                <router-link v-bind:to="'/coordenador/edit/' + coor.id" tag="button" class="btn btn-sm btn-warning">Editar</router-link>
                                <button @click="onDelete(coor.id)" class="btn btn-sm btn-danger">Apagar</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>

                   </div>
                </div>
                <div class="panel-footer">
                    <router-link to="/novo-coordenador" 
                        tag="button" class="btn btn-lg btn-success ">Adicionar Novo Aluno</router-link>
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
                coordenadores: [],
                campuses: [],

                errors: [],
            }
        },
        methods: {
            loadCoordenadores(){
                const token = localStorage.getItem('token');
                axios
                    .get('http://localhost:8000/api/coordenador?token=' + token)
                    .then(response => {
                        this.coordenadores = response.data.coordenadores
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onDelete(id){
                console.log(this.id)
                const token = localStorage.getItem('token');
                this.$emit('coorDeleted', id);
                axios.delete('http://localhost:8000/api/coordenador/' + id + '?token=' + token)
                    .then(
                        response => console.log(response)
                    )
                    .catch(
                        error => console.log(error)
                    )
            },
            onCoorDeleted(id){
                const position = this.coordenadores.findIndex((element) => {
                    return element.id == id;
                });

                this.coordenadores.splice(position, 1);
            }
        },
        mounted(){
            this.loadCoordenadores();
        }
    }
</script>

