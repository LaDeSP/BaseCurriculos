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
        <LoadingScreen v-if="isLoading"></LoadingScreen>
        <router-view></router-view>
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
import {mapState} from 'vuex'
  
export default {
  components:{NavBar, Footer, LoadingScreen},
  computed: {
    ...mapState(['isLoading'])
  }
}
</script>

<style lang="stylus">
  .line-height
    line-height 35px
  .same-size-card 
    overflow-y auto
    height 280px
  .aviso 
    font-size 20px
  .container 
    min-height 100vh
  .v-application a
    color inherit !important
    text-decoration none
  .v-btn
    text-transform none
</style>
