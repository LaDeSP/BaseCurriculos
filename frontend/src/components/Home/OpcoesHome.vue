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
                <button @click="showModalCadastro('cadastroFisica')" class="btn btn-outline-primary btn-lg btn-block" type="submit">Crie Sua Conta</button>
                <Modal v-show="isModalCadastroFisica" @close="closeModal">
                  <template v-slot:header><h3>Cadastre-se</h3></template>
                  <template v-slot:body>
                    <CadastroFisica></CadastroFisica>
                  </template>
                </Modal>
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
                <button @click="showModalCadastro" class="btn btn-outline-primary btn-lg btn-block" type="submit">Crie Sua Conta</button>
                <Modal v-show="isModalCadastroJuridica" @close="closeModal">
                  <template v-slot:header><h3>Cadastre-se</h3></template>
                  <template v-slot:body>
                    <CadastroJuridica></CadastroJuridica>
                  </template>
                </Modal>
              </div>
            </template>
          </Modal>
        </div>
    </div>
</div>
</template>

<script>
  import Modal from '../Utils/Modal.vue';
  import Login from '../Auth/Login.vue';
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
           this.isModalLoginFisica = true;
        }else{
           this.isModalLoginJuridica = true;
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
      }
    },
  }

</script>
