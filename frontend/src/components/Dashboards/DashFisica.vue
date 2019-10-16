<template>
  <div class="row justify-content-center">
    <div class="panel panel-default" >
      <div class="panel-heading" ><h1>Bem Vindo, {{name}} :)</h1></div>
      <div class="panel-body" >
         
      </div>
    </div>
  </div>

</template>

<script>
import ProfileFisica from '../Lists/FisicaData';
import {mapActions, mapGetters} from 'vuex';
    export default {
        components:{
            ProfileFisica,
        },
        data() {

            return {
                name: this.$store.state.auth.user.name
            }
        },
        methods: {
          /*...mapActions([
                'loadFisica'
            ]), */
        },
        computed: {
          ...mapGetters([
            'dataCompleted'
        ]),
        dataCompleted: {
            get(){ 
                return this.$store.getters.dataCompleted;
            }
        }
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


