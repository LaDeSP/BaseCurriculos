<template>
    <div class="row">
      <div class="panel panel-default" >
          <div class="panel-heading" ><h1>Bem Vindo, {{name}} :)</h1></div>
            <div class="panel-body" >
                <ProfileJuridica></ProfileJuridica>
            </div>
      </div>
    </div>

</template>

<script>
import ProfileJuridica from '../Lists/JuridicaData';
    export default {
        components:{
            ProfileJuridica,
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
</script>
