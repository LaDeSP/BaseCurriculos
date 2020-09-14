<template>
<v-app>
  <NavBar></NavBar>
  <template v-if="$route.meta.isHome || $route.meta.isSobre || $route.meta.isLogin">
    <LoadingScreen v-if="isLoading"></LoadingScreen>
    <router-view></router-view>
  </template>
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
import NavBar from '@/components/Utils/NavBar.vue'
import Footer from '@/components/Utils/Footer.vue'
import LoadingScreen from '@/views/LoadingScreen'
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
  .pagination 
    display --webkit-box 
    display -ms-flexbox 
    display flex
    padding-left 0 
    list-style none 
    border-radius 0.35rem 
  .page-link 
    position relative 
    display block 
    padding 0.5rem 0.75rem 
    margin-left -1px 
    line-height 1.25 
    color #4e73df 
    background-color #fff 
    border 1px solid #dddfeb 
  .page-link:hover 
    z-index: 2 
    color #224abe 
    text-decoration none 
    background-color #eaecf4 
    border-color #dddfeb 
  .page-item.active .page-link 
    z-index 1
    color #fff 
    background-color #1976D2
    border-color: #4e73df 
  .pagination li.first 
    display none !important 
  .pagination li.last 
    display none !important
</style>

