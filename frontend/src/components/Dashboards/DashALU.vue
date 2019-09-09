<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 id="centro">Dashboard</h1>

                <div class="panel panel-default" id="caixa5">
                    <div class="panel-heading"><center>Painel - Aluno</center></div>
                    <div class="panel-body">
                        <router-link class="btn btn-secondary btn-lg active btn-block" to="/vagas">Ver Vagas de Estágio</router-link>
                        <router-link class="btn btn-secondary btn-lg active btn-block" to="/solicitacao">Ver Solicitações Feitas</router-link>
                        
                        
                    </div>
                    <aluno></aluno>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Aluno from './ID-Aluno.vue';
    export default {
        data() {
            return {
               aluno_id: null
            }
        },
        components: {'aluno': Aluno},
        created(){
         
        }
    }
</script>
<style>
  #caixa1{
    width: 50%;
    height: 470px;
    margin-left: 20%;
  }
  </style>