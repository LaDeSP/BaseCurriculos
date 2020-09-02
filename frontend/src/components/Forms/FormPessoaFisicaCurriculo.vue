<template>
<v-row class="mb-12">
  <v-col cols="12" lg="12" md="12" sm="12">
    <v-stepper class="mt-3" v-model="step">
    <v-stepper-header>
      <v-stepper-step :complete="step > 1" editable step="1">Informações Pessoais</v-stepper-step>
          <v-divider></v-divider>
      <v-stepper-step :complete="step > 2" editable step="2">Contato</v-stepper-step>
          <v-divider></v-divider>
      <v-stepper-step :complete="step > 3" editable step="3">Endereço</v-stepper-step>
          <v-divider></v-divider>
      <v-stepper-step :complete="step > 4" editable step="4">Informações Profissionais</v-stepper-step>  
    </v-stepper-header>
    <form>
      <ValidationObserver ref="observer" v-slot="{ invalid }">
      <v-stepper-items>
        <v-card flat class="mb-12" color="white darken-1" align="center">
          <template v-if="notificacoes">
            <span class="rounded-lg pa-1 mr-1 mt-3 mb-10 text-center red lighten-2 white--text" v-for="(notificacao, index) in notificacoes" :key="index">
              {{notificacao[0]}}
            </span>
          </template>
          <InformacoesPessoais :edicao="edicao" @handlePayload="getPayloadInfosPessoais" @handleStep="getStep"></InformacoesPessoais>
          <Contato :edicao="edicao" @handlePayload="getPayloadContato" @handleStep="getStep"></Contato>
          <Endereco :edicao="edicao" @handlePayload="getPayloadEndereco" @handleStep="getStep"></Endereco>
          <template>
            <v-stepper-content step="4">
              <v-card-text>
                  <v-icon size="45" class="mb-4">fas fa-file-alt</v-icon>
                  <ValidationProvider v-slot="{ errors }" name="objetivosProfissionais" rules="required|max:5000">
                    <v-textarea
                      name="Objetivos Profissionais"
                      label="Objetivos Profissionais *"
                      :error-messages="errors"
                      maxlength="5000"
                      v-model="objetivosProfissionais"
                      outlined
                    ></v-textarea>
                  </ValidationProvider>
                  <ValidationProvider v-slot="{ errors }" name="areaAtuacao" rules="required">
                    <v-select
                      class="mt-0"
                      v-model="areaAtuacao"
                      :items="itemsAreaAtuacao"
                      item-text="tipo"
                      item-value="id"
                      :error-messages="errors"
                      label="Área de Atuação *"
                      required
                    ></v-select>
                  </ValidationProvider>
                  <ValidationProvider v-slot="{ errors }" name="pretensaoSalarial" rules="required|numeric|min_value:1|max_value:1000000|max:7">
                    <v-text-field
                      class="mt-3"
                      type="number"
                      v-model="pretensaoSalarial"
                      :error-messages="errors"
                      label="Pretensão Salarial *"
                      required
                    ></v-text-field>
                  </ValidationProvider>
                  <ValidationProvider v-slot="{ errors }" name="select" rules="required">
                    <v-select
                      class="mt-3"
                      v-model="nivelEscolaridade"
                      :items="itemsNivelEscolaridade"
                      :error-messages="errors"
                      label="Nível de Escolaridade *"
                      required
                    ></v-select>
                  </ValidationProvider>
                  <ValidationProvider v-slot="{ errors }" name="qualificacoes" rules="required|max:5000">
                    <v-textarea
                      class="mt-3"
                      name="Qualificações"
                      label="Qualificações *"
                      :error-messages="errors"
                      v-model="qualificacoes"
                      hint="Insira sua formação, seus cursos, qualidades, etc."
                      outlined
                    ></v-textarea>
                  </ValidationProvider>  
                <h3 class="justify-center text-center">Histórico Profissional</h3>
                <v-row align="center" justify="center">
                  <v-col cols="12" md="4">
                    <ValidationProvider name="dataInicial" v-slot="{errors}" slim>
                      <v-menu
                        v-model="menu1"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="dataInicialFormatada"
                            label="Data Inicial"
                            persistent-hint
                            readonly
                            :error-messages="errors"
                            append-outer-icon="fa-calendar"
                            v-bind="attrs"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker locale="pt-br" v-model="dataInicial" no-title @input="menu1 = false"></v-date-picker>
                      </v-menu>
                    </ValidationProvider>
                  </v-col>
                  <v-col cols="12" md="4">
                    <ValidationProvider name="dataFinal" v-slot="{errors}" slim>
                      <v-menu
                        v-model="menu2"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="dataFinalFormatada"
                            label="Data Final"
                            persistent-hint
                            readonly
                            :error-messages="errors"
                            append-outer-icon="fa-calendar"
                            v-bind="attrs"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker locale="pt-br" v-model="dataFinal" no-title @input="menu2 = false"></v-date-picker>
                      </v-menu>
                    </ValidationProvider>
                  </v-col>
                  <v-col cols="12" md="4">
                    <ValidationProvider name="descricaoExperiencia" v-slot="{errors}" slim>
                      <v-text-field
                        v-model="descricaoExperiencia"
                        label="Experiência"
                        :error-messages="errors"
                        required
                      ></v-text-field>
                    </ValidationProvider>
                  </v-col>
                  <span class="red lighten-2 white--text" v-if="isExperienciaDuplicate">
                    {{aviso}}
                  </span>
                  <span class="green lighten-2 white--text" v-if="!isExperienciaDuplicate && aviso != ''">
                    {{aviso}}
                  </span>
                  <v-col cols="12" md="10"> 
                    <v-btn color="info accent-3 white--text mb-4" @click="adicionarExperiencia">Adicionar</v-btn>
                    <template v-if="experiencias.length > 0">
                      <v-expansion-panels>
                      <v-expansion-panel>
                        <v-expansion-panel-header>Experiências</v-expansion-panel-header>
                        <v-expansion-panel-content class="text-left text-justify">
                            <v-row v-for="(experiencia, index) in experienciasTratado" :key="index">
                              <v-col cols="12" md="10">
                                <span>
                                  <strong>Data Inicial</strong>: {{experiencia.dataInicial | dateFormat}} <br/>
                                  <strong>Data Final</strong>: {{experiencia.dataFinal | dateFormat}} <br/>
                                  <strong>Descrição</strong>: {{experiencia.descricaoExperiencia}} <br/>
                              </span>
                              </v-col>
                              <v-col cols="12" md="2" class="mt-4" align="center" >
                                <v-btn small color="red lighten-2 white--text" @click="removerExperiencia(index)">
                                  <v-icon>mdi-close-thick</v-icon>
                                </v-btn>
                              </v-col>
                            </v-row>
                        </v-expansion-panel-content>
                      </v-expansion-panel>
                    </v-expansion-panels>
                    </template>
                  </v-col>
                </v-row>
              </v-card-text>
              <v-card-actions><small class="red--text">* Campo obrigatório</small></v-card-actions>
              <v-btn color="default" class="mr-3" @click="step = 3">Voltar</v-btn>
              <v-btn 
                class="ml-3 mr-3 green white--text" 
                :loading="pleaseWaitDialog" 
                @click="submit()"
              >Salvar</v-btn>
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
            </v-stepper-content>
          </template>
        </v-card>
      </v-stepper-items>
      </ValidationObserver>
    </form>
  </v-stepper>
  </v-col>
