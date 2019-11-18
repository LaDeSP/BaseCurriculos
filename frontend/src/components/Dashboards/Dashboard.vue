<template>
           
    <div v-if="permissaoDoUsuario === 'FISICA'">
        <DashboardFisica></DashboardFisica>
    </div>
    <div v-else>
        <DashboardJuridica></DashboardJuridica>
    </div>
    
</template>

<script>
  
  import DashboardFisica from './DashFisica';
  import DashboardJuridica from './DashJuridica';
  import {mapGetters} from 'vuex';

    export default {

        components:{
            DashboardFisica: () => import("./DashFisica"),
            DashboardJuridica: () => import("./DashJuridica"),
        },

        computed: {
            ...mapGetters([
                'permissaoDoUsuario'
            ]),
        },
    }

</script>


