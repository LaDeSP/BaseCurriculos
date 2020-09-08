<template>
  <v-app-bar
    app 
    dark
    absolute
  >
    <router-link to="/"><v-toolbar-title class="pl-1 hidden-sm-and-down">Sistema de Recrutamento e Seleção</v-toolbar-title></router-link>
    <v-spacer></v-spacer>
    <template v-if="auth.isLoggedIn && auth.dataCompleted">
      <template v-if="$route.path != '/error' && $route.path != '/error/'
        && $route.path != '/accountStatus' && $route.path != '/accountStatus/'
      ">
        <template v-if="auth.user.role == 'FISICA' || (auth.user.role == 'JURIDICA' && auth.hasVaga)">
          <v-text-field justify="center" 
            flat 
            v-model="keywords"
            solo-inverted 
            hide-details 
            :label="searchLabel"
          ></v-text-field>
          <v-btn fab depressed class="ml-1" @click="redirectSimpleSearch">
            <v-icon>
              mdi-magnify
            </v-icon>
          </v-btn>
          <FormBuscaAvancada></FormBuscaAvancada>
        </template>
      </template>
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
    <template v-if="auth.dataCompleted && auth.isLoggedIn">
      <template v-if="$route.path != '/error' && $route.path != '/error/'
        && $route.path != '/accountStatus' && $route.path != '/accountStatus/'
      ">
        <v-menu offset-y>
          <template v-slot:activator="{ on }">
            <v-btn text slot="activator" v-on="on">
              <h3 class="white--text mr-2 text-capitalize text-truncate hidden-sm-and-down" title="auth.user.name">{{auth.user.name}}</h3>
              <v-avatar
                size="50px"
                item
              >
                <v-img 
                  :src="upload.path"
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
    </template>
    <template v-else-if="!$route.meta.showOnlyIfNoAuth && auth.isLoggedIn">
      <template v-if="$route.path != '/accountStatus' && $route.path != '/accountStatus/'">
        <v-btn large depressed class="white--text" @click="logout">
          Sair
        </v-btn>
      </template>
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
      avatar: '',
      searchLabel: '',
      keywords: '',
      menu: [
        { icon: 'mdi-account-circle', title: 'Meu Perfil' },
        { icon: 'mdi-cog', title: 'Configurações' },
        { icon: 'mdi-logout-variant', title: 'Sair' }
      ],
    }
  },
  created(){
    if(this.auth.isLoggedIn){
      if(this.tipoPermissao == 'FISICA'){
        this.searchLabel = 'Busque título ou especificações da vaga'
      }else if(this.tipoPermissao == 'JURIDICA'){
        this.searchLabel = 'Busque qualificações'
      }
    }
  },
  computed:{
    ...mapState(['auth', 'upload']),
    ...mapGetters(['tipoPermissao'])
  },
  methods:{
    async redirectSimpleSearch(){
      if(this.keywords == '' || this.keywords == undefined){
        return
      }
      console.log('this router navbar.', this.$router)
      if(this.$router.currentRoute.name == 'search'){
        if(this.tipoPermissao == 'FISICA'){
          await this.$store.dispatch(actionTypes.GET_BUSCA_VAGAS, this.keywords)
        }else if(this.tipoPermissao == 'JURIDICA'){
          await this.$store.dispatch(actionTypes.GET_BUSCA_CURRICULOS, this.keywords)
        }
      }else{
        this.$router.push({name: 'search', query: {keywords: this.keywords}})
      }
    },
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



