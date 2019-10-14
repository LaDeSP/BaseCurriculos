<template>
<div class="form-group">
    <div class="row">
        <div class="col-lg-6 text-center">
          <i class="far fa-user fa-5x login-icon"></i>
          <button class="btn btn-primary btn-md text-uppercase inferno" @click="showModal('fisica')">Cadastre-se como Pessoa Física</button>
        </div>
        <div class="col-lg-6 text-center" >
          <i class="fas fa-building fa-5x login-icon"></i>
          <button class="btn btn-primary btn-md text-uppercase inferno" @click="showModal('juridica')" >Cadastre-se como Pessoa Jurídica</button>
        </div>
    </div>
</div>
</template>

<script>
  import Modal from '../Utils/Modal.vue';
  import { mapGetters } from 'vuex'
  export default {
     components:{
      Modal
    },
    data(){
        return {
          isModalCadastroFisica: false,
          isModalCadastroJuridica: false
        }
    },
    computed:{
      ...mapGetters(['isLoggedIn'])
    },
    methods: {
      showModal(modal){
        console.log('entrou')
        if(modal === 'fisica'){
          this.$router.push({ name: 'cadastro-fisica' })
        }else{
          this.$router.push({ name: 'cadastro-juridica' })
        }
      },
      closeModal(){
        this.isModalCadastroFisica = false;
        this.isModalCadastroJuridica = false;
      },
      redirecionarUsuarioParaDash(){
        if(this.isLoggedIn && this.isModalLoginFisica === true){
          window.location.href = "http://localhost:8080/dashboard-fisica"
        } else if(this.isLoggedIn && this.isModalLoginJuridica === true){
          window.location.href = "http://localhost:8080/dashboard-juridica"
        } else {alert('erro')}
      }
    },
  }

</script>
