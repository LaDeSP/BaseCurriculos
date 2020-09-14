<template>
  <v-card v-if="juridicaPatrocinadoras.length > 0" elevation="24" max-width="800" height="400" class="mx-auto mt-10">
    <v-window v-model="window" class="elevation-1" :show-arrows="showArrows">
      <v-window-item v-for="patrocinador in juridicaPatrocinadoras" :key="patrocinador.id">
        <v-card flat min-height="400">
          <v-img height="300" max-height="300" :src="getPicPath(patrocinador.user.foto)"></v-img>
          <v-card-title class="primary--text text-center justify-center text-capitalize"><h2>{{patrocinador.user.name}}</h2></v-card-title>
          <v-card-text class="text-center justify-center" v-if="patrocinador.endereco != null">
            <p>{{patrocinador.endereco.cidade}} - {{patrocinador.endereco.estado}}</p>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
  </v-card>
</template>

<script>
import {mapState} from 'vuex'
export default {
  data() {
    return {
      window: 0,
      showArrows: true,
      length: 0,
      autorun: true
    }
  },
  created (){
    this.length = this.juridicaPatrocinadoras.length
    setInterval(() => {
      if (++this.window >= this.length) this.window = 0
    }, 3000)
  },
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