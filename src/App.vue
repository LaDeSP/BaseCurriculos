<template>
<v-app>
  <NavBar></NavBar>
  <div v-if="$route.meta.isHome || $route.meta.isSobre || $route.meta.isLogin">
    <router-view></router-view>
    <LoadingScreen v-if="isLoading"></LoadingScreen>     
  </div>
  <div v-else>
    <v-main>
      <v-container class="fill-height">
        <router-view></router-view>
        <LoadingScreen v-if="isLoading"></LoadingScreen>
      </v-container>
    </v-main>
  </div>
  <Footer></Footer>
</v-app>
</template>


<script>
  import NavBar from './components/Utils/NavBar.vue'
  import Footer from './components/Utils/Footer.vue'
  import LoadingScreen from './views/LoadingScreen'
  
export default {

    data(){
      return{

      }
    },
    components:{
        NavBar, Footer, LoadingScreen

    },
    created(){  
      console.log('no app', this.$route)
    }
}
</script>

<style lang="stylus">
  .container 
    min-height 100vh
  .v-application a
    color inherit !important
    text-decoration none
  
  .v-btn
    text-transform none
    
</style>
