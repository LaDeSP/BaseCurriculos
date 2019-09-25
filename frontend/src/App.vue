<template>

    <div>
      <div v-if="!$route.meta.isHome & !$route.meta.isSobre">
        <NavBar></NavBar>
      </div>
      <router-view></router-view>
      <Footer></Footer>
    </div>

</template>


<script>
  import NavBar from './components/NavBar.vue';
  import Footer from './components/Footer.vue';

export default {

    data(){
      return{

      }
    },
    components:{
        NavBar,Footer

    },
    created(){


    }
}
</script>
