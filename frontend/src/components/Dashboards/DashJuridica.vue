<template>
    <div class="row justify-content-center"> 
        <div class="col-lg-8">
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

import NewJuridicaData from '../Create/NewJuridicaData';
import NewVaga from '../Create/NewVaga';
import Dash from '../Utils/CardsDashJuridica';
import Modal from '../Utils/ModalOld';
import { BAlert } from 'bootstrap-vue'
import {mapGetters, mapActions} from 'vuex';

    export default {
         data(){
            return{
              hasVaga: true,
              isModalConfirmaCadastro: false
            }
        },
        
        methods:{
          ...mapActions(['loadCandidaturas']),
          closeModal(){
              this.isModalConfirmaCadastro = false;
          },
        },
        
        components:{
             NewJuridicaData, NewVaga, Dash, Modal, BAlert
        },
        computed: {
            ...mapGetters([
                'dataCompleted'
            ]),
        },
        async created() {
          if(!this.dataCompleted){
            await this.$store.dispatch('loadJuridica')
                  .then(response => {
                    console.log('dataCompleted', this.dataCompleted)
                  }).catch(error => {
                    //console.log(error)
                  })
          }else{
            await this.$store.dispatch('loadVagasJuridica')
              .then(response => {
                let vagas = response.vagas; 
                if(vagas.length === 0){
                  this.hasVaga = false;
                }
                //console.log('hasvaga', this.hasVaga)
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

