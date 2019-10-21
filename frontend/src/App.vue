<template>

    <div>
      <div v-if="!$route.meta.isHome" >
        <NavBar></NavBar>
        <div class="container-fluid" >
          <router-view></router-view>
        </div>
      </div>
      <div v-else>
        <router-view></router-view>
      </div>
      <Footer ></Footer>
    </div>

</template>


<script>
  import NavBar from './components/Utils/NavBar.vue';
  import Footer from './components/Utils/Footer.vue';

export default {

    data(){
      return{

      }
    },
    components:{
        NavBar, Footer

    },
    created(){


    }
}
</script>

<style lang="stylus">
  .container
    padding 10% !important;
    align-content center;

</style>
