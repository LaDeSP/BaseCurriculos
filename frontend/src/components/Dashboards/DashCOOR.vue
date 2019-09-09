<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 id="centro1">Dashboard</h1>
                <div class="panel panel-default" id="caixa2">
                    <div class="panel-heading"><center>Painel - Coordenador</center></div>
                    <div class="panel-body con">
                        <h2><center>Cadastros</center></h2>
                            <router-link class="btn btn-secondary btn-lg active btn-block" to="/novo-aluno">Cadastrar Novo Usuário</router-link>
                            <router-link class="btn btn-secondary btn-lg active btn-block" to="/nova-empresa">Cadastrar Nova Empresa</router-link>
                            <router-link class="btn btn-secondary btn-lg active btn-block" to="/novo-supervisor">Cadastrar Novo Supervisor</router-link>
                        <div>
                            <h2><center>Gerenciamento</center></h2>
                            <router-link class="btn btn-secondary btn-lg active btn-block" to="/solicitacoes">Solicitações de Estágio</router-link>
                        </div>
                        
              
                      
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
               
            }
        },
        mounted() {
           
        }
    }
</script>
<style>
  #caixa2{
    width: 40%;
    height: 400px;
    margin-left: 20%;
  }
 #centro1{
     margin-left: 20%;
 }
  </style>
