<template>

<div class="card">
  <div class="card-header">
    <slot name="card-header">
    </slot>
  </div>
  <div class="card-body">
    <slot name="thumbnail" v-if="thumbnail">
      <img class="card-img-top img-thumbnail img-fluid" :src=FotoLocal.path :alt=FotoLocal.filename>
    </slot>
    <slot name="card-body">
    </slot>
  </div>
  <div class="card-footer">
    <slot name="card-footer">
    </slot>
  </div>
</div>

</template>

<script>

  export default {
    name: 'card',
    data(){
      return {
        FotoLocal: ''
      }
    },

    props: {
      foto: {
        type: Object,
      },
      thumbnail: Boolean

    },
    created(){
      this.FotoLocal=this.foto;
      
      if(this.FotoLocal==null){
        let foto = {
          'path': "http://localhost:8000/anon.jpg",
          'filename': 'anon'
        }
        this.FotoLocal = foto;
      }
      else{
        var path = this.FotoLocal.path;
        this.FotoLocal.path = "http://localhost:8000/storage/" + path;
        console.log(this.FotoLocal.path)
      }
      
    }
  }

</script>

