<template>
<div class="form-group">
    <div class="row">
        <div class="col-lg-6 text-center">
          <i class="far fa-user fa-5x login-icon"></i>
          <button class="btn btn-primary btn-md text-uppercase inferno" @click="showModal('fisica')">Cadastrar como Pessoa Física</button>
          <Modal v-show="isModalCadastroFisica" @close="closeModal">
              <template v-slot:header><h3>Cadastre-se</h3></template>
              <template v-slot:body>
                <CadastroFisica></CadastroFisica>
              </template>
              <template v-slot:footer v-if="$route.meta.isHome" class="d-flex justify-content-center">
                <h6 >Já possui uma conta?</h6>
                <router-link to="/login" class="btn btn-outline-primary btn-lg ">Faça Login</router-link>
            </template>
            </Modal>
        </div>
        <div class="col-lg-6 text-center" >
          <i class="fas fa-building fa-5x login-icon"></i>
          <button class="btn btn-primary btn-md text-uppercase inferno" @click="showModal" >Cadastrar como Pessoa Jurídica</button>
           <Modal v-show="isModalCadastroJuridica" @close="closeModal">
              <template v-slot:header><h3>Cadastre-se</h3></template>
              <template v-slot:body>
                <CadastroJuridica></CadastroJuridica>
              </template>
              <template v-slot:footer v-if="$route.meta.isHome" class="d-flex justify-content-center">
                <h6>Já possui uma conta?</h6>
                <router-link to="/login" class="btn btn-outline-primary btn-lg">Faça Login</router-link>
            </template>
            </Modal>
        </div>
    </div>
</div>
</template>

<script>
  import Login from '../Auth/Login.vue';
  import { mapGetters } from 'vuex'
  import Modal from '../Utils/ModalOld.vue';
  import CadastroFisica from '../Auth/NewFisica.vue';
  import CadastroJuridica from '../Auth/NewJuridica.vue';
  export default {
     components:{
      Modal, Login, CadastroFisica, CadastroJuridica
    },
    data(){
        return {
          isModalLoginFisica: false,
          isModalLoginJuridica: false,
          isModalCadastroFisica: false,
          isModalCadastroJuridica: false
        }
    },
    methods: {
      showModal(modal){
        if(modal === 'fisica'){
           this.isModalCadastroFisica = true;
        }else{
           this.isModalCadastroJuridica = true;
        }
        console.log('showModal', this.isModalLoginFisica)
      },
      showModalCadastro(modal){
        if(modal === 'cadastroFisica'){
           this.isModalCadastroFisica = true;
        }else{
           this.isModalCadastroJuridica = true;
        }
        console.log('showModal', this.isModalLoginFisica)
      },
      closeModal(){
        this.isModalLoginFisica = false;
        this.isModalLoginJuridica = false;
        this.isModalCadastroFisica = false;
        this.isModalCadastroJuridica = false;
      },
    },
  }
</script>
