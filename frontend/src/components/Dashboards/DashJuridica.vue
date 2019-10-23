<template>
    <div class="row justify-content-center"> 
        <div class="col-lg-8">
          <div v-if="!dataCompleted">
            <h1>Complete seus dados para podermos continuar!</h1>
             <NewJuridicaData></NewJuridicaData>
          </div>
          <div v-else-if="!hasVaga">
            <h1>Você ainda não cadastrou nenhuma vaga.
                Que tal fazer isso agora? </h1>
            <NewVaga></NewVaga>
          </div>
          <div v-if="dataCompleted & hasVaga">
            <Dash></Dash>
          </div>
        </div>
    </div> 

</template>

<script>

import NewJuridicaData from '../Create/NewJuridicaData';
import NewVaga from '../Create/NewVaga';
import Dash from '../Utils/CardsDashJuridica';
import {mapGetters} from 'vuex';

    export default {
         data(){
            return{
              hasVaga: true,
            }
        },
        components:{
             NewJuridicaData, NewVaga, Dash
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
                    console.log('hasvaga', this.hasVaga)
                  }).catch(error => {
                    //console.log(error)
                  })
          }
          console.log('oi', this.hasVaga)
        },
    }
</script>

