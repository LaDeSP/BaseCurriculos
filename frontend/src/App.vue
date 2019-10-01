<template>

    <div>
      <div v-if="!$route.meta.isHome & !$route.meta.isSobre">
        <NavBar></NavBar>
        <div class="container">
          <router-view></router-view>
        </div>
      </div>
      <div v-else>
        <router-view></router-view>
      </div>
      <Footer></Footer>
    </div>

</template>


<script>
  import NavBar from './components/NavBar.vue';
  import Footer from './components/Footer.vue';
  import Home from './components/Home.vue';

export default {

    data(){
      return{

      }
    },
    components:{
        NavBar, Footer, Home

    },
    created(){


    }
}
</script>
