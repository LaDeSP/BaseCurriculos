<template>
<v-card flat class="mb-12" color="white darken-1">
  <v-card-text>
      <ValidationObserver ref="observer" v-slot="{ validate, reset }">
      <v-icon size="45" class="mb-4">fas fa-file-alt</v-icon>
      <ValidationProvider v-slot="{ errors }" name="Name" rules="required|max:10">
        <v-textarea
          name="Objetivos Profissionais"
          label="Objetivos Profissionais *"
          v-model="objetivosProfissionais"
          outlined
        ></v-textarea>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="select" rules="required">
        <v-select
          class="mt-0"
          v-model="areaAtuacao"
          :items="itemsGeneros"
          :error-messages="errors"
          label="Área de Atuação *"
          required
        ></v-select>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="Name" rules="required|max:10">
        <v-text-field
          class="mt-3"
          v-model="name"
          :counter="10"
          :error-messages="errors"
          label="Pretensão Salarial *"
          required
        ></v-text-field>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="select" rules="required">
        <v-select
          class="mt-3"
          v-model="estadoCivil"
          :items="itemsEstadoCivil"
          :error-messages="errors"
          label="Nível de Escolaridade *"
          required
        ></v-select>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="Name" rules="required|max:10">
        <v-textarea
          class="mt-3"
          name="Qualificações"
          label="Qualificações *"
          v-model="qualificacoes"
          hint="Insira sua formação, seus cursos, qualidades, etc."
          outlined
        ></v-textarea>
      </ValidationProvider>
    <v-row align="center" justify="center">
      <v-col cols="12" md="4">
        <ValidationProvider name="date" :rules="'required'" v-slot="{errors}" slim>
          <v-menu
            ref="menu"
            v-model="menu1"
            :close-on-content-click="false"
            transition="scale-transition"
            offset-y
            max-width="290px"
            min-width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="dateFormated"
                label="Data Inicial"
                persistent-hint
                append-outer-icon="fa-calendar"
                v-bind="attrs"
                @blur="date = parseDate(dateFormatted)"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker locale="pt-br" v-model="date1" no-title @input="menu1 = false"></v-date-picker>
          </v-menu>
        </ValidationProvider>
      </v-col>
      <v-col cols="12" md="4">
        <ValidationProvider name="date" :rules="'required'" v-slot="{errors}" slim>
          <v-menu
            ref="menu"
            v-model="menu2"
            :close-on-content-click="false"
            transition="scale-transition"
            offset-y
            max-width="290px"
            min-width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="dateFormated2"
                label="Data Final"
                persistent-hint
                append-outer-icon="fa-calendar"
                v-bind="attrs"
                @blur="date = parseDate(dateFormatted)"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker locale="pt-br" v-model="date2" no-title @input="menu2 = false"></v-date-picker>
          </v-menu>
        </ValidationProvider>
      </v-col>
      <v-col cols="12" md="4">
        <ValidationProvider name="date" :rules="'required'" v-slot="{errors}" slim>
          <v-text-field
            label="Experiência"
            :error-messages="errors"
            required
          ></v-text-field>
        </ValidationProvider>
      </v-col>
      <v-col cols="12" md="10">
        <v-btn color="info accent-3 white--text mb-4">Adicionar</v-btn>
        <v-expansion-panels>
          <v-expansion-panel>
            <v-expansion-panel-header>Experiências</v-expansion-panel-header>
            <v-expansion-panel-content>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>
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
      date1: '',
      date2: '',
      menu1: false,
      menu2: false,
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
      return moment(this.date1).format('DD/MM/YYYY')
    },
    dateFormated2(){
      return moment(this.date2).format('DD/MM/YYYY')
    }
  }
}
</script>