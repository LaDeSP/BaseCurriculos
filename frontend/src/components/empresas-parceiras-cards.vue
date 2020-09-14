<template>
  <v-sheet class="mx-auto mt-4" max-width="1500">
    <v-slide-group class="pa-4" show-arrows>
      <v-slide-item v-for="patrocinador in juridicaPatrocinadoras" :key="patrocinador.id" v-slot:default="{active, toggle}">
        <v-card class="ma-4" width="300" elevation="8">
          <v-img class="white--text align-end" height="200px" :src="getPicPath(patrocinador.user.foto)">
              <v-card-title class="black--text font-weight-bold text-capitalize">{{patrocinador.user.name}}</v-card-title>
            </v-img>
            <v-card-text class="text--primary">
             {{patrocinador.endereco.cidade}} - {{patrocinador.endereco.estado}}
            </v-card-text>
        </v-card>
      </v-slide-item>
    </v-slide-group>
  </v-sheet>
</template>

<script>
import {mapState} from 'vuex'
export default {
  computed: {
    ...mapState(['juridicaPatrocinadoras'])
  },
  methods: {
    getPicPath(foto){
      if(foto == null){
        return 'http://localhost:8000/anon.jpg'
      }else{
        return `http://localhost:8000/storage/${foto.path}`
      }
    }
  }
}
</script>