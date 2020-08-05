<template>
<v-card flat class="mb-12" color="white darken-1">
  <v-card-text>
      <ValidationObserver ref="observer" v-slot="{ validate, reset }">
      <v-icon size="45">fas fa-phone</v-icon>
      <v-row align="center" justify="center">
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Telefone Fixo" rules="required|max:10">
            <v-text-field
              v-model="fixo"
              :counter="10"
              :error-messages="errors"
              label="Telefone Fixo"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Telefone Celular" rules="required|max:10">
            <v-text-field
              v-model="celular"
              :counter="10"
              :error-messages="errors"
              label="Telefone Celular *"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="LinkedIn" rules="required|max:10">
            <v-text-field
              v-model="linkedin"
              :counter="10"
              :error-messages="errors"
              label="LinkedIn"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Facebook" rules="required|max:10">
            <v-text-field
              v-model="facebook"
              :counter="10"
              :error-messages="errors"
              label="Facebook"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Twitter" rules="required|max:10">
            <v-text-field
              v-model="twitter"
              :counter="10"
              :error-messages="errors"
              label="Twitter"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Site" rules="required|max:10">
            <v-text-field
              v-model="site"
              :counter="10"
              :error-messages="errors"
              label="Site"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
      </v-row>
    </ValidationObserver>
  </v-card-text>
  <v-card-actions><small class="red--text">* Campo obrigatório</small></v-card-actions>
</v-card>
</template>

<script>
import moment from 'moment'
export default {
  data(){
    return {
      step: 1,
      date: '',
      menu: false,
      genero: '',
      itemsGeneros: [
        'Feminino',
        'Masculino',
        'Não-binário'
      ],
      itemsEstadoCivil: [
        'Solteiro',
        'Casado',
        'Separado',
        'Viúvo'
      ]

    }
  },
  created(){
    this.date = '1996-06-05'
  },
  computed: {
    dateFormated(){
      return moment(this.date).format('DD/MM/YYYY')
    }
  }
}
</script>