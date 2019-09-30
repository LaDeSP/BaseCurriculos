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
  import NavBar from './components/Utils/NavBar.vue';
  import Footer from './components/Utils/Footer.vue';

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
