<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 id="centro">Bem Vindo, {{name}}</h1>

                <div class="panel panel-default" id="caixa">
                    <div class="panel-heading" ><center>Painel - Juridica</center></div>
                        <div class="panel-body" >
                            
                                <router-link class="btn btn-secondary btn-lg active btn-block" to="/novo-coordenador">Cadastrar Novo Coordenador</router-link>
                                <router-link class="btn btn-secondary btn-lg active btn-block" to="/novo-supervisor">Cadastrar Novo Supervisor</router-link>
                                <router-link class="btn btn-secondary btn-lg active btn-block" to="/novo-aluno">Cadastrar Novo Aluno</router-link>
        
                         
                        <logs-table></logs-table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import Logs from './Logs.vue';
    import axios from 'axios';

    export default {
        data() {
            return {
                name: this.$session.get('name')
            }
        },
        components: {
            'logs-table': Logs
        },
        mounted() {
           /* const token = localStorage.getItem('token');
            axios.get('http://localhost:8000/api/dashboard?token=' + token)
            .then(response => {
                this.data = response.data.data
            }).catch(error => {

            });  */
        }
    }
</script>
<style>
  #caixa{
    width: 50%;
    height: 470px;
    margin-left: 20%;
  }
  #centro{
      margin-left: 20%;
  }
</style>