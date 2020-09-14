<template>
  <b-navbar class="margin-bottom" toggleable="lg" type="dark" variant="dark">
    <b-navbar-brand v-if="!$route.meta.isDesativada"><router-link to="/dashboard" class="navbar-brand">Banco de Currículos</router-link></b-navbar-brand>
    <b-navbar-brand v-else>Banco de Currículos</b-navbar-brand>
    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
    <b-collapse id="nav-collapse" is-nav v-if="isLoggedIn">
      <busca v-if="this.$store.state.dataCompleted!=false" class="ml-auto"></busca>
      <b-navbar-nav class="ml-auto">
        <b-navbar-nav v-if="!$route.meta.isDesativada">
          <!--<b-nav-item><router-link to="/dashboard"><i class="fas fa-home fa-lg color-white"></i></router-link></b-nav-item>-->
          <b-nav-item-dropdown right>
            <template v-slot:button-content>
              <!--<img class="fotinha rounded-circle" :src=this.$store.state.upload.path>-->
              <em>{{name}}</em>
            </template>
            <b-dropdown-item><router-link to="/profile" class="dropdown-item"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Meu Perfil</router-link></b-dropdown-item>
            <b-dropdown-item><router-link to="/config" class="dropdown-item"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>Configurações</router-link></b-dropdown-item>
            <b-dropdown-item><Logout></Logout></b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-navbar-nav>
    </b-collapse>
    <b-collapse id="nav-collapse" is-nav v-else>
      <b-navbar-nav class="ml-auto" v-if="this.$router.currentRoute.name == 'home'">
        <b-nav-item><router-link class="navbar-brand" to="/login"><i class="fas fa-sign-in-alt"></i> Entrar</router-link></b-nav-item>
        <b-nav-item><router-link class="navbar-brand" to="/sobre"><i class="far fa-lightbulb"></i> Sobre</router-link></b-nav-item>
      </b-navbar-nav>
      <b-navbar-nav class="ml-auto" v-if="this.$router.currentRoute.name == 'login'">
        <b-nav-item><router-link class="navbar-brand" to="/"><i class="fas fa-home"></i> Voltar</router-link></b-nav-item>
        <b-nav-item><router-link class="navbar-brand" to="/sobre"><i class="far fa-lightbulb"></i> Sobre</router-link></b-nav-item>
      </b-navbar-nav>
      <b-navbar-nav class="ml-auto" v-if="this.$router.currentRoute.name == 'sobre'">
        <b-nav-item><router-link class="navbar-brand" to="/"><i class="fas fa-home"></i> Voltar</router-link></b-nav-item>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
import Logout from '../Auth/Logout';
import busca from './BarraBusca';
import {mapGetters} from 'vuex';
import { BNavbar, BNavbarNav, BNavbarBrand, BNavbarToggle, BDropdown, BCollapse, BDropdownItem, BNavItem, BNavItemDropdown } from 'bootstrap-vue'

    export default {
        components:{
          Logout,busca, BNavbar, BNavbarNav, BNavbarBrand, BNavbarToggle, BDropdown, BCollapse, BDropdownItem, BNavItem , BNavItemDropdown
        },

        data(){
             
            return{
              name: this.$store.state.auth.user.name,
            }

        },
        
       computed:{
         ...mapGetters([
           'permissaoDoUsuario', 'isLoggedIn'
         ]),
       }
    }
</script>

