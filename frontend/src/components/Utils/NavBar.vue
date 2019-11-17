<template>

   	<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
      <nav class="navbar ">
        <router-link to="/dashboard" class="navbar-brand">Banco de Currículos</router-link>
      </nav>
      <div class="container">
          <busca></busca>
      </div>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">
        
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
          <router-link to="/dashboard" class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-home fa-lg text-dark"></i>
          </router-link>
        </li>
         
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{name}}</span>
            <img class="img-profile rounded-circle" :src=this.$store.state.upload.path>
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <router-link to="/profile" class="dropdown-item"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Meu Perfil</router-link>
              <a class="dropdown-item" href="#">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                Configurações
              </a>
              <div class="dropdown-divider"></div>
              <Logout></Logout>
          </div>
        </li>
      </ul>

    </nav>

</template>

<script>
import Logout from '../Auth/Logout';
import busca from './BarraBusca';
import {mapGetters} from 'vuex';

    export default {
        components:{
          Logout,busca
        },

        data(){
             
            return{
              name: this.$store.state.auth.user.name,
            }

        },
        
       computed:{
         ...mapGetters([
           'permissaoDoUsuario'
         ]),
       }
    }
</script>
