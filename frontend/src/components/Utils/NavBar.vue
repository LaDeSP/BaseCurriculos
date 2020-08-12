<template>
  <v-app-bar
    app 
    dark
    absolute
  >
    <router-link to="/"><v-toolbar-title class="pl-1 hidden-sm-and-down">Sistema de Recrutamento e Seleção</v-toolbar-title></router-link>
    <v-spacer></v-spacer>
    <template v-if="auth.isLoggedIn && dataCompleted">
      <v-text-field justify="center" 
        flat 
        solo-inverted 
        hide-details 
        prepend-inner-icon="mdi-magnify"
        label="Pesquisa"
      ></v-text-field>
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
    <template v-if="dataCompleted">
      <v-menu offset-y v-if="auth.isLoggedIn">
        <template v-slot:activator="{ on }">
          <v-btn text slot="activator" v-on="on">
            <h3 class="white--text mr-2 text-capitalize text-truncate" title="auth.user.name">{{auth.user.name}}</h3>
            <v-avatar
              size="50px"
              item
            >
              <v-img 
                :src="getPic"
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
                <v-list-item-title>{{item.title}}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
      </v-menu>
    </template>
    <template v-else-if="!$route.meta.showOnlyIfNoAuth">
      <v-btn large depressed class="white--text" @click="logout">
        Sair
      </v-btn>
    </template>
  </v-app-bar>
</template>

<script>
import Logout from '../Auth/Logout'
import {mapGetters, mapState} from 'vuex'
import FormBuscaAvancada from '../Forms/FormBuscaAvancada'
import {actionTypes} from '../../core/constants'

export default {
  components:{Logout, FormBuscaAvancada},
  data() {
    return {
      avatar: this.$store.state.upload.path,
      menu: [
        { icon: 'mdi-account-circle', title: 'Meu Perfil' },
        { icon: 'mdi-cog', title: 'Configurações' },
        { icon: 'mdi-logout-variant', title: 'Sair' }
      ],
    }
  },
  computed:{
    ...mapState(['auth', 'dataCompleted']),
    getPic(){
      return this.avatar
    }
  },
  methods:{
    async pushToPage(page){
      if(page == 'Meu Perfil'){
        this.$router.push('/profile')
      }else if(page == 'Configurações'){
        this.$router.push('/settings')
      }else if(page == 'Sair'){
        await this.logout()
      }
    },
    async logout(){
      await this.$store.dispatch(actionTypes.LOGOUT)
        .then(response => {
          this.$router.push('/')
        }).catch(error => console.log(error))
    }
  }
}
</script>



