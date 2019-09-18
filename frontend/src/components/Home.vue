<template>
<div>
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
  <ModalMenu1></ModalMenu1>
  <ModalLoginFi></ModalLoginFi>
  <ModalLoginJu></ModalLoginJu>
</div>


</template>

<script>

  import NavBarHome from './NavBarHome';
  import ModalMenu1 from './ModalMenu1';
  import ModalLoginFi from './ModalLoginFi';
  import ModalLoginJu from './ModalLoginJu';

  export default {
    data(){
        return {

        }
    },
    components:{
      NavBarHome,ModalMenu1,ModalLoginFi,ModalLoginJu
    }
  }

</script>
