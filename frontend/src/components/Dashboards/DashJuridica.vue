<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 id="centro">Bem Vindo, {{name}}</h1>

                <div class="panel panel-default" id="caixa">
                    <div class="panel-heading" ><center>Painel - Juridica</center></div>
                        <div class="panel-body" >
                            
                            <router-link class="btn btn-secondary btn-lg active btn-block" to="/profile-juridica">Meu Perfil</router-link>
                            <router-link class="btn btn-secondary btn-lg active btn-block" to="/new-vaga">Cadastrar Nova Vaga</router-link>                
                                
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>

    export default {
        
        data() {

            return {
              name: this.$session.get('name')
            }
        },
        created(){
            console.log('state', this.$store.state.auth);
            console.log('getters', this.$store.getters);
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