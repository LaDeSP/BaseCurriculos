<template>
  <v-app-bar
    app 
    dark
    absolute
  >
    <router-link to="/"><v-toolbar-title class="pl-1 hidden-sm-and-down">Sistema de Recrutamento e Seleção</v-toolbar-title></router-link>
    <v-spacer></v-spacer>
    <template>
      <v-text-field justify="center" 
        flat 
        solo-inverted 
        hide-details 
        prepend-inner-icon="mdi-magnify"
        label="Pesquisa"
      ></v-text-field>
      <v-btn depressed class="ml-2">Busca Avançada</v-btn>
    </template>
    <v-spacer></v-spacer>
    <template v-if="this.$route.path == '/login' || this.$route.path == '/sobre'">
        <router-link to="/">
          <v-btn depressed large class="ma-2">Voltar
            <v-icon right>fas fa-home</v-icon>
          </v-btn>
        </router-link>
    </template>
    <template v-if="this.$route.path == '/' || this.$route.path == '/sobre'">
      <router-link to="/login">
        <v-btn depressed large class="ma-2">Entrar
          <v-icon right>fa-sign-in-alt</v-icon>
        </v-btn>
      </router-link>
    </template>
    <template v-if="this.$route.path == '/' || this.$route.path == '/login'">
      <router-link to="/sobre">
        <v-btn depressed large class="ma-">Sobre
          <v-icon right>far fa-lightbulb</v-icon>
        </v-btn>
      </router-link>
    </template>
    <v-menu offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon large text slot="activator" v-on="on">
          <v-avatar
            size="32px"
            item
          >
            <v-img 
              src="https://cdn.vuetifyjs.com/images/logos/logo.svg"
              alt="Vuetify"
            ></v-img>
          </v-avatar>
        </v-btn>
        </template>
        <v-list>
         <v-list-item v-for="(item, index) in menu" :key="index" @click="pushToPage(item.title)">
            <v-list-item-action>
              <v-icon>{{item.icon}}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <route-link to="/profile"><v-list-item-title>{{item.title}}</v-list-item-title></route-link>
            </v-list-item-content>
          </v-list-item>
        </v-list>
    </v-menu>
  </v-app-bar>
</template>

<script>
import Logout from '../Auth/Logout'
import busca from './BarraBusca'
import {mapGetters} from 'vuex'

export default {
  components:{
    Logout, busca
  },

  data() {
    return {
      menu: [
        { icon: 'mdi-account-circle', title: 'Meu Perfil' },
        { icon: 'mdi-cog', title: 'Configurações' },
        { icon: 'mdi-logout-variant', title: 'Sair' }
      ],
    }
  },
  created(){
    console.log('this rute', this.$route)
  },
  computed:{
    ...mapGetters([
      'permissaoDoUsuario', 'isLoggedIn'
    ])
  },
  methods:{
    pushToPage(page){
      if(page == 'Meu Perfil'){
        this.$router.push('/profile')
      }else if(page == 'Configurações'){
        this.$router.push('/settings')
      }else if(page == 'Sair'){
        console.log('logout')
      }
    }
  }
}
</script>