</v-row>
</template>

<script>
import moment from 'moment'
import {mapState} from 'vuex'
import InformacoesPessoais from './FormPessoaFisicaComponents/InformacoesPessoais'
import Contato from './FormPessoaFisicaComponents/Contato'
import Endereco from './FormPessoaFisicaComponents/Endereco'
import InformacoesProfissionais from './FormPessoaFisicaComponents/InformacoesProfissionais'
import { actionTypes } from '../../core/constants'

export default {
  components: {InformacoesPessoais, Contato, Endereco, InformacoesProfissionais},
  props: {
    edicao: Boolean
  },
  data(){
    return {
      step: 1,
      isLoaded: false,
      pleaseWaitDialog: false,
      aviso: '',
      notificacoes: [],
      menu: false,
      name: '',
      nascimento: '',
      genero: '',
      estadoCivil: '',
      paisNacionalidade: '',
      fixo: '',
      celular: '',
      linkedin: '',
      facebook: '',
      twitter: '',
      site: '',
      cep: '',
      estado: '',
      cidade: '',
      bairro: '',
      rua: '',
      numero: '',
      complemento: '',
      objetivosProfissionais: '',
      areaAtuacao: '',
      pretensaoSalarial: '',
      nivelEscolaridade: '',
      qualificacoes: '',
      dataInicial: '',
      dataFinal: '',
      menu1: false,
      menu2: false,
      descricaoExperiencia: '',
      experiencias: [],
      itemsNivelEscolaridade: [
        "Ensino Fundamental(Incompleto)",
        "Ensino Fundamental(Cursando)", 
        "Ensino Fundamental(Completo)",
        "Ensino Médio(Incompleto)", 
        "Ensino Médio(Cursando)", 
        "Ensino Médio(Completo)", 
        "Ensino Superior(Incompleto)", 
        "Ensino Superior(Cursando)",
        "Ensino Superior(Completo)", 
        "Pós-Graduação(Especialização)", 
        "Pós-Graduação(Mestrado)", 
        "Pós-Graduação(Doutorado)"
      ],
      itemsAreaAtuacao: [],
      isExperienciaDuplicate: false,
      rulesPeriodo: [value => !!value || 'Esse campo é obrigatório.']
      
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
    await this.$store.dispatch(actionTypes.GET_AREAS)
      .then(response => {
        this.itemsAreaAtuacao = response.areas
      })
    console.log('modo edicao?', this.edicao)
    if(this.edicao){
      this.loadDataToEdit()
    }
  },
  computed: {
    ...mapState(['pessoaFisicaInfo', 'pessoaFisicaCurriculo']),
    dataInicialFormatada(){
      if(this.dataInicial != ''){
        return moment(this.dataInicial).format('DD/MM/YYYY')
      }else{
        return this.dataInicial
      }
    },
    dataFinalFormatada(){
      if(this.dataFinal != ''){
        return moment(this.dataFinal).format('DD/MM/YYYY')
      }else{
        return this.dataFinal
      }
    },
    experienciasTratado(){
      return this.experiencias
    }
  },
  methods: {
    submit(){
      this.pleaseWaitDialog = true
      let payload = {
        nome: this.name,
        nascimento: this.nascimento,
        genero: this.genero,
        estadoCivil: this.estadoCivil,
        pais: this.paisNacionalidade,
        fixo: this.fixo,
        celular: this.celular,
        linkedin: this.linkedin,
        facebook: this.facebook,
        twitter: this.twitter,
        site: this.site, 
        cep: this.cep,
        estado: this.estado, 
        cidade: this.cidade, 
        bairro: this.bairro, 
        rua: this.rua, 
        complemento: this.complemento, 
        numero: this.numero,
        objetivos: this.objetivosProfissionais,
        area: this.areaAtuacao,
        pretensao: this.pretensaoSalarial,
        escolaridade: this.nivelEscolaridade,
        qualificacoes: this.qualificacoes,
        historicoProfissional: this.experiencias
      }
      if(!this.edicao){
        this.$store.dispatch(actionTypes.COMPLETE_PESSOA_FISICA, payload)
        .then(response =>{
          if(response.error != undefined){
            this.notificacoes = response.error
            this.pleaseWaitDialog = false
          }else{
            this.pleaseWaitDialog = false
            this.$emit('isDataCompleted', true)
            //this.$router.push({ name: 'dashboard', params:{cadastroCurriculoSucesso: true} })
          }
        })
      }else{
        this.$store.dispatch(actionTypes.UPDATE_PESSOA_FISICA, payload)
        .then(response =>{
          if(response.error != undefined){
            this.notificacoes = response.error
            this.pleaseWaitDialog = false
          }else{
            this.pleaseWaitDialog = false
            //this.$router.push({ name: 'dashboard', params:{cadastroCurriculoSucesso: true} })
          }
        })
      }
    },
    getStep(value){
      this.step = value
    },
    adicionarExperiencia(){
      let payload = {
        'dataInicial': this.dataInicial,
        'dataInicialFormatada': this.dataInicialFormatada,
        'dataFinal': this.dataFinal,
        'dataFinalFormatada': this.dataFinalFormatada,
        'descricaoExperiencia': this.descricaoExperiencia
      }
      let experiencias = this.experiencias

      this.isExperienciaDuplicate = experiencias.map(value => {
        if(value.descricaoExperiencia == payload.descricaoExperiencia && value.dataInicial == payload.dataInicial && value.dataFinal == payload.dataFinal){
          return true
        }
      }) 
      if(this.isExperienciaDuplicate == false){
        this.experiencias.push(payload)
        this.aviso = 'Adicionado com sucesso.'
        this.isExperienciaDuplicate = false
      }else{
        this.aviso = 'Você já adicionou essa experiência!'
      } 
    },
    removerExperiencia(indexExperiencia){
      let filteredExperiencias = this.experiencias.filter((experiencia, index) => {
        return index != indexExperiencia
      })
      this.experiencias = filteredExperiencias
    },
    getPayloadInfosPessoais(value){
      this.name = value.name
      this.nascimento = value.nascimento
      this.genero = value.genero
      this.estadoCivil = value.estadoCivil
      this.paisNacionalidade = value.paisNacionalidade
    },
    getPayloadContato(value){
      this.fixo = value.fixo
      this.celular = value.celular
      this.linkedin = value.linkedin
      this.facebook = value.facebook 
      this.twitter = value.twitter
      this.site = value.site 
    },
    getPayloadEndereco(value){
      this.cep = value.cep 
      this.estado = value.estado 
      this.cidade = value.cidade 
      this.bairro = value.bairro 
      this.rua = value.rua 
      this.complemento = value.complemento 
      this.numero = value.numero
    },
    loadDataToEdit(){  
      this.objetivosProfissionais = this.pessoaFisicaCurriculo.curriculo.objetivos
      this.areaAtuacao = this.pessoaFisicaCurriculo.area.id
      this.pretensaoSalarial = this.pessoaFisicaCurriculo.curriculo.pretensao 
      this.nivelEscolaridade = this.pessoaFisicaCurriculo.curriculo.escolaridade
      this.qualificacoes = this.pessoaFisicaCurriculo.curriculo.qualificacoes
      this.experiencias = this.pessoaFisicaCurriculo.historicoProfissional
    }
  },
}
</script>