<template>
<v-row align="center" justify="center" class="mb-12" v-if="isLoaded">
  <v-col cols="12" lg="12" md="12" sm="12">
    <router-link to="/candidaturas">
      <v-btn class="mr-2">
        <v-icon class="pr-1">mdi-arrow-left-circle</v-icon> Voltar
      </v-btn>
    </router-link>
    <template v-if="tipoPermissao == 'JURIDICA'">
      <router-link to="/agenda">
        <v-btn class="mr-2">
          <v-icon class="pr-1">fas fa-calendar-alt</v-icon> Agenda
        </v-btn>
      </router-link>
    </template>
    <router-link to="/dashboard">
      <v-btn>
        <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
      </v-btn>
    </router-link>
    <v-card justify="center" class="mb-12" color="white darken-1">
      <ValidationObserver ref="observer" v-slot="{ invalid }">
      <form>
        <v-card-title class="justify-center text-center"><h2>Agendar Entrevista</h2></v-card-title>
        <v-card-text align="center">
          <template v-if="notificacoes">
            <span class="rounded-lg pa-1 mr-1 mt-3 mb-10 text-center red lighten-2 white--text" v-for="(notificacao, index) in notificacoes" :key="index">
              {{notificacao[0]}}
            </span>
          </template>
          <ValidationProvider name="data" rules="required" v-slot="{errors}">
            <v-menu
              ref="menu"
              v-model="menu"
              :close-on-content-click="false"
              transition="scale-transition"
              offset-y
              max-width="290px"
              min-width="290px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="dateFormated"
                  label="Data *"
                  persistent-hint
                  readonly
                  :rules="rulesPeriodo"
                  :error-messages="errors"
                  append-outer-icon="fa-calendar"
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-date-picker scrollable locale="pt-br" v-model="data" no-title @input="menu = false"></v-date-picker>
            </v-menu>
          </ValidationProvider>
          <ValidationProvider v-slot="{ errors }" name="hora" rules="required">
            <v-menu
              ref="menu"
              v-model="menu2"
              :close-on-content-click="false"
              :nudge-right="40"
              :return-value.sync="hora"
              transition="scale-transition"
              offset-y
              max-width="290px"
              min-width="290px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="hora"
                  label="Hora *"
                  :rules="rulesPeriodo"
                  :error-messages="errors"
                  append-outer-icon="mdi-clock"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-time-picker
                scrollable
                format="24hr"
                v-if="menu2"
                v-model="hora"
                full-width
                @click:minute="$refs.menu.save(hora)"
              ></v-time-picker>
            </v-menu>
          </ValidationProvider>
            <v-textarea
              class="mt-3"
              name="Observação"
              label="Observação"
              v-model="observacao"
              persistent-hint
              hint="Use esse campo para falar dados de contato e localização, enviar links de videoconferência, bem como qualquer outra informação importante."
              outlined
            ></v-textarea>
          <small class="red--text">* Campo obrigatório</small>
        </v-card-text>
        <v-card-actions class="text-center justify-center">
          <v-btn :disabled="invalid" color="success" @click="submit">Salvar</v-btn>
        </v-card-actions>
      </form>
      </ValidationObserver>
    </v-card>
  </v-col>
</v-row>
</template>

<script>
import {actionTypes} from '@/core/constants'
import {mapState, mapGetters} from 'vuex'
import moment from 'moment'
export default {
  data(){
    return {
      step: 1,
      isLoaded: false,
      menu: false,
      menu2: false,
      data: '',
      hora: '',
      observacao: '',
      contraproposta: '',
      candidaturaId: 0,
      edicao: false,
      notificacoes: [],
      rulesPeriodo: [value => !!value || 'Esse campo é obrigatório.']

    }
  },
  async created(){
    console.log(this.$route.params)
    if(this.$route.params.editCandidaturaId){
      this.edicao = true 
      await this.$store.dispatch(actionTypes.GET_AGENDA)
      this.loadDataToEdit()
      this.isLoaded = true
    }else{
      this.isLoaded = true
    }
  },
  computed: {
    ...mapState(['agenda']),
    ...mapGetters(['tipoPermissao', 'getAgendaById']),
    agendaById(){
      return this.agendaById(this.$route.params.id)
    },
    dateFormated(){
      if(this.data != '' && this.data != undefined){
        return moment(this.data).format('DD/MM/YYYY')
      }else{
        return this.data
      }
    }
  },
  methods: {
    async submit(){
      if(this.edicao) setContraproposta()
      else this.candidaturaId = this.$route.params.newCandidaturaId
      let agendaPayload = {
        data: this.data, 
        hora: this.hora, 
        observacao: this.observacao, 
        contraproposta: this.contraproposta, 
        candidatura_id: this.candidaturaId,
        updateId: this.$route.params.id
      }
      if(!this.edicao){
        await this.$store.dispatch(actionTypes.CREATE_NOVO_AGENDAMENTO, agendaPayload)
          .then(response => {
            if(response.error != undefined){
              this.notificacoes = response.error
            }else{
              this.$router.push({name: 'agenda', params:{cadastroAgendaSucesso: true}})
            }
          })
      }else{
        await this.$store.dispatch(actionTypes.UPDATE_AGENDAMENTO, agendaPayload)
          .then(response => {
            if(response.error != undefined){
              this.notificacoes = response.error
            }else{
              if(this.tipoPermissao == 'FISICA'){
                console.log('deu bom fisica')
                //this.$router.push({name: 'candidaturas', params:{editouEntrevista: true}})
              }else{
                console.log('deu bom juridica')
                //this.$router.push({ name: 'agenda', params:{agendou: true} })
              }
            }
          })
      }
    },
    setContraproposta(){
      if(this.tipoPermissao == 'FISICA'){
        this.contraproposta = 'FISICA'
      }else if(this.tipoPermissao == 'JURIDICA'){
        this.contraproposta = 'JURIDICA'
      }
      this.candidaturaId = this.$route.params.editCandidaturaId
    },
    loadDataToEdit(){
      this.data = this.agendaById[0].data 
      this.hora = this.agendaById[0].hora 
    }
  }
}
</script>