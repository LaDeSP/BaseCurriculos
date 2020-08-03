<template>
  <v-card class="borda-card mt-3 mx-auto elevation-6" max-width="800" align="center" justify="center">
    <v-card-title class="default--text">
        Processos em Andamento
    </v-card-title>
    <v-card-text>
        <v-row>
          <v-col>
              <p>
                <span style="float: left">"Desenvolvimento PHP"</span>
                <span style="float: right">Vagas: 10 | 1 restante</span>
              </p>
              <v-progress-linear
                v-model="progressoVagas"
                color="green"
                height="15"
                class="mt-6"
              ></v-progress-linear>
          </v-col>
        </v-row>
    </v-card-text> 
  </v-card>
</template>

<script>
export default {
  data(){
    return{
      progressoVagas: 38
    }
  }
}
</script>

<style scoped lang="stylus">
 
</style>