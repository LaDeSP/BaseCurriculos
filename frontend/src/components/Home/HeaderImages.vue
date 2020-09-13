<template>
  <v-carousel hide-delimiters height="60vh">
    <v-carousel-item
      eager 
      v-for="(item, i) in items"
      :key="i"
      :src="item.src"
    > 
      <v-row class="fill-height" align="center" justify="center">
        <v-col>
          <h1 class="text-center">Bem-Vindo ao Corumbá Jobs!</h1>
        </v-col>
    </v-row>
    </v-carousel-item>
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
</script>