<template>
<div class="form-group">
    <div class="row">
        <div class="col-lg-6 text-center">
          <i class="far fa-user fa-5x login-icon"></i>
          <button class="btn btn-primary btn-md text-uppercase inferno" @click="showModal('fisica')">Pessoa Física</button>

          <Modal v-show="isModalLoginFisica" @close="closeModal">
            <template v-slot:header><h3>Pessoa Física </h3></template>
            <template v-slot:body>
              <Login></Login>
            </template>
            <template v-slot:footer>
              <div class="modal-footer">
                <p>Não tem uma conta ainda?</p>
                <button class="btn btn-outline-primary btn-lg btn-block" type="submit">Crie Sua Conta</button>
              </div>
            </template>
          </Modal>
        </div>
        <div class="col-lg-6 text-center" >
          <i class="fas fa-building fa-5x login-icon"></i>
          <button class="btn btn-primary btn-md text-uppercase inferno" @click="showModal" >Pessoa Jurídica</button>

          <Modal v-show="isModalLoginJuridica" @close="closeModal">
            <template v-slot:header><h3>Pessoa Jurídica</h3></template>
            <template v-slot:body>
              <Login>
                <template v-slot:icone>
                   <i class="fas fa-building fa-5x login-icon"></i>
                </template>
              </Login>
            </template>
            <template v-slot:footer>
              <div class="modal-footer">
                <p>Não tem uma conta ainda?</p>
                <button class="btn btn-outline-primary btn-lg  btn-block " type="submit" value=" Crie sua Conta" ></button>
              </div>
            </template>
          </Modal>
        </div>
    </div>
</div>
</template>

<script>
  import Modal from './Modal';
  import Login from './Login.vue';

  export default {
     components:{
      Modal, Login
    },
    data(){
        return {
          isModalLoginFisica: false,
          isModalLoginJuridica: false
        }
    },
    methods: {
      showModal(modal){
        if(modal === 'fisica'){
           this.isModalLoginFisica = true;
        }else{
           this.isModalLoginJuridica = true;
        }
        console.log('showModal', this.isModalLoginFisica)
      },
      closeModal(){
        this.isModalLoginFisica = false;
        this.isModalLoginJuridica = false;
      }
    },
    created(){
      console.log('created', this.isModalLogin)
    }
  }

</script>
