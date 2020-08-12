<template>
 <v-row class="fill-height" align="center" justify="center">
    <v-col cols="10" md="12" sm="10" xs="2">
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-card align="center">
        <v-card-title class="text-center justify-center py-6">
          <h1>Candidaturas</h1> 
        </v-card-title>
        <v-row class="justify-space-between my-5 mr-2 ml-2">
          <v-col md="4">
            <v-card class="py-5 my-5">
              <v-card-title>Titulo deste</v-card-title>
              <v-card-text>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus impedit, sint adipisci quo hic, quidem reiciendis ea praesentium nesciunt eaque vero repellendus aliquid eum distinctio ullam in dicta maiores sed?</v-card-text>
              <v-card-actions class="justify-center text-center">
                <v-btn class="default">Ver Candidatos</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
          <v-col md="4">
            <v-card class="py-5 my-5">
              <v-card-title>Titulo deste</v-card-title>
              <v-card-text>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus impedit, sint adipisci quo hic, quidem reiciendis ea praesentium nesciunt eaque vero repellendus aliquid eum distinctio ullam in dicta maiores sed?</v-card-text>
              <v-card-actions class="justify-center text-center">
                <v-btn class="default">Ver Candidatos</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
          <v-col md="4">
            <v-card class="py-5 my-5">
              <v-card-title>Titulo deste</v-card-title>
              <v-card-text>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus impedit, sint adipisci quo hic, quidem reiciendis ea praesentium nesciunt eaque vero repellendus aliquid eum distinctio ullam in dicta maiores sed?</v-card-text>
              <v-card-actions class="justify-center text-center">
                <v-btn class="default">Ver Candidatos</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
          <v-col>
            <v-card>
              <v-list>
              <v-list-item-group color="primary">
                <v-list-item>
                  <v-list-item-content>
                    <h2 align="left">Lana Banana 
                    <v-responsive 
                      class="text-center rounded-pill info d-inline-flex align-center justify-center ml-2"
                      height="30"
                      width="100"
                    ></v-responsive></h2> 
                      IOI OIDOEJFOE JOE OI EU SOU O GOKU
                      <DetalhesCandidato></DetalhesCandidato>
                  </v-list-item-content>
                </v-list-item>
                 <v-list-item>
                  <v-list-item-content>
                    <h2 align="left">Sansinha</h2>
                      IOI OIDOEJFOE JOE OI EU SOU O GOKU
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-content>
                    <h2 align="left">Godinha</h2>
                      IOI OIDOEJFOE JOE OI EU SOU O GOKU
                  </v-list-item-content>
                </v-list-item>
              </v-list-item-group>
            </v-list>
            </v-card>
          </v-col>
        </v-row>
      </v-card>
    </v-col>
 </v-row>
</template>

<script>
import DetalhesCandidato from '../Display/DisplayDetalhesCandidato'
export default {
  components: {DetalhesCandidato}
}
</script>

