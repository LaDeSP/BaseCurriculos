<template>
  <v-row class="fill-height" align="center" justify="center">
    <v-col cols="10" md="8" sm="10" xs="2">
      <v-card class="mx-auto" flat max-width="800" align="center" justify="center">
        <h1><strong>Carregando...</strong></h1>
        <v-progress-circular class="my-10" :size="50" color="primary" indeterminate></v-progress-circular>
      </v-card>
    </v-col>
  </v-row>
</template>