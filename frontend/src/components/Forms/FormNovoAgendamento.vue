<template>
<v-card flat class="mb-12" color="white darken-1">
  <form>
  <v-card-title class="justify-center text-center"><h2>Agendar Entrevista</h2></v-card-title>
  <v-card-text>
      <ValidationObserver ref="observer" v-slot="{ validate, reset }">
      <ValidationProvider name="date" :rules="required" v-slot="{errors}" slim>
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
        <v-menu
          ref="menu"
          v-model="menu2"
          :close-on-content-click="false"
          :nudge-right="40"
          :return-value.sync="time"
          transition="scale-transition"
          offset-y
          max-width="290px"
          min-width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="time"
              label="Hora *"
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
            v-model="time"
            full-width
            @click:minute="$refs.menu.save(time)"
          ></v-time-picker>
        </v-menu>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="Name" rules="required|max:10">
        <v-textarea
          name="Observação"
          label="Observação"
          v-model="objetivosProfissionais"
          persistent-hint
          hint="Use esse campo para falar dados de contato e localização, enviar links de videoconferência, bem como qualquer outra informação importante."
          outlined
        ></v-textarea>
      </ValidationProvider>
      </ValidationObserver>
      <small class="red--text">* Campo obrigatório</small>
  </v-card-text>
  <v-card-actions>
    <v-btn outlined color="grey">Voltar</v-btn>
    <v-spacer></v-spacer>
    <v-btn color="success" @click="submit">Salvar</v-btn>
  </v-card-actions>
  </form>
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