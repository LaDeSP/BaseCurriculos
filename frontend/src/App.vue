<template>

    <div>
      <!-- <div v-if="!$route.meta.isSobre">
        <NavBar></NavBar>
      </div> -->

      <router-view></router-view>
       <ModalMenu1></ModalMenu1>
       <ModalMenu2></ModalMenu2>
       <ModalMenu3></ModalMenu3>
    </div>

</template>


<script>
  import NavBar from './components/NavBar.vue';
  import ModalMenu1 from './components/ModalMenu1';
  import ModalMenu2 from './components/ModalMenu2';
  import ModalMenu3 from './components/ModalMenu3';

export default {

    data(){
      return{

      }
    },
    components:{
        NavBar,ModalMenu1,ModalMenu2,ModalMenu3

    },
    created(){


    }
}
</script>
