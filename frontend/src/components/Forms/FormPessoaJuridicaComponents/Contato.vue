<template>
<v-stepper-content step="2">
<v-card flat class="mb-12" color="white darken-1">
  <v-card-text>
      <v-icon size="45">fas fa-phone</v-icon>
      <v-row align="center" justify="center">
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Telefone Fixo" rules="regex:^\([0-9]{2}\)[0-9]{4}\-[0-9]{4}$">
            <v-text-field
              v-model="fixo"
              :error-messages="errors"
              v-mask="'(##)####-####'" 
              maxlength="13"
              label="Telefone Fixo"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Telefone Celular" rules="required|regex:^\([0-9]{2}\)[0-9]{5}\-[0-9]{4}$">
            <v-text-field
              v-model="celular"
              v-mask="'(##)#####-####'"
              maxlength="14"
              :error-messages="errors"
              label="Telefone Celular *"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="LinkedIn" rules="max:250">
            <v-text-field
              v-model="linkedin"
              :error-messages="errors"
              label="LinkedIn"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Facebook" rules="max:250">
            <v-text-field
              v-model="facebook"
              :error-messages="errors"
              label="Facebook"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Twitter" rules="max:250">
            <v-text-field
              v-model="twitter"
              :error-messages="errors"
              label="Twitter"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Site" rules="max:250">
            <v-text-field
              v-model="site"
              :error-messages="errors"
              label="Site"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
      </v-row>
  </v-card-text>
  <v-card-actions><small class="red--text">* Campo obrigatório</small></v-card-actions>
  <v-btn color="default" class="mr-3" @click="sendStep(1)">Voltar</v-btn>
  <v-btn color="primary" @click="sendStep(3)">Próximo</v-btn>
</v-card>
</v-stepper-content>
</template>

<script>
import {mask} from 'vue-the-mask'
import {mapState} from 'vuex'
export default {
  props: {
    edicao: Boolean
  },
  data(){
    return {
      step: 1,
      fixo: '',
      celular: '',
      linkedin: '',
      facebook: '',
      site: '',
      twitter: ''
    }
  },
  directives: {mask},
  created(){
    if(this.edicao){
      this.loadDataToEdit()
    }
  },
  computed: {
    ...mapState(['pessoaJuridicaInfo'])
  },
  methods: {
    loadDataToEdit(){
      this.fixo = this.pessoaJuridicaInfo.contato.fixo
      this.celular = this.pessoaJuridicaInfo.contato.celular
      this.linkedin = this.pessoaJuridicaInfo.contato.linkedin
      this.facebook = this.pessoaJuridicaInfo.contato.facebook
      this.twitter = this.pessoaJuridicaInfo.contato.twitter
      this.site = this.pessoaJuridicaInfo.contato.site
    },
    sendStep(value){
       let payload = {
        fixo: this.fixo,
        celular: this.celular,
        linkedin: this.linkedin,
        facebook: this.facebook,
        site: this.site, 
        twitter: this.twitter
      }
      this.$emit('handlePayload', payload)
      this.$emit('handleStep', value)
    }
  }
}
</script>