<template>
           
    <div v-if="permissaoDoUsuario === 'FISICA'">
        <FisicaData></FisicaData>
    </div>
    <div v-else>
        <JuridicaData></JuridicaData>
    </div>
    
</template>

<script>
  
  import FisicaData from './FisicaData';
  import JuridicaData from './JuridicaData';
  import {mapGetters} from 'vuex';

    export default {

        components:{
            FisicaData, JuridicaData
        },

        computed: {
            ...mapGetters([
                'permissaoDoUsuario'
            ]),
        },
    }

</script>


