<template>
<v-stepper-content step="4">
  <ValidationObserver ref="observer" v-slot="{ invalid }">
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
          :items="itemsNivelEscolaridade"
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
                label="Data Final"
                persistent-hint
                :rules="rulesPeriodo"
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
                :rules="rulesPeriodo"
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
      <span class="red lighten-2 white--text" v-if="notificacao != ''">
        {{notificacao}}
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
                    <strong>Data Inicial</strong>: {{experiencia.dataInicialFormatada}} <br/>
                    <strong>Data Final</strong>: {{experiencia.dataFinalFormatada}} <br/>
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
  <v-btn color="default" class="mr-3" @click="sendStep(3)">Voltar</v-btn>
  <v-btn class="ml-3 mr-3 green white--text" :disabled="invalid" @click="sendSubmit()"> Salvar</v-btn>
  </ValidationObserver>
</v-stepper-content>
</template>

<script>
import moment from 'moment'

export default {
  data(){
    return {
      notificacao: '',
      step: 1,
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
      rulesPeriodo: [value => !!value || 'Esse campo é obrigatório.']
    }
  },
  created(){
    this.date = '1996-06-05'
  },
  computed: {
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
  methods:{
    sendStep(value){
      this.$emit('handleStep', value)
    },
    sendSubmit(value){
      let payload = {
        objetivosProfissionais: this.objetivosProfissionais,
        areaAtuacao: this.areaAtuacao,
        pretensaoSalarial: this.pretensaoSalarial,
        nivelEscolaridade: this.nivelEscolaridade,
        qualificacoes: this.qualificacoes,
        experiencias: this.experiencias,
        experiênciasEscluidas:this.experienciasExluidas
      }
      this.$emit('handleSubmit', true)
      this.$emit('handlePayload', payload)
    },
    adicionarExperiencia(){
      let payload = {
        'dataInicial': this.dataInicial,
        'dataInicialFormatada': this.dataInicialFormatada,
        'dataFinal': this.dataFinal,
        'dataFinalFormatada': this.dataFinalFormatada,
        'descricaoExperiencia': this.descricaoExperiencia
      }
      let experiencias = this.experiencias,
          isDuplicate = false

      isDuplicate = experiencias.map(value => {
        if(value.descricaoExperiencia == payload.descricaoExperiencia && value.dataInicial == payload.dataInicial && value.dataFinal == payload.dataFinal){
          return true
        }
      })

      if(isDuplicate == false){
        this.experiencias.push(payload)
        this.notificacao = ''
      }else{
        this.notificacao = 'Você já adicionou essa experiência!'
      }
    },
    removerExperiencia(indexExperiencia){
      let filteredExperiencias = this.experiencias.filter((experiencia, index) => {
        return index != indexExperiencia
      })
      let excluidas = this.experiencias.filter((experiencia, index) => {
        return index == indexExperiencia
      })


      this.experiencias = filteredExperiencias
    }
  }
}
</script>

<style scoped lang="stylus">
  .teste
    display: block
</style>
