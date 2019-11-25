<template>
           
    <div v-if="permissaoDoUsuario === 'FISICA'">
        <DashboardFisica></DashboardFisica>
        <Modal v-if="isModalConfirmaCompleted" @close="closeModal">
            <template v-slot:header></template>
            <template v-slot:body>
                 <b-alert show variant="success">
                    <h1>Currículo criado com sucesso!</h1>
                </b-alert>
            </template>
        </Modal>
    </div>
    <div v-else>
        <DashboardJuridica></DashboardJuridica>
        <Modal v-if="isModalConfirmaCompleted" @close="closeModal">
            <template v-slot:header></template>
            <template v-slot:body>
                 <b-alert show variant="success">
                    <h1>Cadastro completado com sucesso!</h1>
                </b-alert>
            </template>
        </Modal>
    </div>
    
</template>

<script>
  
  import DashboardFisica from './DashFisica';
  import DashboardJuridica from './DashJuridica';
  import {mapGetters} from 'vuex';
  import Modal from '../Utils/ModalOld';
  import { BAlert } from 'bootstrap-vue'

    export default {
        data() {
            return {
                isModalConfirmaCompleted: false,
            }
        },

        components:{
            DashboardFisica: () => import("./DashFisica"),
            DashboardJuridica: () => import("./DashJuridica"),
            Modal, BAlert
        },

        methods: {
            closeModal(){
                this.isModalConfirmaCompleted = false;
            },
        },

        computed: {
            ...mapGetters([
                'permissaoDoUsuario'
            ]),
        },

        async created(){
            if (this.$route.params.criou){
                this.isModalConfirmaCompleted = true;
            } 
        }
    }

</script>


