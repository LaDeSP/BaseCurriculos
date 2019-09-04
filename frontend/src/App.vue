<template>
  <div id="app">
    <div class="container ">
        <div class="row">  
          <div class="col-sm-12">
             <nav-bar></nav-bar>
          </div>
        </div>
      
        <div class="row">
          <div class="col-sm-12">
            <router-view></router-view>
          </div>
        </div>
    </div>
  </div>
</template>


<script>
import NavBar from './components/NavBar.vue';
export default {
    data(){
      return{
      
      }
    },
    components:{ 'nav-bar': NavBar},
    created(){
    
      
    }
}
</script>


<style>
  #app{
    margin: 30px;
  }
</style>