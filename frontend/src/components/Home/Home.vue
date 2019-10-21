<template>
<div>
   <header class="masthead">
    <NavBarHome></NavBarHome>
    <div class="container">
      <div class="intro-text">
          <div class="intro-lead-in" >Bem-Vindo ao Banco de Currículos,</div>
          <div class="intro-heading text-uppercase">Prazer em Recebê-lo</div>
          <button @click="showModal" class="btn btn-primary btn-lg text-uppercase ">Faça Parte</button>
          <Modal v-show="isModalFacaParte" @close="closeModal">
            <template v-slot:header><h3>Quem é você?</h3></template>
            <template v-slot:body>
              <OpcoesHome></OpcoesHome>
            </template>
          </Modal>
        </div>
    </div>
  </header>
</div>


</template>

<script>

  import Modal from '../Utils/Modal.vue';
  import NavBarHome from './NavBarHome.vue';
  import OpcoesHome from './OpcoesHome.vue';


  export default {
     components:{
      NavBarHome, Modal, OpcoesHome
    },
    data(){
        return {
          isModalFacaParte: false
        }
    },
    methods: {
      showModal(){
        this.isModalFacaParte = true;
      },
      closeModal(){
        this.isModalFacaParte = false;
      }
    },
  }

</script>
