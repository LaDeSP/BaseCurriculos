<template>
  <div class="row justify-content-center">
    <div class="panel panel-default" >
      <div class="panel-heading" ><h1>Bem Vindo, {{name}} :)</h1></div>
      <div class="panel-body" >
          <ProfileFisica></ProfileFisica>
      </div>
    </div>
  </div>

</template>

<script>
import ProfileFisica from '../Lists/FisicaData';
    export default {
        components:{
            ProfileFisica,
        },
        data() {

            return {
                name: this.$store.state.auth.user.name
            }
        },
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
