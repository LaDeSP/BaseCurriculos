<template>
  <v-tabs 
    v-model="tab"
    background-color="light-blue accent-4"
    centered 
    dark 
    icons-and-text=""
    show-arrows
  >
    <v-tabs-slider></v-tabs-slider>
    <v-tab href="#tab-1">
      Meu Perfil
      <v-icon>mdi-account-circle</v-icon>
    </v-tab>
    <v-tabs-items v-model="tab">
      <v-tab-item
        v-for="i in 2"
        :key="i"
        :value="'tab-' + i"
      >
      <template v-if="tab == 'tab-1'">
        <v-card align="center">
          <v-card-text class="black--text">
            <v-img 
              class="rounded-circle" 
              min-height="250"
              max-height="250"
              width="250"
              min-width="250"
              max-width="250"
              :src="upload.path">
            </v-img>
            <template v-if="modoEdicao">
              <FormPessoaJuridicaData 
                :edicao="modoEdicao"
                @handleNotifSuccess="getNotifSuccess"
              ></FormPessoaJuridicaData>
            </template>
            <template v-else>
                  <h1 class="mb-3 mt-1">{{auth.user.name}}</h1>
                  <v-divider></v-divider>
                  <h2 class="mt-2">Dados da Empresa</h2>
                  <v-row justify="center">
                    <v-list flat width="60%">
                      <v-list-item-group color="primary">
                        <v-list-item>
                          <v-list-item-content>
                            <h3 align="left">CNPJ:</h3>
                              {{pessoaJuridicaInfo.cnpj}}
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                          <v-list-item-content>
                            <h3 align="left">Endereço:</h3>
                            <span align="left" class="mt-1">
                              <strong>CEP: </strong> {{pessoaJuridicaInfo.endereco.cep}} <br/>
                              <strong>Estado: </strong>{{pessoaJuridicaInfo.endereco.estado}} <br/>
                              <strong>Rua: </strong> {{pessoaJuridicaInfo.endereco.rua}} <br/>
                              <strong>Bairro: </strong> {{pessoaJuridicaInfo.endereco.bairro}} <br/>
                              <span v-if="pessoaJuridicaInfo.endereco.numero">
                                <strong>Número: </strong> {{pessoaJuridicaInfo.endereco.numero}} <br/>
                              </span>
                              <span v-if="pessoaJuridicaInfo.endereco.complemento">
                                <strong>Complemento: </strong> {{pessoaJuridicaInfo.endereco.complemento}} <br/>
                              </span>
                            </span>
                          </v-list-item-content>
                          <v-list-item-content>
                            <h3 align="left">Contato:</h3>
                             <span align="left" class="mt-1">
                              <span v-if="pessoaJuridicaInfo.contato.fixo">
                                <strong>Telefone Fixo: </strong> {{pessoaJuridicaInfo.contato.fixo}} <br/>
                              </span>
                              <strong>Telefone Celular: </strong>{{pessoaJuridicaInfo.contato.celular}} <br/>
                              <span v-if="pessoaJuridicaInfo.contato.linkedin">
                                <strong>Linkedin: </strong> {{pessoaJuridicaInfo.contato.linkedin}} <br/>
                              </span>
                              <span v-if="pessoaJuridicaInfo.contato.facebook">
                                <strong>Facebook: </strong> {{pessoaJuridicaInfo.contato.facebook}} <br/>
                              </span>
                              <span v-if="pessoaJuridicaInfo.contato.twitter">
                                <strong>Twitter: </strong> {{pessoaJuridicaInfo.contato.twitter}} <br/>
                              </span>
                              <span v-if="pessoaJuridicaInfo.contato.site">
                                <strong>Site: </strong> {{pessoaJuridicaInfo.contato.site}} <br/>
                              </span>
                            </span>
                          </v-list-item-content>
                        </v-list-item>
                      </v-list-item-group>
                    </v-list>
                  </v-row>
            </template>
          </v-card-text>
          <v-card-actions class="justify-center">
            <template v-if="modoEdicao">
              <v-btn color="default lighten-2 mr-2" @click="modoEdicao = false">
                Ver Perfil
              </v-btn>
            </template>
            <template v-else>
              <v-btn color="warning lighten-2 mr-2" @click="modoEdicao = true">
                Editar Perfil
              </v-btn>
            </template>
            <ModalAlert :payload="avisoModal">
              <slot>
                <h1 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>desativar</strong></span> sua conta?</h1>
                <h2 class="text-center mt-2">Sentiremos sua falta :(</h2>
              </slot>
            </ModalAlert>
          </v-card-actions>
      </v-card>
    </template>
    </v-tab-item>
  </v-tabs-items>
</v-tabs>
</template>

<script>
import FormPessoaJuridicaData from '@/components/Forms/FormPessoaJuridicaData'
import {actionTypes} from '@/core/constants'
import ModalAlert from '@/components/Utils/ModalAlert'
import {mapState} from 'vuex'
import moment from 'moment'
export default {
  components: {FormPessoaJuridicaData, ModalAlert},
  data(){
    return{
      avatar: '',
      nome: '',
      modoEdicao: false,
      isLoaded: false,
      tab: null, 
      avisoModal: {
        title: 'Desativar Conta',
        action: 'desativar conta'
      }
    }
  },
  filters:{
    dateFormat: function(value){
      if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
      }
    }
  },
  computed:{
    ...mapState(['pessoaJuridicaInfo', 'upload', 'auth'])
  },
  methods:{
    getNotifSuccess(value){
      console.log('no profile juridica event', value)
      this.modoEdicao = value
    }
  }
}
</script>

<style lang="stylus" scoped>
  .dados 
    font-size 15px
    white-space: pre-line !important
  h1 
    line-height 31px
</style>