<template>
  <v-card class="mt-3 mx-auto elevation-6" max-width="570" align="center" justify="center">
    <v-card-title class="default--text">
        Processos em Andamento
    </v-card-title>
    <v-card-text class="black--text">
        <v-row>
          <template v-if="progressBar.length == 0">
            <span style="font-size: 20px">Não há nenhuma vaga ativa no momento.</span>
          </template>
          <template v-else>
            <v-col cols="12" lg="12" md="12" sm="12" v-for="vaga in pageOfItems" :key="vaga.id">
              <p>
                <span style="float: left">{{vaga.titulo}}</span>
                <span style="float: right">Vagas: {{vaga.quantidade}} 
                  | {{vaga.quantidade - vaga.quantidadeContratados}} 
                  <template v-if="vaga.quantidade - vaga.quantidadeContratados > 1">
                    restantes
                  </template>
                  <template v-else>
                    restante
                  </template>
                </span>
              </p>
              <v-progress-linear
                :value="vaga.porcentagem"
                color="green"
                height="15"
                class="mt-6"
              ></v-progress-linear>
            </v-col>
            <v-row align="center" justify="center">
              <v-col >
                <template v-if="progressBar.length > 4">
                  <jw-pagination 
                    :items="progressBar"
                    @changePage="onChangePage"
                    :pageSize="4"
                    :labels="customLabels"
                  ></jw-pagination>
                </template>
                <template v-else>
                  <span style="display: none" >
                    <jw-pagination 
                      :items="progressBar" 
                      @changePage="onChangePage"
                      :pageSize="4" 
                      :labels="customLabels"
                    ></jw-pagination>
                  </span>
                </template>
              </v-col>
            </v-row>
          </template>
        </v-row>
    </v-card-text> 
  </v-card>
</template>

<script>
import {mapState} from 'vuex'
const customLabels = {
  next: '>',
  previous: '<'
}
export default {
  data() {
    return {
      pageOfItems: [],
      customLabels
    }
  },
  computed: {
    ...mapState(['progressBar'])
  },
  methods: {
    onChangePage(pageOfItems) {
      this.pageOfItems = pageOfItems;
    }
  }
}
</script>
