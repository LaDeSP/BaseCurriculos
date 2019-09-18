<template>

    <div>
      <!-- <div v-if="!$route.meta.isSobre">
        <NavBar></NavBar>
      </div> -->
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
        NavBar

    },
    created(){


    }
}
</script>
