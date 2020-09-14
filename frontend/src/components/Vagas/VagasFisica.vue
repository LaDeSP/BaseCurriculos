<template>
 <div>
  <v-row justify="center">
    <v-snackbar
      top
      v-model="snackbar"
      :timeout="timeout"
    > {{notificacao}}
      <template v-slot:action="{ attrs }">
        <v-btn
          color="blue"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >Fechar</v-btn>
      </template>
    </v-snackbar>
    <template v-if="vagas.length > 0">
      <template v-if="!vagaBuscada"><h2 class="text-center my-4">Vagas que podem lhe interessar</h2></template>
      <v-row >
        <v-col class="d-flex flex-column" cols="12" lg="6" md="6" sm="6" v-for="vaga in pageOfItems" :key="vaga.id">
          <v-card class="py-5 flex d-flex flex-column">
            <v-card-title class="primary--text text-center justify-center">
              <h3>{{vaga.titulo}}</h3> id {{vaga.id}}
            </v-card-title>
            <v-card-text class="black--text same-size-card">
              <strong>Cargo:</strong> {{vaga.cargo}} <br/>
              <strong>Área de Atuação:</strong> {{vaga.area.tipo}} <br/>
              <strong>Jornada de Trabalho:</strong> {{vaga.jornada}}
            </v-card-text>
            <v-card-actions class="text-center justify-center">
              <template v-if="vaga.my_candidatura">
                <v-chip class="success">Você já se candidatou a esta vaga!</v-chip>
              </template>
              <template v-else>
                <v-dialog v-model="dialog" max-width="800px">
                  <template v-slot:activator="{on: evento, attrs}"> 
                    <v-btn
                      color="primary"
                      class="mr-1"
                      dark 
                      v-bind="attrs"
                      v-on="evento"
                    >
                      Ver Mais
                    </v-btn>
                    <v-btn
                      color="success"
                      dark 
                      :loading="pleaseWaitDialog"
                      @click="criarCandidatura(vaga.id)"
                    >
                      Se Candidatar
                    </v-btn>
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
                  </template>
                  <v-card>
                      <v-card-title class="text-center justify-center">
                        <h3 class="primary--text">{{vaga.titulo}}</h3>
                      </v-card-title>
                      <v-card-text class="black--text">
                        <strong>Descrição:</strong> {{vaga.descricao}}<br/>
                        <strong>Cargo:</strong> {{vaga.cargo}}<br/>
                        <strong>Área de Atuação:</strong> {{vaga.area.tipo}}<br/>
                        <strong>Jornada de Trabalho:</strong> {{vaga.jornada}}<br/>
                        <strong>Salário:</strong> {{vaga.salario}}<br/>
                        <strong>Benefícios:</strong> {{vaga.beneficio}}<br/>
                        <strong>Requisitos:</strong> {{vaga.requisito}}<br/>      
                      </v-card-text>
                      <v-card-actions class="text-center justify-center">
                        <v-btn
                          color="grey white--text"
                          @click="dialog = false"
                        >
                          Voltar
                        </v-btn>
                        <v-btn
                          color="success"
                          dark 
                          @click="criarCandidatura()"
                        >
                          Se Candidatar
                        </v-btn>
                      </v-card-actions>
                  </v-card>
                </v-dialog>
              </template>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
      <v-row align="center" justify="center">
        <v-col cols="12" md="6">
          <template v-if="vagas.length > 4">
            <jw-pagination 
              :items="vagas"
              @changePage="onChangePage"
              :pageSize="4"
              :labels="customLabels"
            ></jw-pagination>
          </template>
          <template v-else>
            <span style="display: none" >
              <jw-pagination 
                :items="vagas" 
                @changePage="onChangePage"
                :pageSize="4" 
                :labels="customLabels"
              ></jw-pagination>
            </span>
          </template>
        </v-col>
      </v-row>
    </template>
    <template v-else>
      <template v-if="!vagaBuscada"><h2 class="text-center my-4">Não temos nenhuma vaga para recomendar no momento. </h2></template>
    </template>
  </v-row>
</div>
</template>

<script>
import {actionTypes} from '@/core/constants'
import {mapGetters, mapState} from 'vuex'
import JwPagination from 'jw-vue-pagination'

const customLabels = {
  previous: "Anterior",
  next: "Próxima"
}

export default {
  props: {vagaBuscada: Boolean},
  components: {JwPagination},
  data() {
    return {
      pageOfItems: [],
      notificacao: '',
      snackbar: false,
      pleaseWaitDialog: false,
      dialog: false,
      timeout: 2000,
      customLabels
    }
  },
  computed: {
    ...mapState(['resultado', 'auth']),
    ...mapGetters(['getVagasAtivas']),
    vagas(){
      if(this.vagaBuscada){
        return this.resultado
      }else{
        return this.getVagasAtivas
      }
    }
  },
  methods: {
    onChangePage(pageOfItems){
      this.pageOfItems = pageOfItems
    },
    async criarCandidatura(vagaId){
      let payload = {
        vagaId: vagaId, 
        userId: this.auth.user.id
      }
      this.pleaseWaitDialog = true
      let response = await this.$store.dispatch(actionTypes.REQUEST_VAGA_DASH, payload)
      console.log('response er', response, response.error != undefined)
      if(response.error != undefined){
        this.notificacao = response.error
        this.snackbar = true
      }else{
        this.notificacao = 'Candidatura realizada com sucesso'
        this.snackbar = true
        if(this.vagaBuscada){
          for(let i = 0; i < this.resultado.length; i++){
            if (this.resultado[i].id == this.vagaId) {
              this.resultado.splice(i, 1)
            }
          }
        }
      }
      this.pleaseWaitDialog = false
    }
  }
}
</script>

<style scoped lang="stylus">
  .v-application a:hover
    color #4e73df !important
    text-decoration underline
  .borda-card
    border-left 5px solid #4e73df !important
  .v-card__title
    justify-content center
  .same-size-card 
    height 100px !important
</style>