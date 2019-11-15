<template>
    <div class="row justify-content-center">
        <div class="col-lg-8">
          <div v-if="!dataCompleted">
            <h1>Complete seus dados para podermos continuar!</h1>
             <NewCurriculo></NewCurriculo>
          </div>
          <div v-else>
            <dashfisica></dashfisica>
          </div>
        </div>
    </div>

</template>

<script>
  import ProfileFisica from '../Lists/FisicaData';
  import NewCurriculo from  '../Create/NewCurriculo';
  import dashfisica from '../Utils/CardsDashFisica'
  import {mapGetters} from 'vuex';

    export default {
        components:{
            ProfileFisica, NewCurriculo,dashfisica
        },
        data() {

            return {
                name: this.$store.state.auth.user.name
            }
        },
        computed: {
          ...mapGetters([
            'dataCompleted'
        ]),
      },
        async created() {
          if(!this.dataCompleted){
            await this.$store.dispatch('loadFisica')
                  .then(response => {
                    console.log('dataCompleted', this.dataCompleted)
                  }).catch(error => {
                    //console.log(error)
                  })  
          }
      },
    }

</script>


