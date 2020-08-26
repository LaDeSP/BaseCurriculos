<template>
<v-stepper-content :rules="[() => !errors.has('name') && !erros.has('nascimento')]" step="1">
<v-card flat color="white darken-1" v-if="isLoaded">
  <v-card-text>
      <v-icon size="45" class="mb-4">fas fa-file-invoice-dollar</v-icon>
      <ValidationProvider v-slot="{ errors }" name="titulo" rules="required|max:250">
        <v-text-field 
          v-model="titulo"
          :error-messages="errors"
          label="Título *"
          maxlength="250"
          required
        ></v-text-field>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="descricao" rules="required|max:5000">
        <v-textarea class="mt-3"
          name="Descrição"
          label="Descrição *"
          :error-messages="errors"
          maxlength="5000"
          v-model="descricao"
          outlined
        ></v-textarea>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="cargo" rules="required|max:250">
        <v-text-field 
          :error-messages="errors"
          name="cargo" 
          v-model="cargo" 
          maxlength="250"
          label="Cargo *"
          required
        ></v-text-field>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="pretensaoSalarial" rules="required|numeric|min_value:1|integer">
        <v-text-field
          class="mt-3"
          type="number"
          v-model="quantidade"
          :error-messages="errors"
          label="Quantidade de Vagas *"
          required
        ></v-text-field>
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
      <ValidationProvider v-slot="{ errors }" name="salario" rules="max:250">
        <v-text-field 
          maxlength="250"
          v-model="salario"
          :error-messages="errors"
          label="Salário"
          required
        ></v-text-field>
      </ValidationProvider>
  </v-card-text>
  <v-card-actions><small class="red--text">* Campo obrigatório</small></v-card-actions>
   <v-btn color="primary" @click="sendStep(2)">Próximo</v-btn>
</v-card>
</v-stepper-content>
</template>

<script>
import {mapGetters} from 'vuex'
import {mutationTypes, actionTypes} from '@/core/constants'

export default {
  props: {
    edicao: Boolean,
    vaga: Object,
    isLoaded: Boolean
  },
  data(){
    return {
      step: 1,
      titulo: '',
      descricao: '',
      cargo: '',
      quantidade: 0,
      salario: '',
      areaAtuacao: '',
      itemsAreaAtuacao: []
    }
  },
  async created(){
    await this.$store.dispatch(actionTypes.GET_AREAS)
      .then(response => {
        this.itemsAreaAtuacao = response.areas
      }) 
    if(this.edicao) await this.loadDataToEdit()
    console.log('mercy', this.isLoaded)
  },
  computed: {
    ...mapGetters(['getVagaById']),
    vagaById(){
      return this.getVagaById(this.vagaId)
    }
  },
  methods: {
    sendStep(value){
      let payload = {
        titulo: this.titulo,
        descricao: this.descricao,
        cargo: this.cargo,
        quantidade: this.quantidade,
        salario: this.salario,
        area: this.areaAtuacao,
      }
      this.$emit('handlePayload', payload)
      this.$emit('handleStep', value)
    },
    async loadDataToEdit(){
      this.titulo = this.vaga.titulo 
      this.descricao = this.vaga.descricao
      this.cargo = this.vaga.cargo 
      this.quantidade = this.vaga.quantidade 
      this.salario = this.vaga.salario
      this.areaAtuacao = this.vaga.area.id
    }
  }
}
</script>