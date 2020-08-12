<template>
  <v-row class="fill-height" align="center" justify="center">
    <v-col cols="10" md="8" sm="10" xs="2">
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-card class="mx-auto" max-width="800" align="center" justify="center">
          <v-card-text class="pa-10">
            <v-form>
              <h2 class="mt-3">Dados</h2>
              <v-text-field
                label="Email"
                name="email"
                prepend-icon="mdi-email"
                type="email"
              ></v-text-field>
              <v-text-field
                label="CPF"
                name="cpf"
                prepend-icon="mdi-file-document-edit"
                type="text"
              ></v-text-field>
              <v-divider></v-divider>
              <h2 class="mt-3">Segurança</h2>
              <v-text-field
                id="password"
                label="Senha Atual"
                name="senha"
                prepend-icon="mdi-lock"
                type="password"
              ></v-text-field>
               <v-text-field
                id="password"
                label="Nova Senha"
                name="senha"
                prepend-icon="mdi-lock"
                type="password"
              ></v-text-field>
          </v-form>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn class="ml-1" color="success darken-1" @click="dialog = false">Salvar</v-btn>              
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>