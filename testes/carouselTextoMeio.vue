<template>
    <v-carousel hide-delimiters>
      <h1>Seja Bem-Vindo ao BDC!</h1>
      <v-carousel-item 
        v-for="(item, i) in items"
        :key="i"
        :src="item.src"
      > 
      <v-row class="fill-height" align="center" justify="center">
        <v-col>
          <v-card color="red" class="pa-2" align="center">
          <span class="headline white--text">Seja Bem-Vindo ao BDC!</span>
          </v-card>
        </v-col>
      </v-row></v-carousel-item>
    </v-carousel>
</template>

<script>

export default {
  data(){
    return{
      items: [
        {
          src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg'
        },
        {
          src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg',
        },
        {
          src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg',
        },
        {
          src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg',
        },
      ]
    }
  }
}
</script>
