<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 id="centro2">Dashboard</h1>

                <div class="panel panel-default" id="caixa3">
                    <div class="panel-heading"><center>Painel - Supervisor</center></div>
                    <div class="panel-body">
                        <router-link to="/" class="btn btn-secondary btn-lg active btn-block" >Verificar Alunos</router-link>
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
                data: 'nothing'
            }
        }
    }
</script>
<style>
  #caixa3{
    width: 40%;
    height: 100px;
    margin-left: 20%;
  }
 #centro2{
     margin-left: 20%;
 }
  </style>