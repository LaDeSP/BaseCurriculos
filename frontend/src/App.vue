<template>

    <div>
      <div v-if="!$route.meta.isHome">
        <NavBar></NavBar>
      </div>

      <router-view></router-view>
       <ModalMenu1></ModalMenu1>
    </div>

</template>


<script>
  import NavBar from './components/NavBar.vue';
  import ModalMenu1 from './components/ModalMenu1';
export default {

    data(){
      return{

      }
    },
    components:{
        NavBar,ModalMenu1

    },
    created(){


    }
}
</script>
