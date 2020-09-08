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
    <v-tab href="#tab-2">
      Currículo 
      <v-icon>fas fa-file-alt</v-icon>
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
            <v-img class="rounded-circle"  
              min-height="250"
              max-height="250" 
              width="250"
              min-width="250"
              max-width="250"
              :src="upload.path">
            </v-img>
            <template v-if="modoEdicao">
              <FormPessoaFisicaCurriculo :edicao="modoEdicao"></FormPessoaFisicaCurriculo>
            </template>
            <template v-else>
                  <h1 class="mb-3">{{nome}}</h1>
                  <v-divider></v-divider>
                  <h2 class="mt-2">Dados Pessoais</h2>
                  <v-row justify="center">
                    <v-list flat width="60%">
                      <v-list-item-group color="primary">
                        <v-list-item >
                          <v-list-item-content>
                            <h3 align="left">Data de Nascimento</h3>
                              {{pessoaFisicaInfo.data_nascimento | dateFormat}}
                          </v-list-item-content>
                          <v-list-item-content>
                            <h3 align="left">Gênero</h3>
                            {{pessoaFisicaInfo.genero}}
                          </v-list-item-content> 
                        </v-list-item>
                        <v-list-item>
                          <v-list-item-content>
                            <h3 align="left">Estado Civil</h3>
                              {{pessoaFisicaInfo.estado_civil}}
                          </v-list-item-content>
                          <v-list-item-content>
                            <h3 align="left">País de Nacionalidade</h3>
                              {{pessoaFisicaInfo.endereco.pais}}
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                          <v-list-item-content>
                            <h3 align="left">Endereço:</h3>
                            <span align="left" class="mt-1">
                              <strong>CEP: </strong> {{pessoaFisicaInfo.endereco.cep}} <br/>
                              <strong>Estado: </strong>{{pessoaFisicaInfo.endereco.estado}} <br/>
                              <strong>Rua: </strong> {{pessoaFisicaInfo.endereco.rua}} <br/>
                              <strong>Bairro: </strong> {{pessoaFisicaInfo.endereco.bairro}} <br/>
                              <span v-if="pessoaFisicaInfo.endereco.numero">
                                <strong>Número: </strong> {{pessoaFisicaInfo.endereco.numero}} <br/>
                              </span>
                              <span v-if="pessoaFisicaInfo.endereco.complemento">
                                <strong>Complemento: </strong> {{pessoaFisicaInfo.endereco.complemento}} <br/>
                              </span>
                            </span>
                          </v-list-item-content>
                          <v-list-item-content>
                            <h3 align="left">Contato:</h3>
                            <span align="left" class="mt-1">
                              <span v-if="pessoaFisicaInfo.contato.fixo">
                                <strong>Telefone Fixo: </strong> {{pessoaFisicaInfo.contato.fixo}} <br/>
                              </span>
                              <strong>Telefone Celular: </strong>{{pessoaFisicaInfo.contato.celular}} <br/>
                              <span v-if="pessoaFisicaInfo.contato.linkedin">
                                <strong>Linkedin: </strong> {{pessoaFisicaInfo.contato.linkedin}} <br/>
                              </span>
                              <span v-if="pessoaFisicaInfo.contato.facebook">
                                <strong>Facebook: </strong> {{pessoaFisicaInfo.contato.facebook}} <br/>
                              </span>
                              <span v-if="pessoaFisicaInfo.contato.twitter">
                                <strong>Twitter: </strong> {{pessoaFisicaInfo.contato.twitter}} <br/>
                              </span>
                              <span v-if="pessoaFisicaInfo.contato.site">
                                <strong>Site: </strong> {{pessoaFisicaInfo.contato.site}} <br/>
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
    <template v-if="tab == 'tab-2'">
      <v-card align="center">
        <v-card-text>
          <template v-if="modoEdicao">
            <FormPessoaFisicaCurriculo :edicao="true"></FormPessoaFisicaCurriculo>
          </template>
          <template v-else>
            <v-list flat>
            <v-list-item-group color="primary">
              <v-list-item class="mb-2">
                <v-list-item-content>
                  <h2 align="left">Objetivos Profissionais</h2>
                    {{pessoaFisicaCurriculo.curriculo.objetivos}}
                </v-list-item-content>
              </v-list-item>
              <v-list-item class="mb-2">
                <v-list-item-content >
                  <h2 align="left">Área de Atuação</h2>
                  {{pessoaFisicaCurriculo.area.tipo}}
                </v-list-item-content> 
              </v-list-item>
              <v-list-item class="mb-2">
                <v-list-item-content>
                  <h2 align="left">Pretensão Salarial</h2>
                    R$ {{pessoaFisicaCurriculo.curriculo.pretensao}}
                </v-list-item-content>
              </v-list-item>
              <v-list-item class="mb-2">
                <v-list-item-content>
                  <h2 align="left">Formação Acadêmica</h2>
                    {{pessoaFisicaCurriculo.curriculo.escolaridade}}
                </v-list-item-content>
              </v-list-item>
              <v-list-item class="">
                <v-list-item-content>
                  <h2 align="left" class="mb-2">Histórico Profissional</h2>
                    <span class="mb-3" align="left" v-for="historico in pessoaFisicaCurriculo.historicoProfissional" :key="historico.id">
                      <strong>Data Inicial</strong>: {{historico.dataInicial | dateFormat}} <br/>
                      <strong>Data Final</strong>: {{historico.dataFinal | dateFormat}} <br/>
                      <strong>Descrição</strong>: {{historico.descricaoExperiencia}} <br/>
                    </span>
                </v-list-item-content>
              </v-list-item>
              <v-list-item class="mb-2">
                <v-list-item-content>
                  <h2 align="left">Qualificações</h2>
                    {{pessoaFisicaCurriculo.curriculo.qualificacoes}}
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
            </v-list>
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
import FormPessoaFisicaCurriculo from '@/components/Forms/FormPessoaFisicaCurriculo'
import {actionTypes} from '@/core/constants'
import ModalAlert from '@/components/Utils/ModalAlert'
import {mapState} from 'vuex'
import moment from 'moment'
export default {
  components: {FormPessoaFisicaCurriculo, ModalAlert},
  data(){
    return{
      nome: this.$store.state.auth.user.name,
      modoEdicao: false,
      isLoaded: false,
      tab: null, 
      text: `loremalp ksa kspadejmf iejfiejf oejfpej foej fpejf pe`,
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
  async created(){
    //await this.getFisicaProfile()
    console.log('modo edicao no profile?', this.modoEdicao)
  },
  computed:{
    ...mapState(['pessoaFisicaInfo', 'pessoaFisicaCurriculo', 'upload'])
  },
  methods:{
    async getFisicaProfile(){
      this.$store.dispatch(actionTypes.GET_PESSOA_FISICA)
        .then(response => {
          this.isLoaded = true
        })
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