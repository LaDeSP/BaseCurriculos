<template>
<v-card flat class="mb-12" color="white darken-1">
  <v-card-text>
      <ValidationObserver ref="observer" v-slot="{ validate, reset }">
      <v-icon size="45">far fa-address-card</v-icon>
      <ValidationProvider v-slot="{ errors }" name="Name" rules="required|max:10">
        <v-text-field
          v-model="name"
          :counter="10"
          :error-messages="errors"
          label="Nome Completo *"
          required
        ></v-text-field>
      </ValidationProvider>
      <ValidationProvider name="date" :rules="'required'" v-slot="{errors}" slim>
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
              label="Data de Nascimento"
              persistent-hint
              append-outer-icon="fa-calendar"
              v-bind="attrs"
              @blur="date = parseDate(dateFormatted)"
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker locale="pt-br" v-model="date" no-title @input="menu = false"></v-date-picker>
        </v-menu>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="select" rules="required">
        <v-select
          v-model="genero"
          :items="itemsGeneros"
          :error-messages="errors"
          label="Gênero *"
          required
        ></v-select>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="select" rules="required">
        <v-select
          v-model="estadoCivil"
          :items="itemsEstadoCivil"
          :error-messages="errors"
          label="Estado Civil *"
          required
        ></v-select>
      </ValidationProvider>
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