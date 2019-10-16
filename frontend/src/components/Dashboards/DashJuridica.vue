<template>
    <div class="row justify-content-center"> 
        <div class="col-lg-8">
             <Dash></Dash>
        </div>
      <!-- <div class="panel panel-default" > -->
          <!-- <div class="panel-heading" ><h1>Bem Vindo, {{name}} :)</h1></div> -->
            <!-- <div class="panel-body" > -->
                   <!-- <h4>Você ainda não cadastrou nenhuma vaga. -->
                       <!-- Que tal fazer isso agora? </h4> -->
                    <!-- <NewVaga></NewVaga> -->
                   
             <!-- </div> -->
       <!-- </div> -->
    </div> 

</template>

<script>

import NewJuridicaData from '../Create/NewJuridicaData';
import NewVaga from '../Create/NewVaga';
import Dash from '../Utils/CardsDashJuridica';
import {mapGetters} from 'vuex';

    export default {
        components:{
             NewJuridicaData, NewVaga,Dash
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
          }
        },
    }

     /*
     <template>
    <div class="row">
      <div class="panel panel-default" >
          <div class="panel-heading" ><h1>Bem Vindo, {{name}} :)</h1></div>
            <div class="panel-body" >
               <div v-if="dataCompleted">
                   <h1>Você ainda não cadastrou nenhuma vaga.
                       Que tal fazer isso agora? </h1>
                    <NewVaga></NewVaga>
               </div>
               <div v-else>
                    <NewJuridicaData></NewJuridicaData>
               </div>
               <div v-if="dataCompleted & hasVaga">

               </div>
            </div>
      </div>
    </div>

</template>
*/
</script>

