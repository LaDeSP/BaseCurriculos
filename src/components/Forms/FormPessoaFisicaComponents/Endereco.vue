<template>
<v-card flat class="mb-12" color="white darken-1">
  <v-card-text>
      <ValidationObserver ref="observer" v-slot="{ validate, reset }">
      <v-icon size="45">fas fa-map-marker-alt</v-icon>
      <v-row align="center" justify="center">
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="CEP *" rules="required|max:10">
            <v-text-field
              v-model="fixo"
              :counter="10"
              :error-messages="errors"
              label="CEP *"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
           <ValidationProvider v-slot="{ errors }" name="select" rules="required">
            <v-select
              v-model="estado"
              :items="itemsEstado"
              :error-messages="errors"
              label="Estado *"
              required
            ></v-select>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Cidade *" rules="required|max:10">
            <v-text-field
              v-model="fixo"
              :counter="10"
              :error-messages="errors"
              label="Cidade *"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Bairro *" rules="required|max:10">
            <v-text-field
              v-model="fixo"
              :counter="10"
              :error-messages="errors"
              label="Bairro *"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Rua *" rules="required|max:10">
            <v-text-field
              v-model="fixo"
              :counter="10"
              :error-messages="errors"
              label="Rua *"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Número" rules="required|max:10">
            <v-text-field
              v-model="fixo"
              :counter="10"
              :error-messages="errors"
              label="Número"
              required
            ></v-text-field>
          </ValidationProvider>
        </v-col>
        <v-col cols="12" md="6">
          <ValidationProvider v-slot="{ errors }" name="Complemento" rules="required|max:10">
            <v-text-field
              v-model="fixo"
              :counter="10"
              :error-messages="errors"
              label="Complemento"
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