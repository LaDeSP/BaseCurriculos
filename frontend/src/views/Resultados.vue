<template>
 <v-row align="center" justify="center">
    <v-col cols="12" lg="12" md="12" sm="10">
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-card align="center">
        <v-card-title class="text-center justify-center py-6">
          <h1>Resultados</h1> 
        </v-card-title>
        <v-card-text>
          <v-row justify="center">
            <template v-if="resultado.length == 0">
              <v-col>
                <span class="aviso">Nenhum resultado encontrado.</span>
              </v-col>
            </template>
            <template v-else>
              <v-snackbar
                top
                v-model="snackbar"
                :timeout="timeout"
              > {{notificacao}}
                <template v-slot:action="{ attrs }">
                  <v-btn
                    color="primary"
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                  >Fechar</v-btn>
                </template>
              </v-snackbar>
              <v-col cols="12" lg="6" md="6" sm="6" v-for="curriculo in resultado" :key="curriculo.id">
                <v-card class="py-5 my-5">
                  <v-card-title class="text-center justify-center primary--text">
                    <h3>{{curriculo.fisica.user.name}}</h3>
                  </v-card-title>
                  <ThumbnailPic :foto="curriculo.fisica.user.foto"></ThumbnailPic>
                  <v-card-text class="black--text" style="overflow-y: auto; height:280px" align="left">
                    <strong>Qualificações: </strong> {{curriculo.qualificacoes}} <br/>
                    <strong>Escolaridade: </strong> {{curriculo.escolaridade}} <br/>
                    <strong>Objetivos: </strong> {{curriculo.objetivos}} <br/>
                    <strong>Pretensão Salarial</strong> {{curriculo.pretensao}} <br/>
                    <strong>Histórico Profissional: </strong> {{curriculo.historicoProfissional}} <br/>
                    <strong>Cidade: </strong> {{curriculo.fisica.endereco.cidade}} <br/>
                    <strong>Área de Atuação</strong> {{curriculo.area.tipo}} <br/>
                  </v-card-text>
                  <v-card-actions class="justify-center text-center">
                    <v-spacer></v-spacer>
                    <v-select
                      v-model="vaga[curriculo.id]"
                      :items="getVagasAtivas"
                      item-text="titulo"
                      item-value="id"
                    ></v-select>
                    <v-spacer></v-spacer>
                    <v-btn color="success" class="ml-1"
                      :loading="pleaseWaitDialog"
                      :disabled="vaga[curriculo.id] ==''||vaga[curriculo.id] == undefined"
                      @click="convidar(curriculo.id)"
                    >Convidar</v-btn>
                    <v-dialog
                      v-model="pleaseWaitDialog"
                      hide-overlay
                      persistent
                      width="300"
                    > 
                      <v-card class="grey darken-3 text-center white--text" dark>
                        <v-card-text>Por favor, aguarde...
                          <v-progress-linear
                            indeterminate
                            color="white"
                            class="mb-0"
                          ></v-progress-linear>
                        </v-card-text>
                      </v-card>
                    </v-dialog>
                  </v-card-actions>
                </v-card>
              </v-col>
            </template>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
 </v-row>
</template>

<script>
import {mapGetters, mapState} from 'vuex'
import {actionTypes} from '@/core/constants'
import ThumbnailPic from '@/components/Utils/ThumbnailPic'

const customLabels = {
  first: 'Primeira',
  last: 'Última',
  previous: 'Anterior',
  next: 'Próxima' 
}
export default {
  components: {ThumbnailPic},
  data() {
    return {
      keywords: '',
      pleaseWaitDialog: false,
      snackbar: false,
      notificacao: '',
      timeout: 5000,
      pageOfItems: [],
      customLabels,
      convite: '',
      vaga_id: 0,
      vaga: [],
      thisCurriculo: ''
    }
  },
  async created(){
    if(this.tipoPermissao == 'JURIDICA'){
      await this.searchCurriculos()
      await this.$store.dispatch(actionTypes.GET_VAGAS_JURIDICAS)
    }else if(this.tipoPermissao == 'FISICA'){
      await this.searchVagas()
    }
  },
  computed: {
    ...mapState(['resultado']),
    ...mapGetters(['tipoPermissao', 'getVagasAtivas'])
  },
  methods: {
    async searchCurriculos(){
      if((this.$route.query.escolaridade!='' || this.$route.query.objetivos!='' || this.$route.query.historicoProfissional!='' || this.$route.query.cidade!='' || this.$route.query.nome!='' || this.$route.query.area!='') == true && (this.$route.query.escolaridade!=undefined || this.$route.query.objetivos!=undefined || this.$route.query.historicoProfissional!=undefined || this.$route.query.cidade!=undefined || this.$route.query.nome!=undefined || this.$route.query.area!=undefined) == true){
        let pesquisa = {
          keywords : this.$route.query.keywords,
          escolaridade : this.$route.query.escolaridade,
          objetivos : this.$route.query.objetivos,
          historicoProfissional : this.$route.query.historicoProfissional,
          cidade : this.$route.query.cidade,
          nome: this.$route.query.nome,
          area: this.$route.query.area,
        }
        await this.$store.dispatch(actionTypes.GET_BUSCA_AVANCADA_CURRICULOS, pesquisa)
      }else{
        await this.$store.dispatch(actionTypes.GET_BUSCA_CURRICULOS, this.$route.query.keywords)
      }
    },
    async searchVagas(){
      if((this.$route.query.cargo!='' || this.$route.query.beneficio!='' || this.$route.query.jornada!='' || this.$route.query.requisitos!='' || this.$route.query.area!='') == true && (this.$route.query.cargo!=undefined || this.$route.query.beneficio!=undefined || this.$route.query.jornada!=undefined || this.$route.query.requisitos!=undefined || this.$route.query.area!=undefined) == true){
        let pesquisa = {
          keywords : this.$route.query.keywords,
          cargo : this.$route.query.cargo,
          beneficio : this.$route.query.beneficio,
          jornada : this.$route.query.jornada,
          requisitos : this.$route.query.requisitos,
          area: this.$route.query.area,
        }
        await this.$store.dispatch(actionTypes.GET_BUSCA_AVANCADA_VAGAS, pesquisa)
      }else{
        await this.$store.dispatch(actionTypes.GET_BUSCA_VAGAS, this.$route.query.keywords)
      }
    },
    async convidar(id){
      if(this.vaga[id] == '' || this.vaga[id] == undefined){
        this.notificacao = 'Selecione uma vaga!'
        this.snackbar = true
        return
      }
      this.pleaseWaitDialog = true
      let requestConvite = {
        vaga_id: this.vaga[id],
        curriculo_id: id
      }
      await this.$store.dispatch(actionTypes.CREATE_NOVO_CONVITE, requestConvite)
        .then(response => {
          this.pleaseWaitDialog = false
          console.log('response no convite', response)
          if(response.error){
            console.log(response.error[0][0] == "Essa pessoa está candidata nessa vaga.", response.error[0][0])
            if(response.error[0][0] == "Essa pessoa está candidata nessa vaga."){
              this.notificacao = 'Já existe uma candidatura dessa pessoa nessa vaga no momento.'
              this.snackbar = true
            }else{
              this.notificacao = 'Você já convidou essa pessoa pra essa vaga!'
              this.snackbar = true
            }
          }
        })
    }
  }
}
</script>
