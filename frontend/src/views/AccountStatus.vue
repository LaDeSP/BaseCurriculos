<template>
  <v-row align="center" justify="center">
    <v-col cols="12" lg="10" md="10" sm="8">
      <v-card align="center">
        <v-card-title class="red darken-4 white--text text-center justify-center">
          <h3>Conta Desativada</h3> 
        </v-card-title>
        <v-card-text class="my-5">
          <v-icon color="red darken-4" style="font-size: 100px">mdi-alert-octagon</v-icon>
          <template v-if="tipoPermissao == 'JURIDICA' && auth.user.status == 'INATIVO'">
            <h2>
            Sua conta se encontra desativada no momento. <br/>
            Para reativá-la, contate a Associação Comercial por meio de telefone ou email: <br/>
            </h2>
            <h3 class="aviso mt-4">
              Email: kdojdao@hotmail.com <br/>
              Contato: 20802840
            </h3>
          </template>
          <template v-else>
            <h2>
              Sua conta se encontra desativada no momento. <br/>
              Deseja reativá-la?
            </h2>
          </template>
        </v-card-text>
        <v-card-actions class="text-center justify-center">
          <v-btn large color="success" v-if="auth.user.status == 'ATIVO'" @click="activate">
            Reativar Conta
          </v-btn>
          <v-btn large dark color="grey" class="ml-1" @click="logout">
            Sair
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import {actionTypes} from '@/core/constants'
import {mapState, mapGetters} from 'vuex'
export default {
  computed: {
    ...mapState(['auth']),
    ...mapGetters(['tipoPermissao'])
  },
  methods: {
    async activate(){
      await this.$store.dispatch(actionTypes.REATIVAR_CONTA)
      this.$router.push('/dashboard')
    },
    async logout(){ 
      await this.$store.dispatch(actionTypes.LOGOUT)
      this.$router.push('/')
    }
  }
}
</script>