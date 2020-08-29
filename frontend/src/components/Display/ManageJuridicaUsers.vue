<template>
 <v-row class="fill-height" align="center" justify="center">
    <v-col cols="10" md="12" sm="10" xs="2">
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-card align="center">
        <v-card-title class="text-center justify-center py-6">
          <h2>Gerenciar Usuários Jurídica</h2> 
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Pesquise por um nome"
            single-line 
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-row class="justify-space-between my-5 mr-2 ml-2">
          <v-col cols="12" lg="12" md="12" sm="12">
            <v-data-table
              no-results-text="Não encontramos nenhum resultado."
              no-data-text="Não há nenhum dado."
              :footer-props="{
                itemsPerPageText: footerText,
                itemsPerPageAllText: 'Tudo',
                pageText: 'Páginas',
                showCurrentPage: true
              }"
              :headers="headers"
              :items="juridicaUsers"
              :items-per-page="6"
              item-key="id"
              :search="search"
            >
              <template v-slot:[`item.status`]="{item}">
                <v-chip :color="getColor(item.status)" dark>{{item.status}}</v-chip>
              </template>
              <template v-slot:[`item.acoes`]="{ item }">
                <span>
                  <template v-if="item.status == 'ATIVO'">
                    <v-icon
                      large
                      class="mr-2"
                      @click="handleUserStatus(item, 'deact')"
                    >
                      mdi-toggle-switch-off
                    </v-icon>
                  </template>
                  <template v-else>
                    <v-icon
                      large
                      class="mr-2"
                      @click="handleUserStatus(item, 'act')"
                    >
                      mdi-toggle-switch
                    </v-icon>
                  </template>
                </span>
              </template>
            </v-data-table>
          </v-col>
        </v-row>
      </v-card>
    </v-col>
 </v-row>
</template>

<script>
import {actionTypes} from '@/core/constants'
import {mapState} from 'vuex'

export default {
  data() {
    return {
      search: '',
      headers: [
        {text: 'Nome', align: 'center', value: 'name'},
        {text: 'Email', align: 'center', value: 'email'},
        {text: 'Status', align: 'center', value: 'status'},
        {text: 'Ações', align: 'center', value: 'acoes'}
      ],
      footerText: 'Itens por página'
    }
  },
  async created(){
    await this.$store.dispatch(actionTypes.GET_JURIDICA_USERS)
  },
  computed: {
    ...mapState(['juridicaUsers'])
  },
  methods: {
    getColor(status){
      if(status == 'ATIVO') return 'green'
      else if(status == 'INATIVO') return 'red'
    },
    async handleUserStatus(item, action){
      let payload = {
        userId: item.id, 
        action: action
      }
      await this.$store.dispatch(actionTypes.HANDLE_USER_STATUS, payload)
    }
  }
}
</script>

