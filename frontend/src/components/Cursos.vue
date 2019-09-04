<template>

    <div class="row">
        <div class="col-md-12">
                <div class="panel panel-default">
                <div class="panel-body">
                   <div class="table-responsive-md">
                           <h3>Cursos Cadastrados</h3>
                        <table class="table text-center" v-if="cursos.length > 0">
                        <thead>
                            <tr>
                            <th>#</th>

                            <th class="text-center">Nome</th>
                            <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cur in cursos" :key="cur.id" :id="cur.id" @cursoDeleted="onCursoDeleted($event)">
                                <td>{{cur.id}}</td>
                                <td>{{cur.nome}}</td>
                                <td>
                                <button @click="onDelete(cur.id)" class="btn btn-sm btn-danger">Apagar</button>
                                </td>
                            </tr>
                        </tbody>
                        </table>

                   </div>
                </div>
                <div class="panel-footer">
                    <router-link to="/novo-curso" 
                        tag="button" class="btn btn-lg btn-success ">Adicionar Novo Curso</router-link>
                </div>               
            </div>
        </div>
    </div>


    
</template>

<script>
    import axios from 'axios';
    export default {
        props: ['inst_id'],
        data(){
            return{
                curso: '',
                instituicao: '',
                campus: '',
                ////
                cursos: [],
                errors: [],
            }
        },
        methods: {
            loadCursos(){
                const token = localStorage.getItem('token');
                axios
                    .get('http://localhost:8000/api/instituicao/' + this.inst_id + '?token=' + token)
                    .then(response => {
                        this.cursos = response.data.cursos
                        console.log(response);
                    })
                    .catch(
                        error => console.log(error)
                    );
            },
            onDelete(id){
    
                const token = localStorage.getItem('token');
                this.$emit('cursoDeleted', id);
                axios.delete('http://localhost:8000/api/curso/' + id + '?token=' + token)
                    .then(
                        response => console.log(response)
                    )
                    .catch(
                        error => console.log(error)
                    )
            },
            onCursoDeleted(id){
                const position = this.cursos.findIndex((element) => {
                    return element.id == id;
                });

                this.cursos.splice(position, 1);
            }
        },
        mounted(){
            this.loadCursos();
        }
    }
</script>

