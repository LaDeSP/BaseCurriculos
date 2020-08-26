<template>
  <v-img
    min-height="250"
    max-height="250"
    contain
    :src="fotoLocal.path"
    :alt="fotoLocal.filename"
  ></v-img>
</template>

<script>
export default {
  data() {
    return {
      fotoLocal: ''
    }
  },
  props: {
    foto: Object
  },
  created(){
    this.fotoLocal = this.foto 
    if(this.fotoLocal == null){
      this.fotoLocal = {
        'path': 'http://localhost:8000/anon.jpg',
        'filename': 'anon'
      }
    }else{
      let path = this.fotoLocal.path 
      this.fotoLocal.path = `http://localhost:8000/storage/${path}`
    }
  }
}
</script>