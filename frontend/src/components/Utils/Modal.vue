<template>
<div class="modal " tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <slot name="header">
          <h5 class="modal-title" id="exampleModalLabel" >Eu sou a header.</h5>
        </slot>
        <button @click="close" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <slot name="body">
          <p>Sou o body.</p>
        </slot>
      </div>
      <br>

        <slot name="footer">

        </slot>

    </div>
  </div>
</div>
</template>
<script>

  export default {
    name: 'modal',
    methods: {
      close(){
        this.$emit('close');
      }
    }
  }

</script>

