<template>
    <div class="row justify-content-center">
        <div class="col-lg-8">
          <div v-if="!dataCompleted">
            <h1>Complete seus dados para continuar!</h1>
             <NewCurriculo></NewCurriculo>
          </div>
          <div v-else>
            <dashfisica></dashfisica>
          </div>
        </div>
        <Modal v-if="isModalConfirmaCadastro" @close="closeModal">
            <template v-slot:header></template>
            <template v-slot:body>
                 <b-alert show variant="success">
                    <h1>Cadastro realizado com sucesso!</h1>
                </b-alert>
            </template>
        </Modal>
    </div>

</template>

<script>
  import ProfileFisica from '../Lists/FisicaData';
  import NewCurriculo from  '../Create/NewCurriculo';
  import dashfisica from '../Utils/CardsDashFisica'
  import Modal from '../Utils/ModalOld';
  import { BAlert } from 'bootstrap-vue'
  import {mapGetters} from 'vuex';

    export default {
        components:{
            ProfileFisica, NewCurriculo,dashfisica, Modal, BAlert
        },
        data() {

            return {
                name: this.$store.state.auth.user.name,
                isModalConfirmaCadastro: false,
            }
        },
        computed: {
          ...mapGetters([
            'dataCompleted'
        ]),
      },
      methods: {
          closeModal(){
              this.isModalConfirmaCadastro = false;
          },
        },
        async created() {
          if(!this.dataCompleted){
            await this.$store.dispatch('loadFisica')
                  .then(response => {
                
                  }).catch(error => {
                    //console.log(error)
                  })  
          }
          if (this.$route.params.cadastrou){
            this.isModalConfirmaCadastro = true;
          }

      },
    }

</script>


