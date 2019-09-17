<template>

    <div>
      <div v-if="!$route.meta.isHome">
        <nav-bar></nav-bar>
      </div>

      <router-view></router-view>

    </div>

</template>


<script>
 import NavBar from './components/NavBar.vue';

export default {

    data(){
      return{

      }
    },
    components:{
        'nav-bar': NavBar

    },
    created(){


    }
}
</script>
