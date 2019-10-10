<template>
    <div class="row">
      <div class="panel panel-default" >
          <div class="panel-heading" ><h1>Bem Vindo, {{name}} :)</h1></div>
            <div class="panel-body" >
                   <h4>Você ainda não cadastrou nenhuma vaga.
                       Que tal fazer isso agora? </h4>
                    <NewVaga></NewVaga>
            </div>
      </div>
    </div>

</template>

<script>

import NewJuridicaData from '../Create/NewJuridicaData';
import NewVaga from '../Create/NewVaga';

    export default {
        components:{
             NewJuridicaData, NewVaga
        },
        data() {

            return {
              name: this.$store.state.auth.user.name
            }
        },
        created(){
            console.log('state', this.$store.state.auth);
            console.log('getters', this.$store.getters);
        }
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

