<template>
<v-stepper-content step="3">
<v-card flat class="mb-12" color="white darken-1">
  <v-card-text>
      <v-icon size="45">fas fa-map-marker-alt</v-icon>
      <v-row align="center" justify="center">
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="cep" rules="required|numeric|digits:8">
            <v-text-field
              v-model="cep"
              v-on:keyup="buscar"
              :counter="8"
              minlength="8" 
              maxlength="8"
              :error-messages="errors"
              label="CEP *"
              required
            ></v-text-field>
          </ValidationProvider>
          <span v-if="teste">
            dialog: {{pleaseWaitDialog}} 
          </span>
          <template v-if="pleaseWaitDialog">
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
        </v-col>
        <v-col cols="12" md="6">
           <ValidationProvider v-slot="{ errors }" name="select" rules="required">
            <v-select
              v-model="estado"
              :items="itemsEstado"
              item-text="text"
              item-value="shortcode"
              :error-messages="errors"
              label="Estado *"
              required
            ></v-select>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="cidade" rules="required|max:250">
            <v-text-field
              v-model="cidade"
              maxlength="250"
              :error-messages="errors"
              label="Cidade *"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="bairro" rules="required|max:250">
            <v-text-field
              v-model="bairro"
              :error-messages="errors"
              label="Bairro *"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="rua" rules="required|max:250">
            <v-text-field
              v-model="rua"
              :error-messages="errors"
              label="Rua *"
              maxlength="250"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="numero" rules="max:250">
            <v-text-field
              v-model="numero"
              :error-messages="errors"
              label="Número"
              maxlength="250"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Complemento" rules="max:250">
            <v-text-field
              v-model="complemento"
              :error-messages="errors"
              label="Complemento"
              required
              maxlength="250"
            ></v-text-field>
          </ValidationProvider>
        </v-col>
      </v-row>
  </v-card-text>
  <v-card-actions><small class="red--text">* Campo obrigatório</small></v-card-actions>
  <v-btn color="default" class="mr-3" @click="sendStep(2)">Voltar</v-btn>
  <v-btn color="primary" @click="sendStep(4)">Próximo</v-btn>
</v-card>
</v-stepper-content>
</template>

<script>
import {mapState} from 'vuex'
import moment from 'moment'
export default {
  props: {
    edicao: Boolean
  },
  data(){
    return {
      step: 1,
      teste: false,
      pleaseWaitDialog: false,
      cep: '',
      estado: '',
      itemsEstado: [
          {shortcode: "AC", text: 'Acre'},
          {shortcode: "AL", text: 'Alagoas'},
          {shortcode: "AP", text: 'Amapá'},
          {shortcode: "AM", text: 'Amazonas'},
          {shortcode: "BA", text: 'Bahia'},
          {shortcode: "CE", text: 'Ceará'},
          {shortcode: "DF", text: 'Distrito Federal'},
          {shortcode: "ES", text: 'Espírito Santo'},
          {shortcode: "GO", text: 'Goiás'},
          {shortcode: "MA", text: 'Maranhão'},
          {shortcode: "MT", text: 'Mato Grosso'},
          {shortcode: "MS", text: 'Mato Grosso do Sul'},
          {shortcode: "MG", text: 'Minas Gerais'},
          {shortcode: "PA", text: 'Pará'},
          {shortcode: "PB", text: 'Paraíba'},
          {shortcode: "PR", text: 'Paraná'},
          {shortcode: "PE", text: 'Pernambuco'},
          {shortcode: "PI", text: 'Piauí'},
          {shortcode: "RJ", text: 'Rio de Janeiro'},
          {shortcode: "RN", text: 'Rio Grande do Norte'},
          {shortcode: "RS", text: 'Rio Grande do Sul'},
          {shortcode: "RO", text: 'Rondônia'},
          {shortcode: "RR", text: 'Roraima'},
          {shortcode: "SC", text: 'Santa Catarina'},
          {shortcode: "SP", text: 'São Paulo'},
          {shortcode: "SE", text: 'Sergipe'},
          {shortcode: "TO", text: 'Tocantins'}
      ],
      cidade: '',
      bairro: '',
      rua: '',
      complemento: '',
      numero: ''

    }
  },
  created(){
    if(this.edicao){
      this.loadDataToEdit()
    }
  },
  computed: {
    ...mapState(['pessoaFisicaInfo'])
  },
  methods: {
    loadDataToEdit(){
      this.cep = this.pessoaFisicaInfo.endereco.cep
      this.estado = this.pessoaFisicaInfo.endereco.estado
      this.cidade = this.pessoaFisicaInfo.endereco.cidade
      this.bairro = this.pessoaFisicaInfo.endereco.bairro
      this.rua = this.pessoaFisicaInfo.endereco.rua
      this.complemento = this.pessoaFisicaInfo.endereco.complemento
      this.numero = this.pessoaFisicaInfo.endereco.numero
    },
    sendStep(value){
       let payload = {
        cep: this.cep,
        estado: this.estado,
        cidade: this.cidade,
        bairro: this.bairro,
        rua: this.rua,
        numero: this.numero,
        complemento: this.complemento
      }
      this.$emit('handlePayload', payload)
      this.$emit('handleStep', value)
    },
    buscar(){
      var self = this
      this.teste = true
      self.naoLocalizado = false
      if(/^[0-9]{5}[0-9]{3}$/.test(this.cep)){
          this.pleaseWaitDialog = true 
          $.getJSON("https://viacep.com.br/ws/" + this.cep + "/json/", function(endereco){
            if(endereco.erro){
                $("#rua").focus()
                self.naoLocalizado = true
                self.pleaseWaitDialog = false
                return
            }
            self.rua = endereco.logradouro
            self.bairro = endereco.bairro
            self.cidade = endereco.localidade
            self.estado = endereco.uf
            self.pleaseWaitDialog = false
          })
      }
    }
  }
}
</script>