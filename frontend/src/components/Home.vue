<template>

   <header class="masthead">
      <NavBarHome></NavBarHome>
    <div class="container">
      <div class="intro-text">
        <div class="intro-lead-in" >Bem-Vindo ao Banco de Currículos,</div>
        <div class="intro-heading text-uppercase">Prazer em Recebê-lo</div>
        <a class="btn btn-primary btn-lg text-uppercase " href="#services"  data-toggle="modal" data-target="#tunder">Faça Parte</a>
      </div>
    </div>
  </header>



</template>

<script>

  import NavBarHome from './NavBarHome';
  export default {
    data(){
        return {

        }
    },
    components:{
      NavBarHome
    }
  }

</script>
