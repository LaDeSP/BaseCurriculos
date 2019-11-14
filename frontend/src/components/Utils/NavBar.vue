<template>

   	<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
      <nav class="navbar ">
        <span class="navbar-brand">Banco de Currículos</span>
      </nav>
      <div class="container">
          <busca></busca>
      </div>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{name}}</span>
            <img class="img-profile rounded-circle" :src=this.$store.state.upload.path>
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <router-link to="/profile-fisica" class="dropdown-item"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Meu Perfil - Fisica</router-link>
              <router-link to="/profile-juridica" class="dropdown-item"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Meu Perfil - Juridica</router-link>

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

    export default {
        components:{
          Logout,busca
        },
        data(){
              console.log(this.$store.state.upload.path);

            return{
              name: this.$store.state.auth.user.name,
            }

        },
    }
</script>
