<template>
<div>
  <v-row justify="center">
    <v-snackbar
      top
      v-model="snackbar"
      :timeout="timeout"
    >{{notificacao}}
      <template v-slot:action="{ attrs }">
        <v-btn
          color="primary"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >Fechar</v-btn>
      </template>
    </v-snackbar>
    <v-col class="d-flex flex-column" cols="12" lg="6" md="6" sm="8" v-for="curriculo in resultado" :key="curriculo.id">
      <v-card class="py-5 my-5 flex d-flex flex-column">
        <v-card-title class="text-center justify-center primary--text">
          <h3>{{curriculo.fisica.user.name}}</h3>
        </v-card-title>
        <ThumbnailPic :foto="curriculo.fisica.user.foto"></ThumbnailPic>
        <v-card-text class="black--text" align="left">
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
  </v-row>
  <v-row align="center" justify="center">
    <v-col cols="12" md="6">
      <template v-if="resultado.length > 4">
        <jw-pagination 
          :items="resultado"
          @changePage="onChangePage"
          :pageSize="4"
          :labels="customLabels"
        ></jw-pagination>
      </template>
      <template v-else>
        <span style="display: none" >
          <jw-pagination 
            :items="resultado" 
            @changePage="onChangePage"
            :pageSize="4" 
            :labels="customLabels"
          ></jw-pagination>
        </span>
      </template>
    </v-col>
  </v-row>
</div>
</template>


<script>
import {mapGetters, mapState} from 'vuex'
import {actionTypes} from '@/core/constants'
import ThumbnailPic from '@/components/Utils/ThumbnailPic'

const customLabels = {
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
      vaga: []
    }
  },
  computed: {
    ...mapState(['resultado']),
    ...mapGetters(['tipoPermissao', 'getVagasAtivas'])
  },
  methods: {
    onChangePage(pageOfItems){
      this.pageOfItems = pageOfItems
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
          }else{
            this.notificacao = 'Convite realizado com sucesso!'
            this.snackbar = true
          }
        })
    }
  }
}
</script>
