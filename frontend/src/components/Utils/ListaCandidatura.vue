<template>

    <div class="row">
        <div class="col-md-12">
                <div class="panel panel-default">
                <div class="panel-body">
                     <h3>Candidatos</h3>
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
  export default {
    name: 'lista',
  }
</script>
