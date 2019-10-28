<template>
  <div class="input-group col-md-11">
    <input class="form-control py-2" type="search" placeholder="Digite aqui.." v-model="keywords">
    <span class="input-group-append">
      <button class="btn btn-outline-secondary" type="button" @click="redirect" v-on:keyup.enter="redirect">
          <i class="fa fa-search"></i>
      </button>
    </span>
  </div>
</template>

<script>

  export default {
    name: 'BarraBusca',
    data(){
      return{
        keywords: '',
      }
    },
    methods: {
      redirect(){
          this.$router.push({ name: 'buscas',  params: {keywords : this.keywords} })
      }
    },
  }

</script>
