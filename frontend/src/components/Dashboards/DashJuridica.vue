<template>
<span v-if="isFetching">
  <div class="container"></div>
  <div class="container">
    <center><h1>
        Carregando...  <span class="fas fa-spinner fa-pulse"></span>
    </h1></center>
  </div>
</span>
<span v-else>
    <div class="row justify-content-center">
        <div class="col-lg-8">
          <span v-if="isFetching">
            <center><h1>
               Carregando...  <span class="fas fa-spinner fa-pulse"></span>
            </h1></center>
          </span>
          <span v-else>
            <div v-if="!dataCompleted">
              <h1>Complete seus dados para continuar!</h1>
              <NewJuridicaData></NewJuridicaData>
            </div>
            <div v-else-if="!hasVaga">
              <h1>Que tal cadastrar a sua primeira vaga?</h1>
              <NewVaga></NewVaga>
            </div>
            <div v-if="dataCompleted & hasVaga">
              <Dash></Dash>
            </div>
          </span>

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
</span>
</template>

<script>


import NewVaga from '../Create/NewVaga';
import Dash from '../Utils/CardsDashJuridica';
import Modal from '../Utils/ModalOld';
import { BAlert } from 'bootstrap-vue'
import {mapGetters, mapActions, mapState} from 'vuex';

    export default {
         data(){
            return{
              hasVaga: true,
              isModalConfirmaCadastro: false
            }
        },

        methods:{
          ...mapActions(['loadCandidaturas', 'loadJuridica']),
          closeModal(){
              this.isModalConfirmaCadastro = false;
          },
        },

        components:{
             NewJuridicaData: () => import("../Create/NewJuridicaData"),
             NewVaga: () => import("../Create/NewVaga"),
             Dash: () => import("../Utils/CardsDashJuridica"),
             Modal, BAlert
        },
        computed: {

            ...mapState([
                'isFetching', 'dataCompleted'
            ]),
        },

        async created() {
          if(this.dataCompleted == false){
            await this.loadJuridica();
          }else{
                await this.$store.dispatch('loadVagasJuridica')
                .then(response => {
                    let vagas = response.vagas;
                    if(vagas.length === 0){
                    this.hasVaga = false;
                    }
              }).catch(error => {
                //console.log(error)
              })
              await this.loadCandidaturas();
          }
          if (this.$route.params.cadastrou){
            this.isModalConfirmaCadastro = true;
          }
        },

    }
</script>

